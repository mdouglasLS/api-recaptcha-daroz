<?php

namespace App\Curl;
class Curl
{
    public string $url = 'https://www.google.com/recaptcha/api/siteverify';
    public array $payload;

    public function __construct(array $payload) {
        $this->payload = $payload;
    }

    public function exec(): string
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->payload);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($curl);

        curl_close($curl);
        return $res;
    }
}