<?php

error_reporting(0);

/** Cabeçalhos HTTP*/
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require('function.php');

/** @var  $requestMethod */
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "POST") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (empty($inputData)) {
        $storeUsuario = storeCliente($_POST);
    } else {
        $storeUsuario = storeCliente($inputData);
    }

    echo $storeUsuario;
} else {
    $data = [
        'status' => 405, //Requisição não suportada
        'message' => $requestMethod . ' Método não permitido!',
    ];
    header("HTTP/1.0 405 Método não permitido!");
    return json_encode($data);
}
