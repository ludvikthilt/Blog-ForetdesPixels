<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @param array $details
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouveau message du formulaire de contact - La Forêt Des Pixels')
                    ->from('ForetDesPixels@gmail.com', 'La Forêt Des Pixels')
                    ->replyTo($this->details['email'], $this->details['name'])
                    ->view('emails.contact-form');
    }
}