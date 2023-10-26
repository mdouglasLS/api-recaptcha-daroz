<?php

namespace App\Http;

class Request
{

    private string $httpMethod;
    private string $uri;
    private array $payload;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->setPayload();
    }

    private function setPayload(): bool
    {
        if($this->httpMethod == 'GET') return false;

        $this->payload = $_POST ?? [];

        $inputRaw = file_get_contents('php://input');
        $inputs = (strlen($inputRaw)) && empty($_POST) ? json_decode($inputRaw, true) : $this->payload;
        $this->payload = array_map('strip_tags', $inputs);

        return true;
    }

    private function setUri(): void
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $exUri = explode('?', $this->uri);
        $this->uri = $exUri[0];
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function methodValidation(): bool
    {
        if($this->httpMethod !== 'GET' || $this->httpMethod !== 'POST') {
            return false;
        }
        return true;
    }

}