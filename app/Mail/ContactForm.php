<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class ContactForm extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $name;
    public $company;
    public $email;
    public $phone;
    public $website;
    public $content;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $company, $email, $phone, $website, $content)
    {
        $this->name = $name;
        $this->company = $company;
        $this->email = $email;
        $this->phone = $phone;
        $this->website = $website;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact Form',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-form',
            with: [
                'name' => $this->name,
                'company' => $this->company,
                'email' => $this->email,
                'phone' => $this->phone,
                'website' => $this->website,
                'content' => $this->content,
            ]
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
