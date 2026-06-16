<?php
require_once __DIR__ . "/../../verificacao.php";
require "../../DAO/PedidoDAO.php";
require "../../DAO/ContemDAO.php";

// Garante que a sessão está ativa caso o código dependa dela para ler o cod_admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pedidoDAO = new PedidoDAO();
$contemDAO = new ContemDAO();

$pedidos = $pedidoDAO->listarPedidosPagos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos | WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --bg-dark: #070707;
      --card-bg: #111111;
      --card-border: #1f1f1f;
      --text-light: #f4f4f4;
      --accent-red: #e60000;
      --accent-hover: #ff1a1a;
      --box-inside: #161616;
      --text-muted: #a1a1aa;
    }

    body {
      background-color: var(--bg-dark);
      color: var(--text-light);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .main-content {
      flex-grow: 1;
      background-color: transparent;
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

    /* TITULO PREMIUM */
    .titulo {
      padding: 40px 0 20px 0;
    }

    .titulo h1 {
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.02em;
    }

    /* CARDS ESTILO PREMIUM */
    .order-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .order-card:hover {
      transform: translateY(-4px);
      border-color: var(--accent-red);
      box-shadow: 0 12px 30px rgba(230, 0, 0, 0.12);
    }

    .card-header-custom {
      background-color: transparent;
      border-bottom: 1px solid var(--card-border);
    }

    .info-icon {
      color: #71717a;
      font-size: 1rem;
      width: 20px;
      text-align: center;
    }

    .text-secondary-custom {
      color: #a1a1aa !important;
    }

    /* CAIXA INTERNA DE ITENS REFINADA */
    .items-box {
      background-color: var(--box-inside);
      border-radius: 12px;
      padding: 16px;
      border: 1px solid rgba(255, 255, 255, 0.02);
    }

    /* BOTÕES MODERNOS INTEGRADOS */
    .btn-custom-action {
      border-radius: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 10px;
      transition: all 0.2s ease;
      border: none;
    }

    .btn-confirm {
      background-color: #16a34a;
      color: #fff;
    }

    .btn-confirm:hover {
      background-color: #15803d;
      color: #fff;
    }

    .btn-reject {
      background: none;
      border: 1px solid var(--card-border);
      color: #a1a1aa;
    }

    .btn-reject:hover {
      border-color: #ef4444;
      color: #ef4444;
      background-color: rgba(239, 68, 68, 0.05);
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
            <a href="confirmacoes.php" class="nav-link voltar-link ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <main class="main-content">
    <div class="container pb-5">

      <div class="titulo">
        <h1 class="mb-0">Pedidos <span style="color: var(--accent-red);">Pagos</span></h1>
        <p class="small text-white-50 mt-1">Gerencie os pedidos pendentes de aprovação e envio</p>
      </div>

      <div class="row g-4">

        <?php if (count($pedidos) > 0): ?>
          <?php foreach ($pedidos as $p) { ?>

            <div class="col-md-6 col-lg-4">
              <div class="order-card d-flex flex-column h-100">

                <div class="card-header-custom p-4">
                  <h5 class="mb-0 fw-bold" style="color: #fff; letter-spacing: -0.01em;">
                    Pedido <span style="color: var(--accent-red);">#<?= $p['cod'] ?></span>
                  </h5>
                </div>

                <div class="p-4 flex-grow-1">

                  <div class="mb-4">
                    <div class="d-flex align-items-center mb-2 gap-2">
                      <i class="bi bi-person-circle info-icon"></i>
                      <span class="fw-semibold text-white"><?= htmlspecialchars($p['nome_cliente'] ?? 'Cliente') ?></span>
                    </div>

                    <div class="d-flex align-items-center mb-2 gap-2">
                      <i class="bi bi-telephone-fill info-icon"></i>
                      <span class="text-secondary-custom"><?= htmlspecialchars($p['telefone_cliente'] ?? 'N/A') ?></span>
                    </div>

                    <div class="d-flex align-items-start gap-2">
                      <i class="bi bi-geo-alt-fill info-icon mt-1"></i>
                      <small class="text-secondary-custom">
                        <?= htmlspecialchars($p['rua'] ?? '') ?>, <?= htmlspecialchars($p['num'] ?? '') ?><br>
                        <?= htmlspecialchars($p['bairro'] ?? '') ?>
                      </small>
                    </div>
                  </div>

                  <div class="items-box">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2"
                      style="border-color: rgba(255,255,255,0.05) !important;">
                      <span class="fw-medium text-white-50 small">Total do Pedido</span>
                      <span class="fs-5 fw-bold" style="color: #22c55e;">
                        R$ <?= number_format($p['valor_total'], 2, ',', '.') ?>
                      </span>
                    </div>

                    <h6 class="text-uppercase mb-2 fw-bold"
                      style="font-size: 0.68rem; letter-spacing: 0.05em; color: #71717a;">
                      Itens do Pedido
                    </h6>

                    <ul class="list-unstyled mb-0 small">
                      <?php
                      $itens = $contemDAO->listarPorPedido($p['cod']);

                      if ($itens) {
                        foreach ($itens as $i) {
                          echo "<li class='mb-2 d-flex align-items-start'>";
                          echo "<strong style='color: var(--accent-red);' class='me-2'>" . htmlspecialchars($i['quantidade']) . "x</strong> ";
                          echo "<span style='color: #e4e4e7;'>" . htmlspecialchars($i['nome_produto']) . "</span>";
                          echo "</li>";
                        }
                      } else {
                        echo "<li class='fst-italic text-secondary-custom'>Sem itens registrados</li>";
                      }
                      ?>
                    </ul>
                  </div>

                </div>

                <div class="p-4 pt-0 mt-auto">
                  <form method="POST" action="../../CONTROLLER/PedidoController.php" class="d-flex gap-2">

                    <input type="hidden" name="acao" value="AtualizarStatusPedido">
                    <input type="hidden" name="cod_pedido" value="<?= $p['cod'] ?>">
                    <input type="hidden" name="cod_admin" value="<?= $_SESSION['cod'] ?? '' ?>">
                    
                    <input type="hidden" name="status" id="status_<?= $p['cod'] ?>" value="">

                    <button type="submit" class="btn btn-confirm btn-custom-action flex-grow-1" 
                            onclick="document.getElementById('status_<?= $p['cod'] ?>').value='Confirmado';">
                      <i class="bi bi-check-lg me-1"></i> Confirmar
                    </button>

                    <button type="submit" class="btn btn-reject btn-custom-action flex-grow-1" 
                            onclick="document.getElementById('status_<?= $p['cod'] ?>').value='Recusado';">
                      <i class="bi bi-x-lg me-1"></i> Recusar
                    </button>

                  </form>
                </div>

              </div>
            </div>

          <?php } ?>
        <?php else: ?>
          <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam text-muted d-block mb-2" style="font-size: 2.5rem;"></i>
            <span class="text-muted">Nenhum pedido pago aguardando aprovação no momento.</span>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
