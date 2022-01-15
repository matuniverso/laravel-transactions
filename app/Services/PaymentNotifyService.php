<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

final class PaymentNotifyService
{
    function __construct(
        private Client $client
    ) {
    }

    public function send()
    {
        try {
            $mock = $this->client->get('http://o4d9z.mocklab.io/notify');

            return json_decode($mock->getBody(), true);
        } catch (\Exception) {
            return response(
                'Something went wrong',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
