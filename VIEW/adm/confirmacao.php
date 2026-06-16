<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/wasabido/verificacao.php";
require "../../DAO/EntregadorDAO.php";

$entregadorDAO = new EntregadorDAO();
$entregadores = $entregadorDAO->listarPendentes();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entregadores | WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --bg-dark: #070707;
      --card-bg: #111111;
      --card-border: #1f1f1f;
      --text-light: #f4f4f4;
      --accent-red: #e60000;
      --accent-hover: #ff1a1a;
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

    .btn-sair-nav {
      color: var(--text-muted) !important;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-sair-nav:hover {
      color: var(--text-light) !important;
    }

    .voltar-link {
        color: var(--accent-red) !important;
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

    /* CARDS ESTILO SAAS */
    .card-entregador {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 16px;
      padding: 24px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      height: 100%;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .card-entregador:hover {
      transform: translateY(-4px);
      border-color: var(--accent-red);
      box-shadow: 0 12px 30px rgba(230, 0, 0, 0.12);
    }

    .nome {
      font-size: 1.25rem;
      font-weight: 700;
      color: #fff;
      margin-bottom: 6px;
      letter-spacing: -0.01em;
    }

    /* BADGE DE STATUS */
    .status {
      display: inline-flex;
      align-items: center;
      font-size: 0.68rem;
      padding: 4px 10px;
      border-radius: 8px;
      background: rgba(230, 0, 0, 0.08);
      color: var(--accent-red);
      font-weight: 700;
      letter-spacing: 0.06em;
      border: 1px solid rgba(230, 0, 0, 0.15);
      margin-bottom: 20px;
    }

    /* ALINHAMENTO DE INFORMAÇÕES */
    .info {
      font-size: 0.9rem;
      color: #a1a1aa;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .info i {
      color: #71717a;
      font-size: 1rem;
    }

    .info strong {
      color: #e4e4e7;
      font-weight: 500;
    }

    .acoes {
      display: flex;
      gap: 12px;
      margin-top: 24px;
    }

    /* BOTÕES INTEGRADOS */
    .btn-aprovar {
      flex: 1;
      background-color: var(--accent-red);
      color: white;
      border-radius: 10px;
      padding: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      border: none;
      transition: all 0.2s ease;
    }

    .btn-aprovar:hover {
      background-color: var(--accent-hover);
    }

    .btn-recusar {
      flex: 1;
      background: none;
      border: 1px solid var(--card-border);
      color: #a1a1aa;
      border-radius: 10px;
      padding: 10px;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    .btn-recusar:hover {
      border-color: #ef4444;
      color: #ef4444;
      background-color: rgba(239, 68, 68, 0.05);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
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
            <a href="confirmacoes.php" class="nav-link voltar-link text-white-50 ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <main class="main-content">
    <div class="container">

      <div class="titulo">
        <h1 class="mb-0">Entregadores <span style="color: var(--accent-red);">Pendentes</span></h1>
        <p class="small text-white-50 mt-1">Análise e liberação de novos parceiros cadastrados</p>
      </div>

      <div class="pb-5">
        <div class="row g-4">

          <?php if (count($entregadores) > 0): ?>
            <?php foreach ($entregadores as $e) { ?>

              <div class="col-md-6 col-lg-4">
                <div class="card-entregador">

                  <div class="nome"><?= htmlspecialchars($e['nome']) ?></div>
                  <div class="status">
                    <i class="bi bi-clock-history me-1"></i> PENDENTE
                  </div>

                  <div class="info">
                    <i class="bi bi-envelope"></i>
                    <span><strong>Email:</strong> <?= htmlspecialchars($e['email']) ?></span>
                  </div>
                  <div class="info">
                    <i class="bi bi-telephone"></i>
                    <span><strong>Telefone:</strong> <?= htmlspecialchars($e['tel']) ?></span>
                  </div>
                  <div class="info">
                    <i class="bi bi-card-text"></i>
                    <span><strong>CPF:</strong> <?= htmlspecialchars($e['cpf']) ?></span>
                  </div>
                  <div class="info">
                    <i class="bi bi-scooter"></i>
                    <span><strong>Veículo:</strong> <?= htmlspecialchars($e['veiculo']) ?> <span
                        class="text-muted small">(<?= htmlspecialchars($e['placa']) ?>)</span></span>
                  </div>

                  <form method="POST" action="../../CONTROLLER/EntregadorController.php">
                    <input type="hidden" name="acao" value="AtualizarStatus">
                    <input type="hidden" name="cod" value="<?= $e['cod'] ?>">

                    <div class="acoes">
                      <button type="submit" name="status" value="aprovado" class="btn-aprovar">
                        <i class="bi bi-check-circle-fill me-1"></i> Aprovar
                      </button>

                      <button type="submit" name="status" value="reprovado" class="btn-recusar">
                        <i class="bi bi-x-circle me-1"></i> Recusar
                      </button>
                    </div>
                  </form>

                </div>
              </div>

            <?php } ?>
          <?php else: ?>
            <div class="col-12 text-center py-5">
              <i class="bi bi-people text-muted d-block mb-2" style="font-size: 2.5rem;"></i>
              <span class="text-muted">Nenhum entregador pendente de aprovação.</span>
            </div>
          <?php endif; ?>

        </div>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>