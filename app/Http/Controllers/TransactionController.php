<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizeServiceException;
use App\Http\Requests\StoreTransactionRequest;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepository $repository
    ) {
    }

    public function __invoke(StoreTransactionRequest $request)
    {
        try {
            $transaction = $this->repository->handleTransactionStore($request);

            return response()->json($transaction, Response::HTTP_CREATED);
        } catch (AuthorizeServiceException $serviceException) {
            return response(
                $serviceException->getMessage(),
                Response::HTTP_UNAUTHORIZED
            );
        } catch (\Exception) {
            return response(
                'Something went wrong',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
