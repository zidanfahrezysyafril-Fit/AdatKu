<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Kirim pesan contact form
     */
    public function send(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'telepon' => 'nullable|string|max:20',
                'subjek' => 'required|string|max:255',
                'pesan' => 'required|string|max:5000'
            ], [
                'nama.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'subjek.required' => 'Subjek wajib diisi',
                'pesan.required' => 'Pesan wajib diisi'
            ]);

            // Simpan ke database
            $contact = ContactMessage::create($validated);

            // Kirim email ke admin
            $this->sendEmailToAdmin($validated);

            // Kirim email konfirmasi ke pengirim (opsional)
            $this->sendConfirmationEmail($validated);

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Pesan Anda telah kami terima dan akan segera kami proses.',
                'data' => [
                    'id' => $contact->id,
                    'created_at' => $contact->created_at->format('d M Y H:i')
                ]
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi atau hubungi kami melalui email langsung.'
            ], 500);
        }
    }

    /**
     * Kirim email ke admin AdatKu
     */
    private function sendEmailToAdmin($data)
    {
        try {
            Mail::raw(
                "=== PESAN BARU DARI WEBSITE ADATKU ===\n\n" .
                    "Nama: {$data['nama']}\n" .
                    "Email: {$data['email']}\n" .
                    "Telepon: " . ($data['telepon'] ?? '-') . "\n" .
                    "Subjek: {$data['subjek']}\n\n" .
                    "PESAN:\n" .
                    str_repeat("-", 50) . "\n" .
                    "{$data['pesan']}\n" .
                    str_repeat("-", 50) . "\n\n" .
                    "Dikirim pada: " . now()->format('d F Y, H:i:s') . " WIB\n" .
                    "Balas email ini untuk merespons pengirim.",
                function ($message) use ($data) {
                    $message->to('adatku11@gmail.com')
                        ->subject("[AdatKu Website] {$data['subjek']}")
                        ->replyTo($data['email'], $data['nama']);
                }
            );
        } catch (\Exception $e) {
            Log::error('Failed to send admin email: ' . $e->getMessage());
        }
    }

    /**
     * Kirim email konfirmasi ke pengirim (opsional)
     */
    private function sendConfirmationEmail($data)
    {
        try {
            Mail::raw(
                "Halo {$data['nama']},\n\n" .
                    "Terima kasih telah menghubungi AdatKu! 🙏\n\n" .
                    "Kami telah menerima pesan Anda dengan subjek:\n" .
                    "\"{$data['subjek']}\"\n\n" .
                    "Tim kami akan meninjau pesan Anda dan memberikan respons secepatnya dalam 1-2 hari kerja.\n\n" .
                    "Jika ada pertanyaan mendesak, Anda dapat menghubungi kami melalui:\n" .
                    "📧 Email: adatku11@gmail.com\n" .
                    "📱 Instagram: @_.adatku\n\n" .
                    "Salam hangat,\n" .
                    "Tim AdatKu ✨",
                function ($message) use ($data) {
                    $message->to($data['email'], $data['nama'])
                        ->subject('Terima Kasih Telah Menghubungi AdatKu')
                        ->from('adatku11@gmail.com', 'AdatKu');
                }
            );
        } catch (\Exception $e) {
            Log::error('Failed to send confirmation email: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan semua pesan (untuk admin dashboard)
     */
    public function index()
    {
        // bisa paginate atau get biasa
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        // atau:
        // $messages = ContactMessage::latest()->get();

        return view('admin.contact_messages.index', compact('messages'));
    }

    /**
     * Tandai pesan sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * Hapus pesan
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus'
        ]);
    }

    /**
     * Hitung jumlah pesan belum dibaca
     */
    public function unreadCount()
    {
        $count = ContactMessage::unread()->count();

        return response()->json([
            'count' => $count
        ]);
    }
}
