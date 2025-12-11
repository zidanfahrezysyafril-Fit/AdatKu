<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class File extends Model
{
    use HasUuids;

    protected $fillable = [
        'alias',
        'filename',
        'path',      // simpan path relatif dari public, contoh: "uploads/files/xxx.jpg"
        'mime_type',
        'size',
    ];

    /**
     * Relasi polymorphic (fileable).
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * URL untuk stream file (lihat di route 'files.action').
     */
    public function getFileStreamAttribute()
    {
        return route('files.action', [
            'id'     => $this->id,
            'action' => 'stream',
        ]);
    }

    /**
     * URL untuk download file.
     */
    public function getFileDownloadAttribute()
    {
        return route('files.action', [
            'id'     => $this->id,
            'action' => 'download',
        ]);
    }

    /**
     * (Opsional tapi berguna) URL langsung ke file (asset).
     */
    public function getUrlAttribute()
    {
        return asset($this->path);
    }

    /**
     * Handle stream / download file dari public/uploads/...
     */
    public function handleAction($action)
    {
        // path fisik di server
        $fullPath = public_path($this->path);

        if (! file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan');
        }

        if ($action === 'stream') {
            // tampilkan langsung di browser
            return response()->file($fullPath, [
                'Content-Type' => $this->mime_type ?: mime_content_type($fullPath),
            ]);
        }

        if ($action === 'download') {
            // paksa download
            $downloadName = $this->filename ?: basename($fullPath);

            return response()->download(
                $fullPath,
                $downloadName,
                ['Content-Type' => $this->mime_type ?: mime_content_type($fullPath)]
            );
        }

        abort(400, 'Aksi tidak valid');
    }
}
