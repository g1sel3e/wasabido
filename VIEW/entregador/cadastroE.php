<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Cadastro Entregador - WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --bg-dark: #070707;
      --card-bg: rgba(20, 20, 20, 0.6);
      --card-border: rgba(255, 255, 255, 0.05);
      --text-light: #f4f4f4;
      --text-muted: #a1a1aa;
      --accent-red: #e60000;
      --accent-hover: #ff3333;
    }

    body,
    html {
      margin: 0;
      padding: 0;
      color: var(--text-light);
      font-family: 'Inter', sans-serif;
      background: linear-gradient(rgba(7, 7, 7, 0.8), rgba(7, 7, 7, 0.95)),
        url('https://images.unsplash.com/photo-1553621042-f6e147245754?q=80&w=1400&auto=format&fit=crop') no-repeat center center/cover;
      min-height: 100vh;
    }

    /* NAVBAR INTEGRADA */
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
      color: var(--accent-hover) !important;
    }

    /* CONTAINER DO FORMULÁRIO */
    .container-cadastro {
      min-height: calc(100vh - 75px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .box-cadastro {
      width: 100%;
      max-width: 900px;
      padding: 40px;
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 24px;
      border: 1px solid var(--card-border);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
    }

    h2 {
      text-align: center;
      margin-bottom: 35px;
      font-weight: 800;
      letter-spacing: -0.02em;
      background: linear-gradient(180deg, #ffffff 0%, #d4d4d8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    h6 {
      color: #fff;
      font-weight: 700;
      font-size: 1.05rem;
      margin-bottom: 20px;
      border-left: 3px solid var(--accent-red);
      padding-left: 10px;
    }

    /* INPUTS E SELECTIONS PREMIUM */
    .input-group {
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.08);
      background: #000;
      transition: all 0.3s ease;
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: var(--accent-hover);
      padding-left: 18px;
      padding-right: 10px;
    }

    .form-control,
    .form-select {
      background: transparent;
      border: none;
      color: #fff;
      padding: 12px 15px;
      font-size: 0.95rem;
    }

    .form-control::placeholder {
      color: var(--text-muted);
    }

    /* Reset para o menu do select no tema escuro */
    .form-select option {
      background-color: #0d0d0d;
      color: #fff;
    }

    .form-control:focus,
    .form-select:focus,
    .input-group:focus-within {
      background: transparent;
      color: #fff;
      box-shadow: none;
      outline: none;
    }

    .input-group:focus-within {
      border-color: rgba(230, 0, 0, 0.5);
      box-shadow: 0 0 15px rgba(230, 0, 0, 0.15);
    }

    /* BOTÃO SUBMIT */
    .btn-cadastro {
      width: 100%;
      padding: 14px;
      font-weight: 700;
      font-size: 1rem;
      margin-top: 20px;
      background: var(--accent-red);
      border: none;
      color: #fff;
      border-radius: 12px;
      transition: all 0.2s ease-in-out;
    }

    .btn-cadastro:hover {
      background: var(--accent-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 51, 51, 0.3);
    }

    /* LINKS EXTRAS */
    .extra-links {
      text-align: center;
      margin-top: 20px;
    }

    .extra-links a {
      color: var(--text-muted);
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: color 0.2s;
    }

    .extra-links a:hover {
      color: var(--accent-hover);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <div class="navbar-brand">
        <img src="../../imagens/ws.png" alt="Logo">
      </div>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="../login.php" class="voltar-link">Voltar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container-cadastro">

    <div class="box-cadastro">

      <h2>Cadastro de Entregador</h2>

      <form action="../../CONTROLLER/EntregadorController.php" method="POST">
        <input type="hidden" name="acao" value="Inserir">

        <div class="row g-4">

          <div class="col-md-6">
            <h6>Dados Pessoais</h6>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
              <input type="email" name="email" class="form-control" placeholder="E-mail" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
              <input type="text" name="tel" class="form-control" placeholder="Telefone" required>
            </div>
          </div>

          <div class="col-md-6">
            <h6>Documentos & Veículo</h6>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-credit-card-fill"></i></span>
              <input type="text" name="cpf" class="form-control" placeholder="CPF" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
              <input type="text" name="rg" class="form-control" placeholder="RG" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-truck"></i></span>
              <select name="veiculo" class="form-select" required>
                <option value="" disabled selected>Tipo de veículo</option>
                <option>Moto</option>
                <option>Carro</option>
                <option>Bicicleta</option>
              </select>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-card-text"></i></span>
              <input type="text" name="placa" class="form-control" placeholder="Placa do veículo" required>
            </div>
          </div>

        </div>

        <button type="submit" class="btn btn-cadastro">
          <i class="bi bi-person-plus-fill me-2"></i>Finalizar Cadastro
        </button>

      </form>

      <div class="extra-links">
        <p><a href="../login.php">Já tem uma conta? <strong>Entrar</strong></a></p>
      </div>

    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>