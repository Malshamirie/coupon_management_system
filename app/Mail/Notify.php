<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Notify extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    public $subject;


    /**
     * Create a new message instance.
     */
    public function __construct($mailData,$subject)
    {
        //
        $this->mailData = $mailData;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:$this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // create a view that will be used as a template fo your email
            view: 'mail.notify',
        );
    }
    public function build()
    {
        return $this->view('mail.notify')
                    ->with('data', $this->mailData)
                    ->subject($this->subject);

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
