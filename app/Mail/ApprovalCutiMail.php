<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovalCutiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $category;
    public $start_at;
    public $end_at;
    public $information;

    /**
     * Create a new message instance.
     */
    public function __construct($category, $start_at, $end_at, $information)
    {
        $this->category = $category;
        $this->start_at = $start_at;
        $this->end_at = $end_at;
        $this->information = $information;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Approval Berhasil Diterima',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Dashboard::mail.approval',
            with: [
                'category' => $this->category,
                'start_at' => $this->start_at,
                'end_at' => $this->end_at,
                'information' => $this->information,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
