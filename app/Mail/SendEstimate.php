<?php

namespace App\Mail;

use App\Models\Estimates;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEstimate extends Mailable
{
    use Queueable, SerializesModels;

    public $estimate;

    public function __construct(Estimates $estimate)
    {
        $this->estimate = $estimate;
    }

    public function build()
    {
        return $this->view('emails.estimate')
                    ->with(['estimate' => $this->estimate]);
    }


























    
}
