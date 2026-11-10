<?php
include_once(__DIR__ . '/../db/conexao.php');

$retorno = [
    'status'    => '', // ok - nok
    'mensagem'  => '', // mensagem que envio para o front
    'data'      => []
];

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conexao->prepare('SELECT * FROM avaliacoes WHERE id = ?');
    $stmt->bind_param('i', $id);
} else {
    $stmt = $conexao->prepare('SELECT * FROM avaliacoes');
}

$stmt->execute();
$resultado = $stmt->get_result();

$tabela = [];
if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $tabela[] = $linha;
    }
    $retorno = [
        'status'   => 'ok',
        'mensagem' => 'Sucesso, consulta efetuada',
        'data'     => $tabela
    ];
} else {
    $retorno = [
        'status'   => 'nok',
        'mensagem' => 'Não há registros',
        'data'     => []
    ];
}

$stmt->close();
$conexao->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($retorno);
