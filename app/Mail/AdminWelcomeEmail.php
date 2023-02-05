<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Admin $admin;
    public String $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,$password)
    {
        $this->admin = $admin;
        $this->password = $password ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('emails.admin_welcome_email',['user'=>$this->user]);
        return $this->markdown('emails.admin_welcome_email')
        ->from('Ayman@gmail.com','Store System');
    }
}
