<?php
if (!isset($_SESSION)) {
  session_start();
}

// Garante que o usuário está logado usando a chave real verificada no print: 'cod'
if (!isset($_SESSION['cod'])) {
  header("Location: ../login.php");
  exit();
}

$idClienteLogado = $_SESSION['cod'];

// CORRIGIDO: Importa o ClienteController usando caminho relativo universal
require_once __DIR__ . "/../../CONTROLLER/ClienteController.php";

// Invoca a função para coletar os endereços associados ao cliente logado
$listaEnderecos = listarEnderecosDoCliente($idClienteLogado);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Meus Endereços - WasabiDO</title>

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

    .container-endereco {
      min-height: calc(100vh - 75px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .box-endereco {
      width: 100%;
      max-width: 1000px;
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

    /* INPUTS MODERNOS */
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

    /* BOTÕES */
    .btn-salvar {
      width: 100%;
      padding: 12px;
      font-weight: 700;
      font-size: 1rem;
      background: var(--accent-red);
      border: none;
      color: #fff;
      border-radius: 12px;
      transition: all 0.2s ease-in-out;
    }

    .btn-salvar:hover {
      background: var(--accent-hover);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 51, 51, 0.3);
    }

    .btn-action {
      padding: 6px 12px;
      border-radius: 8px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    /* TABELA COMPLETAMENTE PRETA */
    .table-responsive {
      background: #000000 !important;
      border-radius: 16px;
      padding: 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table {
      margin-bottom: 0;
      --bs-table-bg: #000000 !important;
      --bs-table-hover-bg: #111111 !important;
    }

    .table th,
    .table td,
    .table td strong,
    .table td small,
    .table td i {
      color: #ffffff !important;
    }

    .table th {
      font-weight: 700;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      border-bottom: 2px solid rgba(255, 255, 255, 0.15) !important;
    }

    .table td {
      vertical-align: middle;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* CUSTOMIZAÇÃO DO MODAL PREMIUM ESCURO */
    .modal-content-custom {
      background: #111111 !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      border-radius: 20px !important;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
    }

    .modal-header-custom {
      border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
      padding: 20px 25px !important;
    }

    .modal-footer-custom {
      border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
      padding: 15px 25px !important;
    }

    .btn-modal-cancelar {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #fff;
      border-radius: 10px;
      padding: 8px 20px;
      font-weight: 600;
    }

    .btn-modal-cancelar:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .btn-modal-excluir {
      background: var(--accent-red);
      border: none;
      color: #fff;
      border-radius: 10px;
      padding: 8px 20px;
      font-weight: 600;
    }

    .btn-modal-excluir:hover {
      background: var(--accent-hover);
      color: #fff;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="inicioE.php" class="navbar-brand">
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
            <a href="cliente.php" class="nav-link voltar-link ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <main class="container-endereco">

    <div class="box-endereco">

      <h2>Gerenciar Meus Endereços</h2>

      <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == '1'): ?>
        <div class="alert alert-success bg-success bg-opacity-20 border-success text-white rounded-3 mb-4">
          <i class="bi bi-check-circle-fill me-2 text-success"></i> Endereço cadastrado com sucesso!
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 'delete'): ?>
        <div class="alert alert-success bg-success bg-opacity-20 border-success text-white rounded-3 mb-4">
          <i class="bi bi-trash-fill me-2 text-success"></i> Endereço removido com sucesso!
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['erro']) && $_GET['erro'] == 'delete'): ?>
        <div class="alert alert-danger bg-danger bg-opacity-20 border-danger text-white rounded-3 mb-4">
          <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i> Erro ao tentar remover o endereço selecionado.
        </div>
      <?php endif; ?>

      <div class="row g-5">
        <div class="col-lg-5">
          <h6>Cadastrar Novo Endereço</h6>

          <form action="../../CONTROLLER/ClienteController.php" method="POST">
            <input type="hidden" name="acao" value="InserirEndereco">
            <input type="hidden" name="cod" value="<?php echo $idClienteLogado; ?>">

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
              <input type="text" name="cep" class="form-control" placeholder="CEP" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-signpost-2-fill"></i></span>
              <input type="text" name="rua" class="form-control" placeholder="Rua / Logradouro" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
              <input type="text" name="num" class="form-control" placeholder="Número" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-building"></i></span>
              <input type="text" name="bairro" class="form-control" placeholder="Bairro" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-geo"></i></span>
              <input type="text" name="cidade" class="form-control" placeholder="Cidade" required>
            </div>

            <div class="mb-3 input-group">
              <span class="input-group-text"><i class="bi bi-plus-square"></i></span>
              <input type="text" name="complemento" class="form-control" placeholder="Complemento (Opcional)">
            </div>

            <button type="submit" class="btn btn-salvar">
              <i class="bi bi-plus-circle-fill me-2"></i>Salvar Endereço
            </button>
          </form>
        </div>

        <div class="col-lg-7">
          <h6>Endereços Cadastrados</h6>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Endereço</th>
                  <th>Cidade</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($listaEnderecos)):
                  foreach ($listaEnderecos as $end):
                    ?>
                    <tr>
                      <td>
                        <strong><?php echo htmlspecialchars($end['rua']); ?>,
                          <?php echo htmlspecialchars($end['num']); ?></strong><br>
                        <small>
                          <?php echo htmlspecialchars($end['bairro']); ?>
                          <?php echo !empty($end['complemento']) ? " - " . htmlspecialchars($end['complemento']) : ""; ?>
                          - CEP <?php echo htmlspecialchars($end['cep']); ?>
                        </small>
                      </td>
                      <td><?php echo htmlspecialchars($end['cidade']); ?></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-action"
                          onclick="confirmarExclusaoModal('<?php echo htmlspecialchars($end['cep']); ?>')">
                          <i class="bi bi-trash3-fill"></i>
                        </button>
                      </td>
                    </tr>
                  <?php
                  endforeach;
                else:
                  ?>
                  <tr>
                    <td colspan="3" class="text-center py-4">
                      <i class="bi bi-geo-fill d-block fs-3 mb-2"></i>
                      Você ainda não possui endereços cadastrados.
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>

  </main>

  <div class="modal fade" id="modalConfirmacaoExcluir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-custom">
        <div class="modal-header modal-header-custom">
          <h5 class="modal-title text-white fw-bold"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
            Excluir Endereço</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-submit="modal" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body text-white-50 p-4">
          Tem certeza que deseja remover este endereço de sua conta? Esta ação não poderá ser desfeita.
        </div>
        <div class="modal-footer modal-footer-custom">
          <button type="button" class="btn btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
          <a id="linkConfirmarExclusao" href="#" class="btn btn-modal-excluir">Sim, Excluir</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function confirmarExclusaoModal(cep) {
      // CORRIGIDO: Rota de exclusão JavaScript sem /wasabido/
      const urlDestino = `../../CONTROLLER/ClienteController.php?acao=ExcluirEndereco&id=${encodeURIComponent(cep)}`;

      document.getElementById('linkConfirmarExclusao').setAttribute('href', urlDestino);

      const meuModal = new bootstrap.Modal(document.getElementById('modalConfirmacaoExcluir'));
      meuModal.show();
    }
  </script>

</body>

</html>
