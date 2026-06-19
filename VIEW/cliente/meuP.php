<?php
session_start();
require "../../DAO/PedidoDAO.php";
require "../../DAO/ContemDAO.php";

$dao = new PedidoDAO();
$itemDao = new ContemDAO();

$codCliente = $_SESSION['cod'] ?? 0;

// ALTERADO: Chamando com o novo nome da função
$pedidos = $dao->buscarPedidosDoCliente($codCliente);
$nome = $_SESSION['nome'] ?? "Cliente";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos | WasabiDO</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --bg-dark: #070707;
            --card-bg: rgba(20, 20, 20, 0.6);
            --card-border: rgba(255, 255, 255, 0.05);
            --text-light: #f4f4f4;
            --text-muted: #a1a1aa;
            --accent-red: #e60000;
            --accent-hover: #ff3333;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* NAVBAR PADRONIZADA */
    .navbar {
      background-color: #000;
      border-bottom: 3px solid #e60000;
      padding: 0.8rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 3px 5px rgba(0, 0, 0, 0.7);
    }

    .navbar-brand img {
      height: 50px;
    }

    .voltar-link {
        color: var(--text-muted) !important;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }

    .voltar-link:hover {
        color: var(--accent-hover) !important;
    }


        .header-section {
            padding: 3rem 1rem 2rem;
            text-align: center;
        }

        .header-section h2 {
            font-size: 2.8rem;
            font-weight: 800;
        }

        .header-section span {
            color: var(--accent-red);
        }

        .card-pedido {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 28px;
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .card-pedido:hover {
            transform: translateY(-5px);
            border-color: rgba(230, 0, 0, 0.3);
            box-shadow: 0 20px 40px rgba(230, 0, 0, 0.1);
        }

        .badge-status {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 30px;
            letter-spacing: 0.05em;
        }

        .status-pago {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.25);
        }

        .status-pendente {
            background: rgba(241, 196, 15, 0.15);
            color: #f1c40f;
            border: 1px solid rgba(241, 196, 15, 0.25);
        }

        .pedido-id {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .pedido-titulo {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            margin-top: 8px;
            letter-spacing: -0.02em;
        }

        .info-group {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 15px 5px;
            margin-top: 22px;
        }

        .info-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 0.95rem;
            font-weight: 500;
            color: #fff;
        }

        .total-value {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--accent-hover);
        }

        .btn-detalhes {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-light);
            font-size: 0.85rem;
            font-weight: 700;
            padding: 13px;
            border-radius: 14px;
            margin-top: auto;
            transition: all 0.2s ease;
            letter-spacing: 0.02em;
        }

        .btn-detalhes:hover {
            background: var(--accent-red);
            border-color: var(--accent-red);
            color: white;
            box-shadow: 0 6px 15px rgba(230, 0, 0, 0.3);
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: var(--card-bg);
            border: 2px dashed rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            max-width: 550px;
            margin: 0 auto;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .btn-cardapio {
            background: var(--accent-red);
            color: white;
            border: none;
            padding: 14px 35px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 25px;
            letter-spacing: 0.05em;
            transition: all 0.2s ease;
        }

        .btn-cardapio:hover {
            background: var(--accent-hover);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(255, 51, 51, 0.35);
        }

        .wasabi-modal .modal-content {
            background-color: #111111;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            color: var(--text-light);
        }

        .wasabi-modal .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .wasabi-modal .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .wasabi-modal .btn-close {
            filter: invert(1);
        }

        .item-pedido-lista {
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            padding: 12px 0;
        }

        .item-pedido-lista:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="inicioE.php" class="navbar-brand">
        <img src="../../imagens/ws.png" alt="WasabiDO">
      </a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto align-items-center gap-2">

          <li class="nav-item">
            <a href="../perfil.php"
              class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-white border border-secondary border-opacity-25"
              style="background: rgba(255,255,255,0.03); transition: 0.2s;"
              onmouseover="this.style.borderColor='var(--accent-red)'"
              onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'">
              <i class="bi bi-person-circle fs-5" style="color: var(--accent-red);"></i>
              <span class="small fw-semibold">Meu Perfil</span>
            </a>
          </li>

          <li class="nav-item d-none d-lg-block text-white-50 opacity-25 ms-2">|</li>

          <li class="nav-item">
            <a href="cliente.php" class="nav-link voltar-link ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

    <div class="container pb-5">

        <div class="header-section animate__animated animate__fadeIn">
            <h2 class="fw-bold">Meus <span>Pedidos</span></h2>
            <p class="text-secondary mb-0">Olá, <?= htmlspecialchars($nome) ?>! Acompanhe seu histórico de compras em
                tempo real.</p>
        </div>

        <?php if (empty($pedidos)) { ?>

            <div class="empty-state animate__animated animate__zoomIn">
                <div class="mb-4 text-danger opacity-50">
                    <i class="bi bi-box-seam" style="font-size: 3.5rem;"></i>
                </div>
                <h4 class="fw-bold">Nenhum pedido por aqui</h4>
                <p class="text-secondary mb-2">Parece que você ainda não realizou nenhuma compra.</p>
                <a href="cardapio.php" class="btn-cardapio text-uppercase">Explorar Cardápio</a>
            </div>

        <?php } else { ?>

            <div class="row g-4">
                <?php foreach ($pedidos as $p) {
                    $statusAtual = isset($p['status']) ? trim($p['status']) : 'Pendente';
                    $isPago = (in_array(strtolower($statusAtual), ['pago', 'aprovado', 'entregue']));
                    $statusClass = $isPago ? 'status-pago' : 'status-pendente';

                    $numPedido = $p['num'] ?? '0000';
                    $idPedidoBanco = $p['cod'] ?? 0;

                    // ========================================================
                    // CORREÇÃO LOGICADA DE DATA E HORA (Bases separadas)
                    // ========================================================
                    $dataPedido = 'Data s/ registro';
                    $horaPedido = 'Horário s/ registro';

                    if (!empty($p['data']) && !empty($p['hora'])) {
                        try {
                            // Une os campos DATE e TIME em uma string DATETIME do PHP
                            $dataHoraCompleta = $p['data'] . ' ' . $p['hora'];
                            $dt = new DateTime($dataHoraCompleta);

                            $dataPedido = $dt->format('d/m/Y');
                            $horaPedido = $dt->format('H:i');
                        } catch (Exception $e) {
                            // Fallback em caso de erro na formatação
                            $dataPedido = date("d/m/Y", strtotime($p['data']));
                            $horaPedido = substr($p['hora'], 0, 5);
                        }
                    } else {
                        if (!empty($p['data'])) {
                            $dataPedido = date("d/m/Y", strtotime($p['data']));
                        }
                        if (!empty($p['hora'])) {
                            $horaPedido = substr($p['hora'], 0, 5);
                        }
                    }
                    // ========================================================
            
                    $itensDoPedido = $itemDao->listarPorPedido($idPedidoBanco);
                    ?>

                    <div class="col-lg-4 col-md-6 card-item-animated">
                        <div class="card-pedido">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="pedido-id">IDENTIFICAÇÃO</span>
                                <span class="badge-status <?= $statusClass ?>">
                                    <i class="bi <?= $isPago ? 'bi-check-circle-fill' : 'bi-clock-history' ?> me-1"></i>
                                    <?= htmlspecialchars($statusAtual) ?>
                                </span>
                            </div>

                            <h5 class="pedido-titulo"><i class="bi bi-bag-check text-danger me-2"></i>Pedido Online
                                #<?= htmlspecialchars($numPedido) ?></h5>

                            <div class="row info-group text-center text-md-start">
                                <div class="col-6 border-end border-secondary border-opacity-25 ps-3">
                                    <span class="info-label">Data e Hora</span>
                                    <span class="info-value"><?= $dataPedido ?> às <?= $horaPedido ?></span>
                                </div>
                                <div class="col-6 ps-4">
                                    <span class="info-label">Total</span>
                                    <span class="info-value total-value">R$
                                        <?= number_format($p['valor_total'] ?? 0, 2, ',', '.') ?></span>
                                </div>
                            </div>

                            <div class="mt-4 pt-2">
                                <button class="btn btn-detalhes w-100" data-bs-toggle="modal"
                                    data-bs-target="#modalPedido<?= md5($numPedido) ?>">
                                    VER DETALHES DO PEDIDO
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade wasabi-modal" id="modalPedido<?= md5($numPedido) ?>" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">
                                        <i class="bi bi-receipt text-danger me-2"></i>Detalhes do Pedido
                                        #<?= htmlspecialchars($numPedido) ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div
                                        class="d-flex justify-content-between mb-4 pb-2 border-bottom border-secondary border-opacity-25">
                                        <div>
                                            <span class="text-secondary small d-block">Data / Hora do Pedido</span>
                                            <span class="fw-medium"><?= $dataPedido ?> às <?= $horaPedido ?></span>
                                        </div>
                                        <div class="text-end">
                                            <span class="text-secondary small d-block">Status Atual</span>
                                            <span
                                                class="badge-status <?= $statusClass ?> d-inline-block mt-1"><?= htmlspecialchars($statusAtual) ?></span>
                                        </div>
                                    </div>

                                    <h6 class="text-uppercase tracking-wider text-danger fw-bold small mb-3">Itens Comprados
                                    </h6>
                                    <div class="mb-4">

                                        <?php
                                        if (!empty($itensDoPedido)) {
                                            foreach ($itensDoPedido as $item) { ?>
                                                <div class="d-flex justify-content-between align-items-center item-pedido-lista">
                                                    <div>
                                                        <span
                                                            class="fw-bold text-white"><?= htmlspecialchars($item['quantidade']) ?>x</span>
                                                        <span
                                                            class="text-secondary"><?= htmlspecialchars($item['nome_produto']) ?></span>
                                                        <small class="text-muted d-block">unidade: R$
                                                            <?= number_format($item['preco_unitario'], 2, ',', '.') ?></small>
                                                    </div>
                                                    <span class="fw-semibold text-white">R$
                                                        <?= number_format($item['subtotal'], 2, ',', '.') ?></span>
                                                </div>
                                            <?php }
                                        } else { ?>
                                            <div class="text-center text-muted my-3">
                                                <i class="bi bi-exclamation-triangle me-1 text-warning"></i>
                                                <small>Nenhum produto processado ou encontrado para este pedido.</small>
                                            </div>
                                        <?php } ?>

                                    </div>

                                    <div class="p-3 bg-black bg-opacity-50 rounded-4 border border-secondary border-opacity-10">
                                        <div class="d-flex justify-content-between small text-secondary mb-2">
                                            <span>Horário de Saída:</span>
                                            <span
                                                class="text-white"><?= !empty($p['hora_saida']) ? substr($p['hora_saida'], 0, 5) : 'Aguardando Cozinha...' ?></span>
                                        </div>
                                        <?php if (!empty($p['hora_chegada'])) { ?>
                                            <div class="d-flex justify-content-between small text-secondary mb-2">
                                                <span>Horário de Entrega:</span>
                                                <span class="text-white"><?= substr($p['hora_chegada'], 0, 5) ?></span>
                                            </div>
                                        <?php } ?>
                                        <hr class="border-secondary border-opacity-25 my-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-uppercase small text-secondary">Valor Total:</span>
                                            <span class="fs-4 fw-extrabold text-danger">R$
                                                <?= number_format($p['valor_total'] ?? 0, 2, ',', '.') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <?php
                                    // Se o status for "aguardando pagamento", cria o botão apontando para a pasta atual
                                    if (strcasecmp($statusAtual, 'aguardando pagamento') === 0 || strcasecmp($statusAtual, 'aguardando pagamentos') === 0) { ?>
                                        <a href="pagamento.php?cod=<?= urlencode($idPedidoBanco) ?>&total=<?= urlencode($p['valor_total'] ?? 0) ?>"
                                            class="btn btn-danger rounded-3 px-4 fw-bold">
                                            <i class="bi bi-credit-card-2-back me-2"></i>EFETUAR PAGAMENTO
                                        </a>
                                    <?php } ?>
                                    <button type="button" class="btn btn-secondary rounded-3 px-4"
                                        data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>

        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const items = document.querySelectorAll('.card-item-animated');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                setTimeout(() => {
                    item.classList.add('animate__animated', 'animate__fadeInUp');
                    item.style.opacity = '1';
                }, index * 100);
            });
        });
    </script>

</body>

</html>
