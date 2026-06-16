<?php
require_once __DIR__ . "/../verificacao.php";
require "../MODEL/PagamentoModel.php";
require "../MODEL/ContemModel.php"; // 🔥 NECESSÁRIO
require "../DAO/PagamentoDAO.php";
require "../DAO/ContemDAO.php";

$pagamento = new Pagamento();
$dao = new PagamentoDAO();
$contemDAO = new ContemDAO();

$acao = $_POST['acao'] ?? "";
$tipo = $_POST['tipo'] ?? "";
$codPedido = $_POST['cod_pedido'] ?? $_SESSION['cod_pedido'];

// 📥 RECEBE O CÓDIGO DO ENDEREÇO E TRATA STRINGS VAZIAS COMO NULL SEGURO
$codEnderecoRaw = $_POST['cod_endereco'] ?? '';
$codEndereco = (!empty($codEnderecoRaw) && is_numeric($codEnderecoRaw)) ? (int)$codEnderecoRaw : null;

switch ($acao) {

    case "Pagar":

        $pagamento->setTipo($tipo);
        $pagamento->setStatus("Pago");

        $codPagamento = $dao->inserir($pagamento);

        // =========================
        // ATUALIZA PEDIDO
        // =========================
        include __DIR__ . "/../conexao.php";

        $sql = "UPDATE pedido 
                SET cod_pagamento = :cod_pagamento,
                    status = 'Pago',
                    cod_endereco = :cod_endereco
                WHERE cod = :cod_pedido";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod_pagamento", $codPagamento, PDO::PARAM_INT);
        $consulta->bindValue(":cod_pedido", $codPedido, PDO::PARAM_INT);
        
        // 🎯 Envia o ID numérico ou o tipo NULL correto para o MySQL sem dar erro 1452
        $consulta->bindValue(":cod_endereco", $codEndereco, $codEndereco === null ? PDO::PARAM_NULL : PDO::PARAM_INT); 
        
        $consulta->execute();

        // =========================
        // 🔥 INSERIR ITENS NA CONTEM (COM SWITCH)
        // =========================
        $carrinho = $_SESSION['carrinho'] ?? [];

        switch (true) {

            case empty($carrinho):
                // carrinho vazio → não faz nada
                break;

            default:
                foreach ($carrinho as $item) {

                    $contem = new Contem();

                    $contem->setCodPedido($codPedido);
                    $contem->setCodProduto($item['id']);
                    $contem->setQuantidade($item['quantidade']);
                    $contem->setPrecoUnitario($item['preco']);
                    $contem->setSubtotal($item['quantidade'] * $item['preco']);

                    $contemDAO->inserir($contem); // 🔥 CORRETO
                }
                break;
        }

        // =========================
        // LIMPA CARRINHO
        // =========================
        unset($_SESSION['carrinho']);
        unset($_SESSION['cod_pedido']);

        // =========================
        // REDIRECIONA
        // =========================
        header("Location: ../VIEW/cliente/meuP.php");
        exit();

        break;

    default:
        echo "Ação não reconhecida";
}