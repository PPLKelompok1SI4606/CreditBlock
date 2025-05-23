<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class KYCVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $adminEmail;

    public function __construct(User $user, string $adminEmail)
    {
        $this->user = $user;
        $this->adminEmail = $adminEmail;
    }

    public function build()
    {
    return $this->from($this->user->email, $this->user->name)
        ->to($this->adminEmail)
        ->subject('New KYC Verification Request')
        ->view('emails.kyc_verification')
        ->with([
            'user' => $this->user,
            'adminDashboardUrl' => route('admin.dashboard'),
        ]);
    }
}
