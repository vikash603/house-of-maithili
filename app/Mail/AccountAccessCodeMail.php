<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountAccessCodeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public ?string $code,
        public ?Order $order = null,
        public ?string $invoiceUrl = null,
        public ?string $invoicePdfUrl = null,
    ) {}

    public function build(): self
    {
        $subject = $this->order
            ? ($this->code ? 'Your House Of Maithili order and account code' : 'Your House Of Maithili order invoice')
            : 'Your House Of Maithili sign-in code';

        return $this->subject($subject)
            ->view('emails.account-access-code');
    }
}
