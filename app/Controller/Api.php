<?php

namespace App\Controller;

use App\Curl\Curl;
use App\Http\Response;

class Api
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response;
    }

    public function getInfo(): void
    {
        $this->response->send([
            'name' => 'API - Daroz',
            'version' => 'v1.0.0',
            'author' => 'Daroz',
            'site' => 'https://daroz.dev'
        ]);

    }

    public function recaptchaVerify(array $payload): void
    {
        $curl = new Curl($payload);
        $this->response->send($curl->exec());
    }

}