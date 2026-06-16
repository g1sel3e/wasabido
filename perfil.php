<?php
// Inicia a sessão se ainda não foi iniciada
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Barreira de segurança: Se não estiver logado, volta para o login
if (!isset($_SESSION['cod']) || !isset($_SESSION['tipo'])) {
  header("location: login.php");
  exit();
}

// === IMPORTAÇÃO DOS SEUS DAOS ===
require_once "../DAO/AdmDAO.php";
require_once "../DAO/EntregadorDAO.php";
require_once "../DAO/ClienteDAO.php";

// Captura os dados básicos da sessão
$idUsuario = $_SESSION['cod'];
$nomeUsuario = $_SESSION['nome'];
$tipoUsuario = $_SESSION['tipo']; // 'admin', 'cliente' ou 'entregador'

// Inicializa as variáveis para evitar erros de "Variable undefined" na tela
$emailUsuario = "";
$telefoneUsuario = "";
$cpfUsuario = "";
$rgUsuario = "";
$veiculo = "";
$placa = "";

try {
  // Busca os dados dinamicamente no banco dependendo do tipo de usuário logado
  if ($tipoUsuario == "admin") {
    $adminDAO = new AdmDAO();
    $dados = $adminDAO->buscarPorId($idUsuario);

    if ($dados) {
      $emailUsuario = $dados['email'] ?? "";
      $telefoneUsuario = $dados['tel'] ?? "";
    }

  } elseif ($tipoUsuario == "entregador") {
    $entregadorDAO = new EntregadorDAO();
    $dados = $entregadorDAO->buscarPorId($idUsuario);

    if ($dados) {
      $emailUsuario = $dados['email'] ?? "";
      $telefoneUsuario = $dados['tel'] ?? "";
      $cpfUsuario = $dados['cpf'] ?? "";
      $rgUsuario = $dados['rg'] ?? "";
      $veiculo = $dados['veiculo'] ?? "";
      $placa = $dados['placa'] ?? "";
    }

  } elseif ($tipoUsuario == "cliente") {
    $clienteDAO = new ClienteDAO();
    $dados = $clienteDAO->buscarPorId($idUsuario);

    if ($dados) {
      $emailUsuario = $dados['email'] ?? "";
      $telefoneUsuario = $dados['tel'] ?? "";
      $cpfUsuario = $dados['cpf'] ?? "";
      $rgUsuario = $dados['rg'] ?? "";
    }
  }

} catch (Exception $e) {
  echo "<script>alert('Erro ao carregar dados do banco: " . $e->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Perfil | WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
      background: linear-gradient(rgba(7, 7, 7, 0.85), rgba(7, 7, 7, 0.95)),
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
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
    }

    .navbar-brand img {
      height: 50px;
    }

    .voltar-link {
      color: var(--text-light) !important;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
    }

    .voltar-link:hover {
      color: var(--accent-red) !important;
    }

    /* CONTAINER PRINCIPAL */
    .profile-container {
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .profile-box {
      width: 100%;
      max-width: 600px;
      padding: 40px;
      background: var(--card-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-radius: 20px;
      border: 1px solid var(--card-border);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7);
      animation: fadeIn 0.5s ease-out;
    }

    /* AVATAR DO PERFIL */
    .profile-avatar-wrapper {
      position: relative;
      width: 110px;
      height: 110px;
      margin: 0 auto 20px;
    }

    .profile-avatar {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid var(--accent-red);
      background-color: #111;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: var(--text-light);
    }

    .badge-role {
      position: absolute;
      bottom: -5px;
      left: 50%;
      transform: translateX(-50%);
      background-color: var(--accent-red);
      color: white;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      padding: 4px 12px;
      border-radius: 20px;
      letter-spacing: 0.05em;
      box-shadow: 0 4px 10px rgba(230, 0, 0, 0.4);
    }

    /* ELEMENTOS DE VISUALIZAÇÃO */
    .form-label {
      color: var(--text-muted);
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .input-group {
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid var(--card-border);
      background: var(--input-bg);
      opacity: 0.85;
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
    }

    .input-group-text {
      background: transparent;
      border: none;
      color: #71717a;
      padding-left: 16px;
      padding-right: 10px;
    }

    .btn-address {
      background: transparent;
      border: 1px solid var(--accent-red);
      font-weight: 600;
      padding: 12px;
      border-radius: 10px;
      color: var(--text-light);
      transition: all 0.2s ease;
      text-decoration: none;
      display: inline-block;
      width: 100%;
      text-align: center;
    }

    .btn-address:hover {
      background: var(--accent-red);
      color: #fff;
      box-shadow: 0 4px 12px rgba(230, 0, 0, 0.3);
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(12px);
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
        <img src="../imagens/ws.png" alt="WasabiDO">
      </a>
      <div class="ms-auto">
        <?php

        if ($tipoUsuario == 'admin') {
          $rotaPainel = "adm/adm.php";
        } elseif ($tipoUsuario == 'entregador') {
          $rotaPainel = "entregador/entregador.php"; // <-- Mude aqui para o caminho correto do entregador
        } else {
          $rotaPainel = "cliente/cliente.php";
        }
        ?>
        <a href="<?= $rotaPainel ?>" class="voltar-link">
          <i class="bi bi-arrow-left me-1"></i> Painel Geral
        </a>
      </div>
    </div>
  </nav>

  <main class="profile-container">
    <div class="profile-box">

      <div class="profile-avatar-wrapper">
        <div class="profile-avatar">
          <i class="bi bi-person-circle"></i>
        </div>
        <span class="badge-role">
          <?php
          if ($tipoUsuario == 'admin')
            echo 'Administrador';
          elseif ($tipoUsuario == 'entregador')
            echo 'Entregador';
          else
            echo 'Cliente';
          ?>
        </span>
      </div>

      <h3 class="text-center fw-bold mb-1"><?= htmlspecialchars($nomeUsuario) ?></h3>
      <p class="text-center small text-secondary mb-4">Informações do seu perfil de acesso</p>

      <div class="row g-3">

        <div class="col-md-12">
          <label class="form-label">Nome Completo</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" value="<?= htmlspecialchars($nomeUsuario) ?>" readonly>
          </div>
        </div>

        <div class="col-md-12">
          <label class="form-label">E-mail de Acesso</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" class="form-control" value="<?= htmlspecialchars($emailUsuario) ?>" readonly>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Senha</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
            <input type="text" class="form-control" value="••••••••" readonly>
          </div>
        </div>

        <div class="col-md-6">
          <label class="form-label">Telefone</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
            <input type="text" class="form-control" value="<?= htmlspecialchars($telefoneUsuario) ?>" readonly>
          </div>
        </div>

        <?php if ($tipoUsuario == "entregador" || $tipoUsuario == "cliente"): ?>
          <div class="col-md-6 animate__animated animate__fadeIn">
            <label class="form-label">CPF</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
              <input type="text" class="form-control" value="<?= htmlspecialchars($cpfUsuario) ?>" readonly>
            </div>
          </div>
          <div class="col-md-6 animate__animated animate__fadeIn">
            <label class="form-label">RG</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-card-text"></i></span>
              <input type="text" class="form-control" value="<?= htmlspecialchars($rgUsuario) ?>" readonly>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($tipoUsuario == "entregador"): ?>
          <div class="col-md-6 animate__animated animate__fadeIn">
            <label class="form-label">Veículo / Modelo</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-bicycle"></i></span>
              <input type="text" class="form-control" value="<?= htmlspecialchars($veiculo) ?>" readonly>
            </div>
          </div>
          <div class="col-md-6 animate__animated animate__fadeIn">
            <label class="form-label">Placa</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-reception-4"></i></span>
              <input type="text" class="form-control" value="<?= htmlspecialchars($placa) ?>" readonly>
            </div>
          </div>
        <?php endif; ?>

        <?php if ($tipoUsuario == "cliente"): ?>
          <div class="col-md-12 mt-4 animate__animated animate__fadeIn">
            <label class="form-label d-block text-center mb-2">Endereços Cadastrados</label>
            <a href="cliente/endereco.php" class="btn btn-address">
              <i class="bi bi-geo-alt-fill me-2"></i>Gerenciar Meus Endereços
            </a>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>