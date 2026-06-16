<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - WasabiDO</title>

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
      --btn-bg: #0d0d0d;
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

    /* CONTAINER DE CADASTRO */
    .cadastro-container {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    /* CARD ALINHADO AO LOGIN */
    .cadastro-box {
      width: 100%;
      max-width: 390px;
      padding: 40px 35px;
      background: var(--card-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 20px;
      border: 1px solid var(--card-border);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
      text-align: center;
      animation: fadeIn 0.5s ease-out;
    }

    .cadastro-box h2 {
      font-size: 1.6rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.03em;
      margin-bottom: 4px;
    }

    .cadastro-box p {
      font-size: 0.9rem;
      color: var(--text-muted);
      margin-bottom: 28px;
    }

    .logo {
      display: block;
      margin: 0 auto 20px;
      transition: transform 0.3s ease;
    }

    .cadastro-box:hover .logo {
      transform: scale(1.02);
    }

    /* BOTÕES DE OPÇÃO REFINADOS (SAAS) */
    .btn-opcao {
      width: 100%;
      padding: 14px;
      background: var(--btn-bg);
      border: 1px solid var(--card-border);
      color: #e4e4e7;
      border-radius: 10px;
      margin-bottom: 14px;
      font-weight: 600;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-opcao i {
      font-size: 1.1rem;
      color: var(--text-muted);
      transition: color 0.2s ease;
    }

    .btn-opcao:hover {
      background: var(--btn-bg);
      border-color: var(--accent-red);
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(230, 0, 0, 0.15);
    }

    .btn-opcao:hover i {
      color: var(--accent-red);
    }

    .btn-opcao:active {
      transform: translateY(0);
    }

    /* LINKS EXTRAS */
    .extra {
      margin-top: 24px;
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

  <main class="cadastro-container">
    <div class="cadastro-box">

      <img src="../imagens/ws.png" height="60" class="logo" alt="WasabiDO">

      <h2>Cadastro</h2>
      <p>Escolha como deseja se cadastrar no sistema</p>

      <a href="cliente/cadastroC.php" class="btn btn-opcao">
        <i class="bi bi-person-fill me-2"></i>
        Sou Cliente
      </a>

      <a href="entregador/cadastroE.php" class="btn btn-opcao">
        <i class="bi bi-bicycle me-2"></i>
        Sou Entregador
      </a>

      <div class="extra">
        Já tem conta? <a href="login.php">Entrar</a>
      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>