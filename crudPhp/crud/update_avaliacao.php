<?php
header('Content-type: application/json; charset=utf-8');

include_once(__DIR__ . '/../db/conexao.php');

$retorno = [
    'status' => 'nok',
    'mensagem' => '',
    'data' => [],
];

$id = $_GET['id'] ?? null;
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$nota = trim($_POST['nota'] ?? '');

if(empty($id)){
    $retorno['mensagem'] = 'ID da avaliação não informada';
    echo json_encode($retorno);
    exit();
}

if($nome === '' || $descricao === '' || $nota === ''){
    $retorno['mensagem'] = 'Preencha todos os campos';
    echo json_encode($retorno);
    exit();
}

$id = (int) $id;
$nota = (int) $nota;

if($nota < 0 || $nota > 10){
    $retorno['mensagem'] = 'A nota deve ser entre 0 e 10';
    echo json_encode($retorno);
    exit();
}

$sqlCheck = "SELECT ID FROM avaliacoes WHERE id = ?";
$stmtCheck = $conexao->prepare($sqlCheck);
$stmtCheck -> bind_param("i", $id);
$stmtCheck -> execute();
$resCheck = $stmtCheck -> get_result();

if($resCheck->num_rows === 0){
    $retorno["mensagem"] = "Avaliação não encontrada";
    $stmtCheck -> close();
    $conexao -> close();
    echo json_encode($retorno);
    exit();
}
$stmtCheck -> close();

$sql = "UPDATE avaliacoes SET nome = ?, descricao = ?, nota = ? WHERE id = ?";

$stmt = $conexao ->prepare($sql);
$stmt->bind_param("ssii", $nome, $descricao, $nota, $id);

if($stmt->execute()){
    $retorno["status"] = "ok";
    $retorno["mensagem"] = "Avaliação alterada com sucesso.";
} else {
    $retorno['mensagem'] = 'Erro ao alterar a avaliação';
}

$stmt->close();
$conexao -> close();
echo json_encode($retorno);
?>