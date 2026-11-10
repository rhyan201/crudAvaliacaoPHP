<?php

//dados para login 
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'crudphp';

$conexao = new mysqli ($host, $usuario, $senha, $banco);


// verifica se esta tudo certo a conexao
if ($conexao->connect_error) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
        'status' => 'nok',
        'mensagem' => 'Erro de conexão: ' . $conexao->connect_error,
        'data' => []
    ]);
    exit;

}

$conexao ->set_charset('utf8mb4');