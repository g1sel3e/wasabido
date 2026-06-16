<?php
// Ativa a exibição de erros para evitar telas brancas em caso de falhas no PHP/Banco
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Garante que a sessão está ativa antes de qualquer processamento ou verificação
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../verificacao.php";
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . "/../MODEL/PedidoModel.php";
require_once __DIR__ . "/../DAO/PedidoDAO.php";

$pedido = new Pedido();
$dao = new PedidoDAO();

$acao = $_POST['acao'] ?? "";
$total = $_POST['total'] ?? "";

switch ($acao) {

    case "Finalizar":
        // 1. Pegar o código do cliente logado na sessão
        $codCliente = $_SESSION['cod_cliente'] ?? $_SESSION['cod'] ?? null;

        if (!$codCliente) {
            header("Location: ../VIEW/login.php?msg=faca_login");
            exit();
        }

        // 2. RECALCULAR O VALOR REAL DO PEDIDO DIRETO DA SESSÃO
        $valorTotalReal = 0;
        if (!empty($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $item) {
                $precoItem = (float) str_replace(',', '.', $item['preco']);
                $quantidadeItem = (int) $item['quantidade'];
                $valorTotalReal += ($precoItem * $quantidadeItem);
            }
        }

        // Impede de criar um pedido de R$ 0
        if ($valorTotalReal <= 0) {
            header("Location: ../VIEW/cliente/cardapioC.php?msg=carrinho_vazio");
            exit();
        }

        // 3. Gerar as informações automáticas do pedido
        $numeroPedidoAleatorio = rand(100000, 999999);
        $dataAtual = date('Y-m-d');
        $horaAtual = date('H:i:s');
        $statusInicial = "Aguardando Pagamento";

        // 4. Preencher o objeto $pedido
        $pedido->setNum($numeroPedidoAleatorio);
        $pedido->setValorTotal($valorTotalReal);
        $pedido->setStatus($statusInicial);
        $pedido->setData($dataAtual);
        $pedido->setHora($horaAtual);
        $pedido->setCodCliente($codCliente);
        $pedido->setCodPagamento(null);

        // 5. Salvar no banco
        $codPedidoGerado = $dao->inserir($pedido);

        if ($codPedidoGerado) {
            $_SESSION['cod_pedido'] = $codPedidoGerado;
            $_SESSION['total'] = $valorTotalReal;

            header("Location: ../VIEW/cliente/pagamento.php");
            exit();
        } else {
            header("Location: ../VIEW/erro.php?msg=erro_ao_salvar_pedido");
            exit();
        }
        break;

    case "RegistrarPagamento":
        $codPedido = $_SESSION['cod_pedido'] ?? $_POST['cod_pedido'] ?? null;
        $codPagamento = $_POST['cod_pagamento'] ?? null;

        if ($codPedido && $codPagamento) {
            $sucesso = $dao->atualizarPagamento($codPedido, $codPagamento, "Pago");

            if ($sucesso) {
                header("Location: ../VIEW/cliente/sucesso.php");
                exit();
            } else {
                header("Location: ../VIEW/erro.php?msg=erro_ao_atualizar_pedido");
                exit();
            }
        } else {
            header("Location: ../VIEW/erro.php?msg=dados_insuficientes");
            exit();
        }
        break;

    case "AtualizarStatusPedido":
        // Recebe os dados enviados pelo formulário do ADM
        $codPedido = $_POST['cod_pedido'] ?? null;
        $novoStatus = $_POST['status'] ?? null;

        // 1. Resgata o código do administrador logado na sessão
        $codAdmin = $_SESSION['cod_admin'] ?? $_SESSION['cod'] ?? null;

        // Verifique se os dados e o admin existem
        if ($codPedido && $novoStatus && $codAdmin) {

            // 2. Agora enviando os 3 parâmetros exigidos pelo DAO
            $sucesso = $dao->atualizarStatusPedido($codPedido, $novoStatus, $codAdmin);

            if ($sucesso) {
                header("Location: ../VIEW/adm/confirmacaoP.php?msg=status_atualizado");
                exit();
            } else {
                header("Location: ../VIEW/erro.php?msg=erro_ao_atualizar_status");
                exit();
            }
        } else {
            header("Location: ../VIEW/erro.php?msg=dados_adm_incompletos");
            exit();
        }
        break;

    case "AceitarEntrega":
        // 1. Recebe o código do pedido vindo do formulário/botão do entregador
        $codPedido = $_POST['cod_pedido'] ?? null;

        // 2. Resgata o código do ENTREGADOR logado na sessão
        $codEntregador = $_SESSION['cod_entregador'] ?? $_SESSION['cod'] ?? null;

        if ($codPedido && $codEntregador) {
            // 3. Chama o método do DAO que vincula o entregador e aceita a entrega
            $sucesso = $dao->aceitarEntrega($codPedido, $codEntregador);

            if ($sucesso) {
                header("Location: ../VIEW/entregador/pedidosE.php?msg=entrega_aceita");
                exit();
            } else {
                header("Location: ../VIEW/erro.php?msg=erro_ao_aceitar_entrega");
                exit();
            }
        } else {
            header("Location: ../VIEW/erro.php?msg=dados_entregador_incompletos");
            exit();
        }
        break;

    case "MudarStatusEntregador":
        $codPedido = $_POST['cod_pedido'] ?? null;
        $novoStatus = $_POST['status'] ?? null; // Receberá 'saiu para entrega' ou 'entregue'
        $codEntregador = $_SESSION['cod_entregador'] ?? $_SESSION['cod'] ?? null;

        if ($codPedido && $novoStatus && $codEntregador) {

            $sucesso = $dao->atualizarStatusPorEntregador($codPedido, $novoStatus, $codEntregador);

            if ($sucesso) {
                header("Location: ../VIEW/entregador/entregas.php?msg=status_atualizado");
                exit();
            } else {
                header("Location: ../VIEW/erro.php?msg=erro_ao_atualizar_status");
                exit();
            }
        } else {
            header("Location: ../VIEW/erro.php?msg=dados_entregador_incompletos");
            exit();
        }
        break;

    case "IniciarRotaEntrega":
        $codPedido = $_POST['cod_pedido'] ?? null;
        $codEntregador = $_SESSION['cod_entregador'] ?? $_SESSION['cod'] ?? null;

        if ($codPedido && $codEntregador) {
            $sucesso = $dao->atualizarStatusPorEntregador($codPedido, 'saiu para entrega', $codEntregador);
            if ($sucesso) {
                header("Location: ../VIEW/entregador/entregas.php?msg=em_rota");
                exit();
            }
        }
        header("Location: ../VIEW/erro.php");
        exit();
        break;

    case "ConcluirEntrega":
        $codPedido = $_POST['cod_pedido'] ?? null;
        $codEntregador = $_SESSION['cod_entregador'] ?? $_SESSION['cod'] ?? null;

        if ($codPedido && $codEntregador) {
            $sucesso = $dao->atualizarStatusPorEntregador($codPedido, 'entregue', $codEntregador);
            if ($sucesso) {
                header("Location: ../VIEW/entregador/entregaConcluida.php?msg=entregue_sucesso");
                exit();
            }
        }
        header("Location: ../VIEW/erro.php");
        exit();
        break;

    default:
        echo "Erro: A ação '" . htmlspecialchars($acao) . "' não foi reconhecida pelo Controller.";
        exit();
}
?>
