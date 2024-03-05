<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class employeeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $code;
    public $sendPdf;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $code, $sendPdf)
    {
        $this->name = $name;
        $this->code = $code;
        $this->sendPdf = $sendPdf;
    }

    public function build(): Mailable
    {
        return $this->view('dashboard::mail.message')
                ->subject('QR Absensi Karyawan')
                ->attachData(base64_decode($this->sendPdf), "{$this->code} - {$this->name}.pdf", [
                    'mime' => 'application/pdf',
                ]);                    
    }
}
