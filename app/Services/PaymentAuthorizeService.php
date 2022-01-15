<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

final class PaymentAuthorizeService
{
    function __construct(
        private Client $client
    ) {
    }

    public function verify()
    {
        try {
            $mock = $this->client->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

            return json_decode($mock->getBody(), true);
        } catch (\Exception) {
            return response(
                'Something went wrong',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
