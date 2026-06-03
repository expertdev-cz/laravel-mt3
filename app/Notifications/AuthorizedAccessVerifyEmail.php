<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
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
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject('Potvrzení registrace do autorizovaného přístupu')
            ->line('Pro dokončení registrace potvrďte svůj e-mail.')
            ->action('Potvrdit e-mail', $verificationUrl)
            ->line('Pokud jste registraci neprovedli, nemusíte nic dělat.');
    }
}