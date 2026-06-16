<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início - Cliente | Wasabi</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #0a0a0a;
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      color: #eee;
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
    }

    /* NAVBAR */
    .navbar {
      background-color: #000;
      border-bottom: 3px solid #e60000;
      padding: 0.8rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 3px 5px rgba(0, 0, 0, 0.7);
    }

    .navbar-brand {
      font-weight: 900;
      font-size: 1.8rem;
      letter-spacing: 3px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #fff;
    }

    .navbar-brand img {
      height: 50px;
    }

    .nav-link {
      color: #eee !important;
      font-weight: 600;
      letter-spacing: 1px;
      transition: 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #e60000 !important;
    }

    /* HERO & CONTEÚDO */
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.85)),
        url('https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
      min-height: calc(100vh - 170px); /* Ajusta dinamicamente descontando topo/rodapé */
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 3rem 0;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }

    .hero p.subtitle {
      color: #ccc;
      font-size: 1.2rem;
      margin-bottom: 3rem;
    }

    /* ESTILIZAÇÃO DOS CARDS (IGUAL AO ADMIN) */
    .card-admin {
      background-color: #121212;
      border: 1px solid #222;
      border-radius: 12px;
      padding: 2rem 1.5rem;
      text-align: center;
      transition: all 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }

    .card-admin:hover {
      transform: translateY(-5px);
      border-color: #e60000;
      box-shadow: 0 8px 25px rgba(230, 0, 0, 0.2);
    }

    .icon-wrapper {
      background-color: rgba(230, 0, 0, 0.1);
      color: #e60000;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      margin-bottom: 1.2rem;
      transition: 0.3s;
    }

    .card-admin:hover .icon-wrapper {
      background-color: #e60000;
      color: #fff;
    }

    .card-admin h5 {
      font-size: 1.3rem;
      font-weight: 700;
      margin-bottom: 0.7rem;
      color: #fff;
    }

    .card-admin p {
      font-size: 0.95rem;
      color: #aaa;
      margin-bottom: 1.5rem;
    }

    .btn-admin {
      background-color: #e60000;
      color: white;
      border: none;
      padding: 8px 25px;
      font-weight: 600;
      border-radius: 6px;
      transition: 0.2s;
      width: 100%;
    }

    .btn-admin:hover {
      background-color: #b30000;
      color: white;
    }

    footer {
      background: #000;
      border-top: 2px solid #e60000;
      padding: 30px 0;
    }
  </style>
</head>

<body>

  <?php
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  $nome = $_SESSION['nome'] ?? "Cliente";
  ?>

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
            <a href="../../CONTROLLER/LoginController.php?acao=Logout" class="nav-link text-white-50 me-2">
              <i class="bi bi-box-arrow-left me-1"></i> Sair
            </a>
          <li class="nav-item d-none d-lg-block text-white-50 opacity-25 me-2">|</li>

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
        </ul>
      </div>
    </div>
  </nav>

  

  <section class="hero">
    <div class="container">
      
      <div class="text-center">
        <h1>Olá, <?php echo htmlspecialchars($nome); ?></h1>
        <p class="subtitle">Pronto para pedir seu japonês favorito?</p>
      </div>

      <div class="row g-4 justify-content-center">

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-bag-check"></i>
            </div>
            <h5>Fazer Pedido</h5>
            <p>Explore nosso cardápio e escolha suas peças favoritas</p>
            <a href="cardapioC.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-clock-history"></i>
            </div>
            <h5>Acompanhar Pedido</h5>
            <p>Veja o status do seu pedido em tempo real</p>
            <a href="meuP.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

        <div class="col-sm-6 col-md-4">
          <div class="card-admin">
            <div class="icon-wrapper">
              <i class="bi bi-star"></i>
            </div>
            <h5>Avaliação</h5>
            <p>Conte como foi sua experiência com o nosso japa</p>
            <a href="avaliacaoCliente.php" class="btn btn-admin">Acessar</a>
          </div>
        </div>

      </div>

    </div>
  </section>

  <footer class="text-center">
    <div class="container">
      <p class="mb-1">&copy; 2026 WASABI System</p>
      <p>Sistema para restaurantes japoneses</p>
      <div class="mt-3">
        <i class="bi bi-instagram me-2"></i>@wasabi
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>