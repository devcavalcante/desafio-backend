<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Models\Wallet;
use GuzzleHttp\Exception\GuzzleException;

class NotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $uri = 'http://o4d9z.mocklab.io/notify';
        try {
            $response = $client->request('GET', $uri);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return ['error'];
        }
    }
}
