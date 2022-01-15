<?php

namespace App\Listeners;

use App\Services\PaymentNotifyService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransactionNotification implements ShouldQueue
{
    public $afterCommit = true;

    public function __construct(
        private PaymentNotifyService $paymentNotifyService
    ) {
    }

    public function handle($event)
    {
        $response = $this->paymentNotifyService->send();

        return $response['message'] === 'Success';
    }
}
