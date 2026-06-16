<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define o retorno estritamente como JSON para o JavaScript ler sem erros
header('Content-Type: application/json');

// Se o entregador não estiver logado na sessão, retorna erro
if (!isset($_SESSION['cod_entregador'])) {
    echo json_encode(['status' => 'nao_logado']);
    exit;
}

// IMPORTANTE: Inclua aqui o seu arquivo real que cria a variável $conexao
// require_once __DIR__ . "/../../DAO/conexao.php"; 

$id_entregador = $_SESSION['cod_entregador'];

// NOTA: Certifique-se de que a tabela se chama 'entregadores' e a coluna chave é 'id' (ou 'cod')
$query = "SELECT status FROM entregadores WHERE id = ?"; 
$stmt = $conexao->prepare($query);
$stmt->bind_param("i", $id_entregador);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

if ($resultado && strtolower($resultado['status']) === 'aprovado') {
    // Atualiza a sessão para que as próximas telas saibam que ele já está aprovado
    $_SESSION['status_entregador'] = 'Aprovado'; 
    echo json_encode(['status' => 'Aprovado']);
} else {
    echo json_encode(['status' => 'Em Analise']);
}
exit;
