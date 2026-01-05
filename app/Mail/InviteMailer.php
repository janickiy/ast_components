<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMailer extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct($feedback)
    {
        $this->data = $feedback;
    }

    public function build(): void
    {
        $this->subject('Приглашение на участие в тендере')
            ->view('emails.send_invite')
            ->with([
                'company' => $this->data->company,
                'name' => $this->data->name,
                'email' => $this->data->email,
                'phone' => $this->data->phone,
                'platform' => $this->data->platform,
                'numb' => $this->data->numb,
                'message' => $this->data->message,
            ]);
    }
}