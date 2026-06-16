<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o entregador não estiver logado na sessão, retorna erro
if (!isset($_SESSION['cod_entregador'])) {
    echo json_encode(['status' => 'nao_logado']);
    exit;
}

// 1. CONECTE AO SEU BANCO DE DADOS AQUI (Exemplo padrão):
// $conexao = new mysqli("localhost", "usuario", "senha", "banco");

$id_entregador = $_SESSION['cod_entregador']; // Ajuste para a sua variável de sessão

// 2. Busque o status atualizado no banco
// (Supondo que sua tabela tenha uma coluna 'status' que mude para 'Aprovado')
$query = "SELECT status FROM entregadores WHERE id = ?"; 
$stmt = $conexao->prepare($query);
$stmt->bind_param("i", $id_entregador);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

if ($resultado && $resultado['status'] === 'Aprovado') {
    // IMPORTANTE: Atualiza a sessão para que a tela principal saiba que ele está aprovado
    $_SESSION['status_entregador'] = 'Aprovado'; 
    
    echo json_encode(['status' => 'Aprovado']);
} else {
    echo json_encode(['status' => 'Em Analise']);
}
