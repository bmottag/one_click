<?php

namespace App\Mail;

use App\Models\Reserve;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservePaymentConfirmedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reserve;
    public $headerUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
        $this->headerUrl = asset('images/logo.png');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmation de paiement')
                    ->markdown('emails.reserve.confirmed', [
                        'reserve' => $this->reserve,
                    ])
                    ->with([
                        'headerUrl' => $this->headerUrl,
                    ]);
    }
}
