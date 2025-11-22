<?php

namespace App\Mail;

use App\Models\MuaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MuaRequestStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public MuaRequest $muaRequest;

    public function __construct(MuaRequest $muaRequest)
    {
        $this->muaRequest = $muaRequest;
    }

    public function build()
    {
        return $this->subject('Status Pengajuan MUA Kamu - AdatKu')
            ->view('emails.mua.request_status_updated');
    }
}
