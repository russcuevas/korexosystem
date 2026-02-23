<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderConfirmationMail extends Mailable
{
    public $orders;
    public $reservedAt;
    public $referenceNumber;
    public $totalAmount;
    public $qrFileName;
    public $fullname; // ✅ ADD THIS

    public function __construct(
        $orders,
        $reservedAt,
        $referenceNumber,
        $totalAmount,
        $qrFileName = null,
        $fullname = null // ✅ ADD THIS
    ) {
        $this->orders = $orders;
        $this->reservedAt = $reservedAt;
        $this->referenceNumber = $referenceNumber;
        $this->totalAmount = $totalAmount;
        $this->qrFileName = $qrFileName;
        $this->fullname = $fullname; // ✅ ASSIGN
    }

    public function build()
    {
        return $this->subject('Korexo Order Success')
            ->view('emails.order_confirmation');
    }
}
