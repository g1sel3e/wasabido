<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre o Sistema | WasabiDO</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #0e0e0e;
      color: #ddd;
      font-family: 'Segoe UI', sans-serif;
    }

    /* NAVBAR (INALTERADA) */
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
    }

    .nav-link:hover,
    .nav-link.active {
      color: #e60000 !important;
    }

    /* HERO */
    .hero {
      padding: 80px 0;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: 800;
      color: #fff;
    }

    .hero span {
      color: #e60000;
    }

    .hero p {
      color: #aaa;
      margin-top: 15px;
      max-width: 500px;
    }

    /* BLOCO */
    .bloco {
      padding: 70px 0;
      border-top: 1px solid #1a1a1a;
    }

    .bloco h2 {
      font-size: 1.8rem;
      color: #fff;
      margin-bottom: 20px;
    }

    .bloco p {
      color: #aaa;
      line-height: 1.6;
    }

    /* LISTA */
    .lista {
      list-style: none;
      padding: 0;
    }

    .lista li {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #ccc;
    }

    .lista i {
      color: #e60000;
    }

    /* CARDS USUÁRIOS */
    .user-card {
      background: #161616;
      border-radius: 12px;
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
      border: 1px solid #222;
      transition: 0.2s;
    }

    .user-card:hover {
      border-color: #e60000;
    }

    .user-card i {
      font-size: 1.8rem;
      color: #e60000;
    }

    .user-card h5 {
      margin: 0;
      color: #fff;
    }

    .user-card small {
      color: #aaa;
    }

    /* OBJETIVO NOVO (INTEGRADO) */
    .objetivo-texto {
      font-size: 1.1rem;
      color: #bbb;
      line-height: 1.7;
      border-left: 3px solid #e60000;
      padding-left: 15px;
    }

    .objetivo-texto span {
      color: #e60000;
      font-weight: 600;
    }

  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

      <a href="#" class="navbar-brand">
        <img src="../imagens/ws.png" />
      </a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="../index.php" class="nav-link active">Voltar</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>

  <!-- HERO -->
  <div class="container hero">
    <div class="row align-items-center">

      <div class="col-md-6">
        <h1>Sistema <span>WasabiDO</span></h1>
        <p>
          Um sistema criado para facilitar a rotina de restaurantes japoneses,
          deixando tudo mais organizado e rápido no dia a dia.
        </p>
      </div>

      <div class="col-md-6 text-center">
        <i class="bi bi-cpu" style="font-size: 120px; color:#e60000;"></i>
      </div>

    </div>
  </div>

  <!-- SOBRE -->
  <div class="container bloco">
    <div class="row align-items-center">

      <div class="col-md-6">
        <h2>Sobre o sistema</h2>
        <p>
          O WasabiDO ajuda no controle de pedidos, organização da cozinha
          e gestão geral do restaurante. A ideia é simples: menos bagunça,
          mais eficiência.
        </p>
      </div>

      <div class="col-md-6">
        <ul class="lista">
          <li><i class="bi bi-check"></i> Controle de pedidos</li>
          <li><i class="bi bi-check"></i> Organização interna</li>
          <li><i class="bi bi-check"></i> Interface simples</li>
        </ul>
      </div>

    </div>
  </div>

  <!-- USUÁRIOS -->
  <div class="container bloco">
    <h2 class="mb-4">Quem usa</h2>

    <div class="row g-3">

      <div class="col-md-4">
        <div class="user-card">
          <i class="bi bi-gear-fill"></i>
          <div>
            <h5>Administrador</h5>
            <small>Gerencia tudo</small>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="user-card">
          <i class="bi bi-person-fill"></i>
          <div>
            <h5>Cliente</h5>
            <small>Faz pedidos</small>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="user-card">
          <i class="bi bi-bicycle"></i>
          <div>
            <h5>Entregador</h5>
            <small>Entrega pedidos</small>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- VANTAGENS -->
  <div class="container bloco">
    <div class="row">

      <div class="col-md-4">
        <h2>Vantagens</h2>
      </div>

      <div class="col-md-8">
        <ul class="lista">
          <li><i class="bi bi-speedometer2"></i> Atendimento mais rápido</li>
          <li><i class="bi bi-check-circle"></i> Menos erros nos pedidos</li>
          <li><i class="bi bi-phone"></i> Fácil de usar</li>
        </ul>
      </div>

    </div>
  </div>

  <!-- OBJETIVO (CORRIGIDO) -->
  <div class="container bloco">
    <div class="row align-items-center">

      <div class="col-md-5">
        <h2>Objetivo</h2>
      </div>

      <div class="col-md-7">
        <p class="objetivo-texto">
          Melhorar a organização do restaurante e tornar o processo de pedidos
          mais <span>simples</span>, rápido e eficiente no dia a dia.
        </p>
      </div>

    </div>
  </div>

</body>
</html>
