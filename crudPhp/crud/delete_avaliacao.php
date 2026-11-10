<?php
include_once(__DIR__ . '/../db/conexao.php');

$retorno = [
    'status'    => '', // ok - nok
    'mensagem'  => '', // mensagem que envio para o front
    'data'      => []
];

header('Content-Type: application/json; charset=utf-8');

if (empty($_GET['id'])) {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'ID da avaliação não informado.',
        'data'     => []
    ];
    echo json_encode($retorno);
    exit;
}

$id = (int) $_GET['id'];
$stmt = $conexao->prepare('DELETE FROM avaliacoes WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Avaliação excluída com sucesso.',
        'data'     => []
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Falha ao excluir avaliação.',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

echo json_encode($retorno);
