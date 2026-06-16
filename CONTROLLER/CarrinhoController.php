<?php
session_start(); // 🔥 ISSO É OBRIGATÓRIO
require_once __DIR__ . "/../verificacao.php";

$acao = $_POST['acao'] ?? "";

switch ($acao) {

    case "Adicionar":

        // Garante que o carrinho existe
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Adiciona produto
        $_SESSION['carrinho'][] = [
            'id' => $_POST['id_produto'] ?? 0,
            'nome' => $_POST['nome'],
            'quantidade' => $_POST['quantidade'] ?? 1,
            'preco' => $_POST['preco'] ?? 0
        ];

        echo "ok";
        exit;


    case "Remover":

        $index = $_POST['index'] ?? null;

        if ($index !== null && isset($_SESSION['carrinho'][$index])) {
            unset($_SESSION['carrinho'][$index]);

            // Reorganiza o array (evita bugs de índice)
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
        }

        header("Location: ../VIEW/cliente/carrinho.php");
        exit;


    case "Limpar":

        unset($_SESSION['carrinho']);

        header("Location: ../VIEW/cliente/carrinho.php");
        exit;


    default:
        echo "Ação inválida";
        exit;
}