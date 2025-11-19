<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\ContactSubmission;

class ContactSubmissionResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $approved;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactSubmission $submission, bool $approved)
    {
        $this->submission = $submission;
        $this->approved = $approved;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->approved ? 'Votre soumission a été approuvée - SYNEM' : 'Votre soumission a été rejetée - SYNEM',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_submission_response',
            with: ['submission' => $this->submission, 'approved' => $this->approved],
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
