<?php
// Garante o início da sessão para validar as credenciais do admin se necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Segurança extra: Garante que apenas o Administrador veja esta tela
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("location:../login.php");
    exit();
}

// Importa o DAO de Pedidos (ajuste os níveis de ../ de acordo com a sua pasta VIEW)
require_once __DIR__ . "/../../DAO/PedidoDAO.php";
$dao = new PedidoDAO();

// Busca as métricas financeiras dinâmicas do banco de dados
$metricas = $dao->obterMetricasFaturamento();

$faturamentoMes = $metricas['faturamento_mes'] ?? 0;
$totalPedidos = $metricas['total_pedidos'] ?? 0;

// Calcula o ticket médio com segurança (evitando divisão por zero)
$ticketMedio = $totalPedidos > 0 ? ($faturamentoMes / $totalPedidos) : 0;

// Busca a lista das últimas 6 vendas reais do banco
$ultimasVendas = $dao->listarVendasRecentes(6);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Relatórios | WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <style>
    :root {
      --bg-dark: #070707;
      --card-bg: rgba(20, 20, 20, 0.6);
      --card-border: rgba(255, 255, 255, 0.05);
      --text-light: #f4f4f4;
      --text-muted: #a1a1aa;
      --accent-red: #e60000;
      --accent-hover: #ff3333;
      --accent-green: #2ecc71;
    }

    body, html {
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
    /* HEADER DA PÁGINA */
    .report-header {
      padding: 2.5rem 0 1.5rem;
    }
    .report-header h2 { font-size: 2.2rem; font-weight: 800; letter-spacing: -0.02em; }
    .report-header span { color: var(--accent-red); }

    /* CARD DE METRICA */
    .metric-card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      transition: transform 0.3s ease;
    }
    .metric-card:hover {
      transform: translateY(-3px);
    }
    .metric-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
    }

    /* CARD GERAL / TABELAS */
    .dashboard-card {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      margin-bottom: 30px;
    }

    .dashboard-card h5 {
      font-weight: 700;
      margin-bottom: 20px;
      letter-spacing: -0.01em;
    }

    /* ESTILIZAÇÃO DA TABELA */
    .table-responsive {
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .table-custom {
      margin-bottom: 0;
      background-color: transparent;
    }
    .table-custom th {
      background-color: rgba(0, 0, 0, 0.5) !important;
      color: var(--text-muted) !important;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-weight: 700;
      padding: 14px 20px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .table-custom td {
      background-color: transparent !important;
      color: var(--text-light) !important;
      padding: 16px 20px;
      font-size: 0.9rem;
      vertical-align: middle;
      border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .table-custom tr:last-child td {
      border-bottom: none;
    }

    /* MINI BADGES */
    .method-badge {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.8rem;
      font-weight: 500;
    }

    /* FORÇA A PÁGINA INTEIRA DO PDF A SER PRETA */
    @media print {
      @page {
        size: auto;
        margin: 0mm; /* Remove a margem branca padrão da folha */
      }
      
      body, html {
        background-color: #070707 !important;
        color: #f4f4f4 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      /* Dá um espaçamento interno para o conteúdo não colar na ponta do papel */
      body {
        padding: 20px !important;
      }

      .metric-card, .dashboard-card {
        background: rgba(20, 20, 20, 0.9) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        box-shadow: none !important;
      }

      .table-custom th {
        background-color: rgba(0, 0, 0, 0.8) !important;
        color: #a1a1aa !important;
      }

      .table-custom td {
        color: #f4f4f4 !important;
      }
      
      .navbar {
        background-color: #000 !important;
        border-bottom: 3px solid #e60000 !important;
        margin: -20px -20px 20px -20px !important; /* Ajusta a navbar ao topo sem bordas */
        padding: 1rem !important;
      }

      .navbar .nav-item {
        display: none !important;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="../../imagens/ws.png" alt="WasabiDO">
      </a>

      <button class="navbar-toggler d-print-none" data-bs-toggle="collapse" data-bs-target="#menuNav">
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
            <a href="adm.php" class="nav-link voltar-link text-white-50 ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container pb-5">
    
    <div class="report-header animate__animated animate__fadeIn">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h2>Relatórios & <span>Métricas</span></h2>
          <p class="text-secondary mb-0">Acompanhamento detalhado de vendas, faturamento e desempenho comercial.</p>
        </div>
        <div class="d-print-none">
          <button class="btn btn-outline-light btn-sm rounded-3 px-3 py-2 opacity-70" onclick="window.print()">
            <i class="bi bi-printer me-2"></i>Exportar PDF
          </button>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4 animate__animated animate__fadeInUp">
      
      <div class="col-md-4">
        <div class="metric-card d-flex align-items-center justify-content-between">
          <div>
            <span class="text-secondary small text-uppercase fw-bold tracking-wider">Faturamento (Mês)</span>
            <h3 class="fw-extrabold mt-1 mb-0" style="color: var(--accent-green);">R$ <?= number_format($faturamentoMes, 2, ',', '.') ?></h3>
          </div>
          <div class="metric-icon" style="background: rgba(46, 204, 113, 0.15); color: var(--accent-green);">
            <i class="bi bi-cash-stack"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="metric-card d-flex align-items-center justify-content-between">
          <div>
            <span class="text-secondary small text-uppercase fw-bold tracking-wider">Pedidos Concluídos</span>
            <h3 class="fw-extrabold mt-1 mb-0 text-white"><?= $totalPedidos ?></h3>
          </div>
          <div class="metric-icon" style="background: rgba(230, 0, 0, 0.15); color: var(--accent-red);">
            <i class="bi bi-bag-check"></i>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="metric-card d-flex align-items-center justify-content-between">
          <div>
            <span class="text-secondary small text-uppercase fw-bold tracking-wider">Ticket Médio</span>
            <h3 class="fw-extrabold mt-1 mb-0 text-info">R$ <?= number_format($ticketMedio, 2, ',', '.') ?></h3>
          </div>
          <div class="metric-icon" style="background: rgba(0, 200, 255, 0.15); color: #00c8ff;">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
        </div>
      </div>

    </div>

    <div class="row g-4">
      
      <div class="col-lg-12 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
        <div class="dashboard-card">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0"><i class="bi bi-clock-history me-2 text-danger"></i>Fluxo Recente de Vendas</h5>
            <span class="badge bg-dark border border-secondary text-secondary d-print-none">Atualizado em tempo real</span>
          </div>
          
          <div class="table-responsive">
            <table class="table table-custom">
              <thead>
                <tr>
                  <th>Pedido</th>
                  <th>Cliente</th>
                  <th>Data</th>
                  <th>Forma de Pagto</th>
                  <th class="text-end">Valor Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($ultimasVendas as $venda): ?>
                <tr>
                  <td class="fw-bold">#<?= $venda['num'] ?></td>
                  <td><?= htmlspecialchars($venda['cliente']) ?></td>
                  <td><?= date('d/m/Y', strtotime($venda['data'])) ?></td>
                  <td>
                    <span class="method-badge"><?= $venda['metodo'] ?></span>
                  </td>
                  <td class="text-end fw-bold text-white">R$ <?= number_format($venda['valor'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>