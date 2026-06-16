<?php
session_start();
// Verifica se o controller enviou um sinal de erro via URL (ex: login.php?erro=1)
$erro = $_GET['erro'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --bg-dark: #070707;
      --card-bg: rgba(17, 17, 17, 0.75);
      --card-border: #1f1f1f;
      --text-light: #f4f4f4;
      --text-muted: #a1a1aa;
      --accent-red: #e60000;
      --accent-hover: #ff1a1a;
      --input-bg: #0d0d0d;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      color: var(--text-light);
      background: linear-gradient(rgba(7, 7, 7, 0.82), rgba(7, 7, 7, 0.92)), 
                  url('https://images.unsplash.com/photo-1553621042-f6e147245754?q=80&w=1400&auto=format&fit=crop') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* NAVBAR PREMIUM */
    .navbar {
      background-color: #000;
      border-bottom: 3px solid var(--accent-red);
      padding: 0.8rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
    }

    .navbar-brand img {
      height: 50px;
    }

    .voltar-link {
      color: var(--accent-red) !important;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
    }

    .voltar-link:hover {
      color: #ff3333 !important;
    }

    /* CONTAINER DE LOGIN */
    .login-container {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .login-box {
      width: 100%;
      max-width: 390px;
      padding: 40px 35px;
      background: var(--card-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 20px;
      border: 1px solid var(--card-border);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
      animation: fadeIn 0.5s ease-out;
    }

    .login-box h2 {
      text-align: center;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.03em;
      margin-bottom: 4px;
    }

    /* FORMULÁRIOS ESTILO SAAS */
    .input-group {
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid var(--card-border);
      transition: all 0.2s ease;
      background: var(--input-bg);
    }

    .input-group:focus-within {
      border-color: var(--accent-red);
      box-shadow: 0 0 0 3px rgba(230, 0, 0, 0.15);
    }

    .form-control {
      background: transparent !important;
      border: none;
      color: var(--text-light) !important;
      padding: 12px 14px 12px 4px;
      font-size: 0.95rem;
    }

    .form-control:focus {
      box-shadow: none;
      outline: none;
      background: transparent;
    }

    .form-control::placeholder {
      color: #52525b;
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #71717a;
      padding-left: 16px;
      padding-right: 10px;
      transition: color 0.2s ease;
    }

    .input-group:focus-within .input-group-text {
      color: var(--accent-red);
    }

    /* ALERTA DE ERRO CUSTOMIZADO */
    .alert-danger-custom {
      background: rgba(230, 0, 0, 0.15);
      border: 1px solid rgba(230, 0, 0, 0.3);
      color: #ff6666;
      border-radius: 10px;
      font-size: 0.85rem;
      padding: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* BOTÃO ENTRAR */
    .btn-login {
      width: 100%;
      padding: 12px;
      background: var(--accent-red);
      border: none;
      font-weight: 600;
      font-size: 0.95rem;
      border-radius: 10px;
      color: #fff;
      transition: all 0.2s ease;
      margin-top: 8px;
    }

    .btn-login:hover {
      background: var(--accent-hover);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(230, 0, 0, 0.2);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    /* LINKS EXTRAS */
    .extra {
      margin-top: 24px;
      text-align: center;
      font-size: 0.9rem;
      color: var(--text-muted);
    }

    .extra a {
      color: var(--accent-red);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .extra a:hover {
      color: var(--accent-hover);
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(12px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container"> 
      <a href="#" class="navbar-brand"> 
        <img src="../imagens/ws.png"> 
      </a> 
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav"> 
        <span class="navbar-toggler-icon"></span> 
      </button>
      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"> 
            <a href="../index.php" class="nav-link voltar-link">Voltar</a> 
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="login-container">
    <div class="login-box">

      <h2>Entrar</h2>
      <p class="text-center small text-white-50 mb-4">Acesse sua conta administrativa</p>

      <?php if ($erro): ?>
        <div class="alert alert-danger-custom mb-3" role="alert">
          <i class="bi bi-exclamation-triangle-fill fs-6"></i>
          <div>E-mail ou senha incorretos. Tente novamente.</div>
        </div>
      <?php endif; ?>

      <form action="../CONTROLLER/LoginController.php" method="POST">

        <input type="hidden" name="acao" value="Logar">

        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-envelope-fill"></i>
            </span>
            <input type="email" name="email" class="form-control" placeholder="Seu email" required>
          </div>
        </div>

        <div class="mb-4">
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-lock-fill"></i>
            </span>
            <input type="password" name="senha" class="form-control" placeholder="Sua senha" required>
          </div>
        </div>

        <button type="submit" class="btn btn-login">
          Entrar no Sistema
        </button>

      </form>

      <div class="extra">
        Não tem conta? <a href="cadastro.php">Criar conta</a>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>