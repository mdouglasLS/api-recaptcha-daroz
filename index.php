<?php

header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Token");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  if (empty($data['secret'])) {
      header('Content-type: application/json');
      echo json_encode(['success' => false, 'error-codes' => 'missing-input-secret']);
      exit();
  }

  if (empty($data['response'])) {
    header('Content-type: application/json');
    echo json_encode(['success' => false, 'error-codes' => 'missing-input-response']);
    exit();
}

  $secret = $data['secret'];
  $response = $data['response'];

  $res = captchaValidation($secret, $response);

  header('Content-type: application/json');
  echo json_encode($res);
}

function captchaValidation($secret, $response) {

$url = "https://www.google.com/recaptcha/api/siteverify";

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL,$url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=$secret&response=$response");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($curl);

curl_close($curl);

return $res;

}