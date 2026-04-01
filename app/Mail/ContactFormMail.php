<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $content;

    protected string $subjectText;

    public function __construct($name, $email, $phone, $content, $subject = 'Nová zpráva z kontaktního formuláře')
    {
        $this->name    = $name;
        $this->email   = $email;
        $this->phone   = $phone;
        $this->content = $content;

        $this->subjectText = $subject;
    }

    public function build()
    {
        return $this->markdown('mail.contactform')
            ->subject($this->subjectText)
            ->replyTo($this->email)
            ->with([
                'name'    => $this->name,
                'email'   => $this->email,
                'phone'   => $this->phone,
                'content' => $this->content,
            ]);
    }
}
