<?php
require_once __DIR__ . "/../../verificacao.php";
$nome = $_SESSION['nome'] ?? "Administrador";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Central de Confirmações | WasabiDO</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    /* Variáveis de Cores Alinhadas ao Padrão Premium */
    :root {
      --bg-dark: #070707;
      --card-bg: #111111;
      --card-border: #1f1f1f;
      --text-light: #f4f4f4;
      --text-muted: #a1a1aa;
      --accent-red: #e60000;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      background-color: var(--bg-dark);
      color: var(--text-light);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
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

    .offcanvas {
      background-color: var(--card-bg) !important;
      border-left: 2px solid var(--accent-red);
    }

    .offcanvas-header {
      border-bottom: 1px solid var(--card-border);
    }

    .nav-link {
      color: #eee !important;
      font-weight: 500;
      transition: 0.2s;
      padding: 12px 15px !important;
      border-radius: 8px;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #fff !important;
      background-color: rgba(230, 0, 0, 0.08);
      transform: translateX(4px);
    }

    .nav-link i {
      margin-right: 10px;
      color: var(--accent-red);
    }

    /* CABEÇALHO DA PÁGINA */
    .page-header {
      padding: 40px 0 20px 0;
      text-align: center;
      animation: fadeIn 0.5s ease-out;
    }

    .page-header h2 {
      font-weight: 800;
      font-size: 2.5rem;
      letter-spacing: -0.02em;
    }

    .page-header span {
      color: var(--accent-red);
    }

    /* CARDS DE AÇÃO (OS DOIS BOTÕES GIGANTES) */
    .action-container {
      flex-grow: 1;
      display: flex;
      align-items: center;
      padding-bottom: 60px;
    }

    .card-action {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 20px;
      padding: 60px 40px;
      text-align: center;
      text-decoration: none;
      color: var(--text-light);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      height: 100%;
      cursor: pointer;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    /* Ajuste para o Efeito Hover Premium (Sem degradê pesado) */
    .card-action:hover {
      transform: translateY(-6px);
      border-color: var(--accent-red);
      background: var(--card-bg);
      box-shadow: 0 12px 35px rgba(230, 0, 0, 0.12);
      color: #fff;
    }

    .card-action .icon-box {
      width: 80px;
      height: 80px;
      background: rgba(230, 0, 0, 0.06);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 24px;
      border: 1px solid rgba(230, 0, 0, 0.12);
      transition: all 0.3s ease;
    }

    .card-action:hover .icon-box {
      background: var(--accent-red);
      border-color: var(--accent-red);
      transform: scale(1.05);
    }

    .card-action i {
      font-size: 2.4rem;
      color: var(--accent-red);
      transition: color 0.3s ease;
    }

    .card-action:hover i {
      color: #fff;
    }

    .card-action h4 {
      font-weight: 700;
      margin-bottom: 12px;
      font-size: 1.4rem;
      letter-spacing: -0.01em;
    }

    .card-action p {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin: 0;
      line-height: 1.5;
    }

    /* FOOTER */
    footer {
      background: #000000;
      border-top: 1px solid var(--card-border);
      text-align: center;
      padding: 24px 20px;
      color: #52525b;
      font-size: 0.85rem;
      margin-top: auto;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
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
            <a href="adm.php" class="nav-link voltar-link text-white-50 ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container page-header">
    <h2>Central de <span>Confirmações</span></h2>
    <p class="text-muted">Selecione o setor que deseja gerenciar no momento.</p>
  </div>

  <section class="action-container">
    <div class="container">
      <div class="row g-4 justify-content-center">

        <div class="col-md-6 col-lg-5">
          <a href="confirmacaoP.php" class="card-action">
            <div class="icon-box">
              <i class="bi bi-bag-check-fill"></i>
            </div>
            <h4>Confirmar Pedidos</h4>
            <p>Gerencie, aceite ou recuse os pedidos recém-chegados dos clientes.</p>
          </a>
        </div>

        <div class="col-md-6 col-lg-5">
          <a href="confirmacao.php" class="card-action">
            <div class="icon-box">
              <i class="bi bi-person-vcard-fill"></i>
            </div>
            <h4>Cadastro de Entregadores</h4>
            <p>Analise e aprove as solicitações de novos motoboys e entregadores.</p>
          </a>
        </div>

      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <p class="mb-0">&copy; 2026 WASABIDO - Sistema para restaurantes japoneses</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
