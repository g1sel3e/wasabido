<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Cadastro Cliente - WasabiDO</title>

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

    /* CAPA DO FORMULÁRIO (GLASSMORPHISM) */
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

    /* INPUTS MODERNIOS */
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

    .form-control {
      background: transparent;
      border: none;
      color: #fff;
      padding: 12px 15px;
      font-size: 0.95rem;
    }

    .form-control::placeholder {
      color: var(--text-muted);
    }

    .form-control:focus,
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

    .alert-danger {
      background: rgba(230, 0, 0, 0.15);
      border: 1px solid rgba(230, 0, 0, 0.3);
      color: #ff8888;
      border-radius: 12px;
      font-weight: 500;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <div class="navbar-brand">
        <img src="../../imagens/ws.png" alt="Logo">
      </div>

      <a href="../login.php" class="voltar-link ms-auto">Voltar</a>
    </div>
  </nav>

  <main class="container-cadastro">

    <div class="box-cadastro">

      <h2>Cadastro de Cliente</h2>

      <?php if (isset($_GET['erro']) && $_GET['erro'] == 'email'): ?>
        <div class="alert alert-danger text-center mb-4">
          <i class="bi bi-exclamation-triangle-fill me-2"></i> Este e-mail já está cadastrado em nosso sistema!
        </div>
      <?php endif; ?>

      <form action="../../CONTROLLER/ClienteController.php" method="POST">
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
              <input type="text" name="email" class="form-control" placeholder="E-mail" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
              <input type="text" name="tel" class="form-control" placeholder="Telefone" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-credit-card-fill"></i></span>
              <input type="text" name="cpf" class="form-control" placeholder="CPF" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
              <input type="text" name="rg" class="form-control" placeholder="RG" required>
            </div>

          </div>

          <div class="col-md-6">
            <h6>Endereço de Entrega</h6>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
              <input type="text" name="cep" class="form-control" placeholder="CEP">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-signpost-2-fill"></i></span>
              <input type="text" name="rua" class="form-control" placeholder="Rua / Logradouro">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
              <input type="text" name="num" class="form-control" placeholder="Número">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-building"></i></span>
              <input type="text" name="bairro" class="form-control" placeholder="Bairro">
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-geo"></i></span>
              <input type="text" name="cidade" class="form-control" placeholder="Cidade" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-plus-square"></i></span>
              <input type="text" name="complemento" class="form-control" placeholder="Complemento (Opcional)">
            </div>

          </div>

        </div>

        <button type="submit" class="btn btn-cadastro">
          <i class="bi bi-person-plus-fill me-2"></i>Finalizar Cadastro
        </button>

      </form>

    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>