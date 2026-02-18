<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderConfirmationMail extends Mailable
{
    public $orders;
    public $reservedAt;
    public $referenceNumber;
    public $totalAmount;
    public $qrFileName; // new property

    public function __construct($orders, $reservedAt, $referenceNumber, $totalAmount, $qrFileName = null)
    {
        $this->orders = $orders;
        $this->reservedAt = $reservedAt;
        $this->referenceNumber = $referenceNumber;
        $this->totalAmount = $totalAmount;
        $this->qrFileName = $qrFileName;
    }

    public function build()
    {
        return $this->subject('Korexo Order Success')
            ->view('emails.order_confirmation');
    }
}
