<?php

use App\Controller\Api;
use App\Http\Request;
use App\Http\Response;

require_once "./vendor/autoload.php";

if(!isset($_SERVER["HTTPS"])){
    return;
}
$origin = $_SERVER['HTTP_ORIGIN'];
$allowedDomains = [
    'http://localhost:4200',
    'https://daroz.dev',
    'https://luanacrepaldiadvogada.com'
];

if (in_array($origin, $allowedDomains)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Curl-Method, Token");
header("Access-Control-Allow-Methods: POST, OPTIONS, PUT, DELETE");

$req = new Request;
$res = new Response;
$api = new Api;

if ($req->methodValidation()) {
    $res->send('Method not allowed.', 405);
    return;
}

if ($req->getUri() != '/') {
    $res->send('Url not found.', 404);
    return;
}

if($req->getHttpMethod() === 'GET') {
    $api->getInfo();
}


if ($req->getHttpMethod() === 'POST') {
    $payload = $req->getPayload();

    if (empty($payload['secret']) or empty($payload['response'])) {
        $message = empty($data['secret']) ? 'missing-input-secret' : 'missing-input-response';

        $res->send($message);
        return;
    }

    $api->recaptchaVerify($payload);
}