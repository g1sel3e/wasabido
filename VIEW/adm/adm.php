<?php
// 🛡️ CORREÇÃO DE CAMINHO SEGURO UTILIZANDO NAVEGAÇÃO RELATIVA VIA __DIR__
require_once __DIR__ . "/../../verificacao.php";
$nome = $_SESSION['nome'] ?? "Administrador";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Admin | WasabiDO</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    /* Variáveis de Cores */
    :root {
      --bg-dark: #0a0a0a;
      --card-bg: #111111;
      --card-border: #1f1f1f;
      --text-light: #eeeeee;
      --text-muted: #cccccc;
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

    /* HERO Section */
    .hero {
      background: linear-gradient(to bottom, rgba(10, 10, 10, 0.6), var(--bg-dark)),
        url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
      height: 50vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
    }

    .hero-content {
      animation: fadeIn 1s ease-out;
    }

    .hero-content h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 15px;
      letter-spacing: -1px;
    }

    .hero-content span {
      color: var(--accent-red);
    }

    .hero-content p {
      color: var(--text-muted);
      font-size: 1.1rem;
      margin-bottom: 5px;
    }

    /* SEÇÃO DE CARDS EM GRID */
    .admin-cards {
      margin-top: -60px;
      padding-bottom: 80px;
      position: relative;
      z-index: 10;
    }

    .card-admin {
      background: var(--card-bg);
      border-radius: 20px;
      border: 1px solid var(--card-border);
      text-align: center;
      padding: 35px 25px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .card-admin:hover {
      transform: translateY(-12px);
      border-color: rgba(230, 0, 0, 0.3);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6), 0 0 15px rgba(230, 0, 0, 0.1);
    }

    .icon-wrapper {
      width: 65px;
      height: 65px;
      background: rgba(230, 0, 0, 0.05);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }

    .card-admin:hover .icon-wrapper {
      background: var(--accent-red);
    }

    .card-admin i {
      font-size: 1.8rem;
      color: var(--accent-red);
      transition: color 0.3s ease;
    }

    .card-admin:hover i {
      color: #fff;
    }

    .card-admin h5 {
      font-weight: 600;
      margin-bottom: 10px;
      color: #ffffff;
    }

    .card-admin p {
      color: #999;
      font-size: 0.9rem;
      margin-bottom: 25px;
      flex-grow: 1;
    }

    .btn-admin {
      background: var(--accent-red);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 25px;
      font-weight: 500;
      width: 100%;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .btn-admin:hover {
      background: #b30000;
      color: white;
    }

    /* FOOTER */
    footer {
      background: #000000;
      border-top: 2px solid var(--accent-red);
      text-align: center;
      padding: 30px 20px;
      color: #888;
      font-size: 0.9rem;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
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
            <a href="../../CONTROLLER/LoginController.php?acao=Logout" class="nav-link voltar-link text-white-50 ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Sair
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <section class="hero">
    <div class="hero-content px-3">
      <h1>Painel <span>Admin</span></h1>
      <p class="text-white">Bem-vindo, <strong><?php echo htmlspecialchars($nome); ?></strong></p>
      <p>Gerencie seu restaurante de forma rápida e inteligente.</p>
    </div>
  </section>

  <section class="admin-cards">
    <div class="container">
      <div class="row g-4 justify-content-center">

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-box-seam"></i>
            </div>
            <h5>Produtos</h5>
            <p>Adicione ou edite itens do cardápio digital</p>
            <a href="produtos.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-people"></i>
            </div>
            <h5>Usuários</h5>
            <p>Controle de equipe, entregadores e clientes</p>
            <a href="listadoE.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-person-plus-fill"></i>
            </div>
            <h5>Novo Admin</h5>
            <p>Realize o cadastro de novos administradores no sistema</p>
            <a href="cadastroA.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-bar-chart"></i>
            </div>
            <h5>Relatórios</h5>
            <p>Métricas e faturamento de resultados do mês</p>
            <a href="relatorios.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-star-fill"></i>
            </div>
            <h5>Avaliações</h5>
            <p>Veja o feedback, notas e comentários dos clientes</p>
            <a href="avaliacaoAdministrador.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-check-all"></i>
            </div>
            <h5>Histórico de Validações</h5>
            <p>Logs completos de todas as confirmações feitas</p>
            <a href="confirmacoes.php" class="btn btn-admin">Acessar</a>
          </div>
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
