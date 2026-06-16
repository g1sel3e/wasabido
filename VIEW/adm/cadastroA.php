<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/wasabido/verificacao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Cadastro Administrador - WasabiDO</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      color: #eee;
      font-family: 'Segoe UI', sans-serif;

      background:
        linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
        url('https://images.unsplash.com/photo-1553621042-f6e147245754?q=80&w=1400&auto=format&fit=crop') no-repeat center center/cover;

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

    /* CONTAINER */
    .container-cadastro {
      min-height: calc(100vh - 70px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    /* BOX */
    .box-cadastro {
      width: 100%;
      max-width: 450px;
      padding: 35px;

      background: rgba(15, 15, 15, 0.85);
      backdrop-filter: blur(8px);

      border-radius: 15px;
      border: 1px solid rgba(230, 0, 0, 0.3);

      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
      color: #fff;
    }

    .input-group-text {
      background: #0d0d0d;
      border: 1px solid #222;
      color: #e60000;
    }

    .form-control {
      background: #0d0d0d;
      border: 1px solid #222;
      color: #ddd;
    }

    .form-control::placeholder {
      color: #888;
    }

    .form-control:focus {
      border-color: #e60000;
      box-shadow: 0 0 6px rgba(230, 0, 0, 0.4);
      background: #0d0d0d;
      color: #fff;
    }

    .btn-cadastro {
      width: 100%;
      padding: 12px;
      font-weight: 600;
      margin-top: 10px;
      background: #e60000;
      border: none;
      color: #fff;
      border-radius: 8px;
      transition: 0.2s;
    }

    .btn-cadastro:hover {
      background: #c40000;
    }

    .extra-links {
      text-align: center;
      margin-top: 15px;
    }

    .extra-links a {
      color: #e60000;
      text-decoration: none;
    }

    .extra-links a:hover {
      text-decoration: underline;
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
          <a href="../../CONTROLLER/LoginController.php?acao=Logout" class="nav-link voltar-link text-white-50 me-2">
            <i class="bi bi-box-arrow-left me-1"></i> Sair
          </a> 
        </li>

        <li class="nav-item d-none d-lg-block text-white-50 opacity-25 me-2">|</li>

        <li class="nav-item">
          <a href="../perfil.php" class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-white border border-secondary border-opacity-25" style="background: rgba(255,255,255,0.03); transition: 0.2s;" onmouseover="this.style.borderColor='var(--accent-red)'" onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'">
            <i class="bi bi-person-circle fs-5" style="color: var(--accent-red);"></i>
            <span class="small fw-semibold">Meu Perfil</span>
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>

  <!-- MAIN -->
  <main class="container-cadastro">

    <div class="box-cadastro">

      <h2>Cadastro de Administrador</h2>

      <form action="../../CONTROLLER/AdmController.php" method="POST">
        <input type="hidden" name="acao" value="Inserir">

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
          <input type="text" name="nome" class="form-control" placeholder="Nome" required>
        </div>

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          <input type="password" name="senha" class="form-control" placeholder="Senha" required>
        </div>

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
          <input type="text" name="tel" class="form-control" placeholder="Telefone" required>
        </div>

        <button type="submit" class="btn btn-cadastro">
          <i class="bi bi-person-plus-fill me-1"></i> Cadastrar Administrador
        </button>

      </form>

      <div class="extra-links">
        <p><a href="../login.php">Já tem conta? Entrar</a></p>
      </div>

    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>