<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
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
        if(setting()->app_title !=''){
            $from = setting()->app_title; 
        }else{
            $from = config('app.name');
        }
      
        $from_address = config('app.form_mail_address');
        return new Envelope(
            from: new Address($from_address, $from),
            subject: 'Contact Us Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.mail.contact-us',
            with: [
                'file_path' =>$this->user['file_path'],
                'logo' => $this->user['file_url'],
                'mailData' => $this->user
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
