<?php
include_once(__DIR__ . '/../db/conexao.php');

$retorno = [
    'status'    => '', // ok - nok
    'mensagem'  => '', // mensagem que envio para o front
    'data'      => []
];

header('Content-Type: application/json; charset=utf-8');

$nome      = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$nota      = $_POST['nota'] ?? '';

if ($nome === '' || $descricao === '' || $nota === '') {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Preencha todos os campos.',
        'data'     => []
    ];
    echo json_encode($retorno);
    exit;
}

$nota = (int) $nota;

$stmt = $conexao->prepare(
    "INSERT INTO avaliacoes (nome, descricao, nota) VALUES (?, ?, ?)"
);
$stmt->bind_param("ssi", $nome, $descricao, $nota);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Avaliação cadastrada com sucesso',
        'data'     => []
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Erro ao cadastrar avaliação.',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

echo json_encode($retorno);
