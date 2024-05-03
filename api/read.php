<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require('function.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === "GET") {
    if (isset($_GET['id'])) {
        $cliente = getCliente($_GET);
        echo $cliente;
    } else {
        $clienteLista = getListaClientes();
        echo $clienteLista;
    }
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Método não permitido!',
    ];
    header("HTTP/2 405 Método não permitido!");
    return json_encode($data);
}
