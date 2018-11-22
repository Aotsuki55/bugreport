<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $sendData;

    public function __construct($sendData)
    {
        $this->sendData = $sendData;
    }

    public function build()
    {
        return $this->subject('BugReport')
            ->text('emails.templates.registers_mail');
    }
}
