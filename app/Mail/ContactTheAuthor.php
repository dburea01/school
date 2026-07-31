<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactTheAuthor extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $name, public string $email, public string $message)
    {
        $this->url = route('home');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        /** @var string $address */
        $address = config('mail.from.address');

        /** @var string $name */
        $name = config('mail.from.name');

        return new Envelope(
            subject: 'Contact the author - new message',
            from: new Address(
                $address,
                $name
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-the-author',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
