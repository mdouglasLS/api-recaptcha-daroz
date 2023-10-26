<?php

namespace App\Http;

class Response
{

    public function send(array|string $content, $httpCode = 200): void
    {
        http_response_code($httpCode);
        echo json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}