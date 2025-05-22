<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KYCVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New KYC Verification Request')
            ->greeting('Hello Admin')
            ->line('A new KYC verification request has been submitted.')
            ->line('User Details:')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('ID Type: ' . ucfirst($this->user->id_type))
            ->line('Submission Date: ' . $this->user->updated_at->format('d M Y H:i'))
            ->action('Review KYC Documents', route('admin.dashboard'))
            ->line('Please review the submitted documents and verify the user.');
    }
}
