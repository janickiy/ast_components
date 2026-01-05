<?php

namespace App\Mail;

use stdClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NomenclatureRequestMailer extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    public function __construct($feedback)
    {
        $this->data = $feedback;
    }

    public function build(): void
    {
        $this->subject('Запрос номенклатуры')
            ->view('emails.nomenclature_request')
            ->with([
                'company' => $this->data->company,
                'name' => $this->data->name,
                'email' => $this->data->email,
                'phone' => $this->data->phone,

                'message' => $this->data->message,
            ]);
    }
}