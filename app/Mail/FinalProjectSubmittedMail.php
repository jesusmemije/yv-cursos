<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class FinalProjectSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo Trabajo Final Enviado',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.final-project-submission',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if (!empty($this->mailData['file_path'])) {
            $fullPath = storage_path('app/public/' . $this->mailData['file_path']);
            
            if (file_exists($fullPath)) {
                $attachments[] = Attachment::fromPath($fullPath)
                    ->as($this->mailData['file_name']);
            }
        }

        return $attachments;
    }
}