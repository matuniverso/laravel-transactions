<?php

namespace App\Repositories;

use App\Exceptions\AuthorizeServiceException;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Services\PaymentAuthorizeService;
use App\Services\PaymentNotifyService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class TransactionRepository
{
    function __construct(
        private UserRepository $userRepository,
        private PaymentNotifyService $paymentNotifyService,
        private PaymentAuthorizeService $paymentAuthorizeService
    ) {
    }

    public function handleTransactionStore(StoreTransactionRequest $request)
    {
        if (!$this->verifyAuthorization())
            throw new AuthorizeServiceException('Not authorized.');

        $data = $request->validated();
        $payer = User::find($request->payer_id);
        $receiver = User::find($request->receiver_id);

        $transaction = $this->applyTransaction($data, $payer, $receiver);

        // $this->sendNotification();

        return $transaction;
    }

    public function applyTransaction(array $data, User $payer, User $receiver)
    {
        DB::beginTransaction();

        try {
            $transaction = Transaction::create($data);
            $this->userRepository->removeMoney($payer, $data['amount']);
            $this->userRepository->addMoney($receiver, $data['amount']);

            DB::commit();

            return $transaction;
        } catch (\Exception) {
            DB::rollBack();

            return response(
                'Something went wrong',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function verifyAuthorization(): bool
    {
        $response = $this->paymentAuthorizeService->verify();

        return $response['message'] === 'Autorizado';
    }

    public function sendNotification(): bool
    {
        $response = $this->paymentNotifyService->send();

        return $response['message'] === 'Success';
    }
}
