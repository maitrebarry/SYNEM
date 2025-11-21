<?php

namespace App\Mail;

use App\Models\Militant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MilitantApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Militant $militant;

    /**
     * Create a new message instance.
     */
    public function __construct(Militant $militant)
    {
        $this->militant = $militant;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre adhésion au SYNEM a été approuvée',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.militant_approved',
            with: ['militant' => $this->militant],
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
