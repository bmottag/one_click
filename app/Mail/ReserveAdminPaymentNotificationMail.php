<?php

namespace App\Mail;

use App\Models\Reserve;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReserveAdminPaymentNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reserve;

    /**
     * Create a new message instance.
     */
    public function __construct(Reserve $reserve)
    {
        $this->reserve = $reserve;
    }

    public function build()
    {
        return $this->subject('Nuevo pago recibido - Reserva #' . $this->reserve->id)
                    ->markdown('emails.reserve.admin', [
                        'reserve' => $this->reserve,
                    ]);
    }
}
