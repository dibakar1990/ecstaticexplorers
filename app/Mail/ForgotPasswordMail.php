<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new message instance.
     */
    public function __construct($request_sent)
    {
        $this->user = $request_sent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $appName = config('app.name');
        $from = $appName;
        $from_address = config('app.form_mail_address');
        return new Envelope(
            from: new Address($from_address, $from),
            subject: 'Forgot Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.mail.forgot-password',
            with: [
                'file_path' =>$this->user['file_path'],
                'logo' => $this->user['file_url'],
                'reset_link'=> $this->user['reset_link'],
                'name' => $this->user['name'],
                'email' => $this->user['email']
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
