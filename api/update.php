<?php

error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require('function.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "PUT") {
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (empty($inputData)) {
        $updateCliente = updateCliente($_POST, $_GET);
    } else {
        $updateCliente = updateCliente($inputData, $_GET);
    }

    echo $updateCliente;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Método não permitido!',
    ];
    header("HTTP/2 405 Método não permitido!");
    return json_encode($data);
}
