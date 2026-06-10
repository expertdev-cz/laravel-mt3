<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class AuthorizedAccessVerifyEmail extends VerifyEmail
{
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'authorized-access.verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
        );
    }

    public function toMail($notifiable): MailMessage
    {
        $locale = $notifiable->lang_locale ?? App::getLocale();
        App::setLocale($locale);

        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject(__('ap_email.subject'))
            ->line(__('ap_email.line1'))
            ->action(__('ap_email.action'), $verificationUrl)
            ->line(__('ap_email.line2'));
    }
}