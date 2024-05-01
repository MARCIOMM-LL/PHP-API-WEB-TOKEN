<?php

require_once('../config/db.php');
require_once('../validation/validation.php');

function error422($message):  string
{
    $data = [
        'status' => 422, //Incapacidade para o servidor processar a requisição devido a dados inválidos
        'message' => $message,
    ];
    header("HTTP/1.0 422 Dados inválidos!");
    return json_encode($data);
}

function storeCliente($clienteInput): string
{
    global $connect;

    $nome = mysqli_real_escape_string($connect, $clienteInput['nome']);
    $genero = mysqli_real_escape_string($connect, $clienteInput['genero']);
    $data_nascimento = mysqli_real_escape_string($connect, $clienteInput['data_nascimento']);
    $cep = mysqli_real_escape_string($connect, $clienteInput['cep']);
    $endereco = mysqli_real_escape_string($connect, $clienteInput['endereco']);
    $numero = mysqli_real_escape_string($connect, $clienteInput['numero']);
    $bairro = mysqli_real_escape_string($connect, $clienteInput['bairro']);
    $cidade = mysqli_real_escape_string($connect, $clienteInput['cidade']);
    $uf = mysqli_real_escape_string($connect, $clienteInput['uf']);
    $email = mysqli_real_escape_string($connect, $clienteInput['email']);
    $telefone = mysqli_real_escape_string($connect, $clienteInput['telefone']);
    $cpf_cnpj = mysqli_real_escape_string($connect, $clienteInput['cpf_cnpj']);
    $data_cadastro = mysqli_real_escape_string($connect, $clienteInput['data_cadastro']);
    $status = mysqli_real_escape_string($connect, $clienteInput['status']);

    if (empty(trim($nome))) {
        return error422('Inserir nome!');
    } elseif (empty(trim($genero))) {
        return error422('Inserir género!');
    } elseif (empty(trim($data_nascimento))) {
        return error422('Inserir daya nascimento!');
    } elseif (empty(trim($cep))) {
        return error422('Inserir cep!');
    } elseif (empty(trim($endereco))) {
        return error422('Inserir endereço!');
    } elseif (empty(trim($numero))) {
       return error422('Inserir número!');
    } elseif (empty(trim($bairro))) {
       return error422('Inserir bairro!');
    } elseif (empty(trim($cidade))) {
       return error422('Inserir cidade!');
    } elseif (empty(trim($uf))) {
       return error422('Inserir uf! Exemplo (SP) sigla do seu estado.');
    } elseif (empty(trim($email))) {
        return error422('Inserir email!');
    } elseif (empty(trim($telefone))) {
        return error422('Inserir telefone!');
    } elseif (empty(trim($cpf_cnpj))) {
        return error422('Inserir cpf/cnpj!');
    } elseif (empty(trim($data_cadastro))) {
        return error422('Inserir data cadastro!');
    } elseif (empty(trim($status))) {
        return error422('Inserir status!');
    } else {
        $query = "INSERT INTO clientes (nome, genero, data_nascimento, cep, endereco, numero, bairro, cidade, uf, email, telefone, cpf_cnpj, data_cadastro, status)
                  VALUES ('$nome', '$genero', '$data_nascimento', '$cep', '$endereco', '$numero', '$bairro', '$cidade', '$uf', '$email', '$telefone', '$cpf_cnpj', '$data_cadastro', '$status');";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $data = [
                'status' => 201, //Requisição bem sucedida
                'message' => 'Cliente criado com sucesso!',
            ];
            header("HTTP/1.0 201 Cliente criado com sucesso!"); //envio de cabeçalho HTTP
            return json_encode($data);
        } else {
            $data = [
                'status' => 500, //Incspacidade para processar a requisição
                'message' => 'Erro Interno!',
            ];
            header("HTTP/1.0 405 Valor não encontrado!");
            return json_encode($data);
        }
    }
}

function getListaClientes(): string
{
    global $connect;

    $query = "SELECT 
                 id,
                 nome,
                 genero,
                 DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data_nascimento,
                 mask(cep, '#####-###') AS cep,
                 endereco,
                 numero,
                 bairro,
                 cidade,
                 uf,
                 email,
                 mask(telefone, '(##) #####-####') AS telefone,
                 mask(cpf_cnpj, '###.###.###-##') AS cpf_cnpj,
                 DATE_FORMAT(data_cadastro,'%d/%m/%Y') AS data_cadastro,
                 status
              FROM clientes";
    $query_run = mysqli_query($connect, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200, //Requisição bem sucedida
                'message' => 'Cliente encontrado com sucesso!',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK!");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Erro Interno!',
            ];
            header("HTTP/1.0 404 Usuário não encontrado!");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Erro Interno!',
        ];
        header("HTTP/1.0 405 Cliente não encontrado!");
        return json_encode($data);
    }
}

function getCliente($clienteParams): string
{
    global $connect;

    if ($clienteParams['id'] == null) {
        echo error422('Inserir o id do cliente!');
    }

    $clienteId = mysqli_real_escape_string($connect, $clienteParams['id']);

    $query = "SELECT
                 id,
                 nome,
                 genero,
                 DATE_FORMAT(data_nascimento,'%d/%m/%Y') AS data_nascimento,
                 mask(cep, '#####-###') AS cep,
                 endereco,
                 numero,
                 bairro,
                 cidade,
                 uf,
                 email,
                 mask(telefone, '(##) #####-####') AS telefone,
                 mask(cpf_cnpj, '###.###.###-##') AS cpf_cnpj,
                 DATE_FORMAT(data_cadastro,'%d/%m/%Y') AS data_cadastro,
                 status
              FROM clientes 
              WHERE id='$clienteId' 
              LIMIT 1"; // Claúsula LIMIT delemitando o número de linhas retornadas da base de dados

    $result = mysqli_query($connect, $query);

    if ($result) {
        if (mysqli_num_rows($result) === 1) {

            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Cliente encontrado com sucesso!',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK!");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Cliente não encontrado!',
            ];
            header("HTTP/1.0 404 Cliente não encontrado!");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Erro Interno!',
        ];
        header("HTTP/1.0 405 Cliente não encontrado!");
        return json_encode($data);
    }
}

function updateCliente($clienteInput, $clienteParams): string
{
    global $connect;

    if (!isset($clienteParams['id'])) {
        return error422('Cliente não encontrado na URL.');
    } elseif ($clienteParams['id'] == null) {
        return error422('Inserir id do Cliente.');
    }

    $clienteId = mysqli_real_escape_string($connect, $clienteParams['id']);

    $nome = mysqli_real_escape_string($connect, $clienteInput['nome']);
    $genero = mysqli_real_escape_string($connect, $clienteInput['genero']);
    $data_nascimento = mysqli_real_escape_string($connect, $clienteInput['data_nascimento']);
    $cep = mysqli_real_escape_string($connect, $clienteInput['cep']);
    $endereco = mysqli_real_escape_string($connect, $clienteInput['endereco']);
    $numero = mysqli_real_escape_string($connect, $clienteInput['numero']);
    $bairro = mysqli_real_escape_string($connect, $clienteInput['bairro']);
    $cidade = mysqli_real_escape_string($connect, $clienteInput['cidade']);
    $uf = mysqli_real_escape_string($connect, $clienteInput['uf']);
    $endereco = mysqli_real_escape_string($connect, $clienteInput['endereco']);
    $email = mysqli_real_escape_string($connect, $clienteInput['email']);
    $telefone = mysqli_real_escape_string($connect, $clienteInput['telefone']);
    $cpf_cnpj = mysqli_real_escape_string($connect, $clienteInput['cpf_cnpj']);
    $data_cadastro = mysqli_real_escape_string($connect, $clienteInput['data_cadastro']);
    $status = mysqli_real_escape_string($connect, $clienteInput['status']);

    if (empty(trim($nome))) {
        return error422('Inserir nome!');
    } elseif (empty(trim($genero))) {
        return error422('Inserir género!');
    } elseif (empty(trim($data_nascimento))) {
        return error422('Inserir daya nascimento!');
    } elseif (empty(trim($cep))) {
        return error422('Inserir cep!');
    } elseif (empty(trim($endereco))) {
        return error422('Inserir endereço!');
    } elseif (empty(trim($numero))) {
        return error422('Inserir número!');
    } elseif (empty(trim($bairro))) {
        return error422('Inserir bairro!');
    } elseif (empty(trim($cidade))) {
        return error422('Inserir cidade!');
    } elseif (empty(trim($uf))) {
        return error422('Inserir uf! Exemplo (SP) sigla do seu estado.');
    } elseif (empty(trim($email))) {
        return error422('Inserir email!');
    } elseif (empty(trim($telefone))) {
        return error422('Inserir telefone!');
    } elseif (empty(trim($cpf_cnpj))) {
        return error422('Inserir cpf/cnpj!');
    } elseif (empty(trim($data_cadastro))) {
        return error422('Inserir data cadastro!');
    } elseif (empty(trim($status))) {
        return error422('Inserir status!');
    } else {
        $query = "UPDATE clientes 
                  SET nome='$nome', 
                      genero='$genero', 
                      data_nascimento='$data_nascimento', 
                      cep='$cep', 
                      endereco='$endereco', 
                      numero='$numero', 
                      bairro='$bairro', 
                      cidade='$cidade', 
                      uf='$uf', 
                      email='$email', 
                      telefone='$telefone',
                      cpf_cnpj='$cpf_cnpj',
                      data_cadastro='$data_cadastro',
                      status='$status'
                  WHERE id='$clienteId' 
                  LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'Cliente atualizado com sucesso!',
            ];
            header("HTTP/1.0 200 Cliente criado com sucesso!");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Erro Interno!',
            ];
            header("HTTP/1.0 405 Cliente não encontrado!");
            return json_encode($data);
        }
    }
}

function deleteCliente($clienteParams): string
{
    global $connect;

    if (!isset($clienteParams['id'])) {
        return error422('Cliente não encontrado na URL.');
    } elseif ($clienteParams['id'] == null) {
        return error422('Inserir id do Cliente.');
    }

    $clienteId = mysqli_real_escape_string($connect, $clienteParams['id']);

    $query = "DELETE FROM clientes WHERE id='$clienteId' LIMIT 1";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'Cliente apagado com sucesso!',
        ];
        header("HTTP/1.0 200 OK");
    } else {
        $data = [
            'status' => 404,
            'message' => 'Cliente não encontrado.',
        ];
        header("HTTP/1.0 400 Não encontrado.");
    }
    return json_encode($data);
}
