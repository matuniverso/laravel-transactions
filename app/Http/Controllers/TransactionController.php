<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizeServiceException;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Response;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepository $repository
    ) {
    }

    public function index()
    {
        $transactions = Transaction::query()
            ->latest()
            ->get();

        return response()->json(
            TransactionResource::collection($transactions)
        );
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            $transaction = $this->repository->handleTransactionStore($request);

            return response()->json(
                new TransactionResource($transaction),
                Response::HTTP_CREATED
            );
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
