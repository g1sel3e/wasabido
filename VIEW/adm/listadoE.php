<?php
require_once __DIR__ . "/../../verificacao.php";
require "../../DAO/EntregadorDAO.php";
require "../../DAO/ClienteDAO.php";
require "../../DAO/AdmDAO.php"; 

$daoEntregador = new EntregadorDAO();
$entregadores = $daoEntregador->listarAprovados();

$daoCliente = new ClienteDAO();
$clientes = $daoCliente->listarClientes();

$daoAdm = new AdmDAO(); 
$admins = $daoAdm->listar(); 

$nome_admin = $_SESSION['adm_nome'] ?? "Administrador";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Usuários | WasabiDO</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* NAVBAR PADRÃO UNIFICADA */
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

        .main-container { 
            padding: 40px 20px; 
        }

        /* ESTILO DO TÍTULO ORIGINAL */
        .fw-bold { color: #ffffff !important; }

        /* ABAS (NAV PILLS) MODERNAS */
        .nav-pills {
            gap: 10px;
        }

        .nav-pills .nav-link {
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--card-border);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .nav-pills .nav-link.active {
            background-color: var(--accent-red);
            color: white;
            border-color: var(--accent-red);
            box-shadow: 0 4px 15px rgba(230, 0, 0, 0.2);
        }

        .nav-pills .nav-link:hover:not(.active) {
            border-color: var(--accent-hover);
            color: var(--accent-hover);
            background: rgba(255, 255, 255, 0.05);
        }

        /* CONTEINER DE TABELA ESTILO PREMIUM CARD */
        .table-container {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            overflow: hidden;
            margin-top: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            padding: 10px;
        }

        .table {
            color: var(--text-light);
            margin-bottom: 0;
        }

        .table thead th {
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 20px;
        }

        .table tbody tr {
            background-color: transparent !important;
            transition: 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        .table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            padding: 18px 20px;
            vertical-align: middle;
            background-color: transparent !important;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .text-detail { color: var(--text-muted); font-size: 0.85rem; }

        .badge-veiculo {
            color: var(--accent-hover);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* BOTÕES DE AÇÃO REDONDOS */
        .btn-action {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            color: var(--text-light);
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            border-color: var(--accent-red);
            color: #fff;
            background: var(--accent-red);
            transform: scale(1.05);
        }

        /* ALERTA REESTILIZADO */
        .alert-success {
            border-radius: 12px;
            font-weight: 500;
            background-color: rgba(25, 135, 84, 0.1) !important;
            border: 1px solid rgba(25, 135, 84, 0.2) !important;
            color: #2ea44f !important;
        }

        /* MODAIS PREMIUM */
        .modal-content {
            background-color: #0d0d0d;
            border: 1px solid var(--card-border);
            border-radius: 24px;
            color: white;
            padding: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        }

        .modal-header h5 {
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .form-control {
            background-color: #000 !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px;
        }

        .form-control:focus {
            border-color: var(--accent-red) !important;
            box-shadow: 0 0 15px rgba(230, 0, 0, 0.15) !important;
        }

        .btn-modal-save {
            background: var(--accent-red);
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-modal-save:hover {
            background: var(--accent-hover);
        }

        .btn-modal-cancel {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 500;
            color: var(--text-muted);
            border: 1px solid var(--card-border);
            transition: 0.2s;
        }

        .btn-modal-cancel:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
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
            <a href="adm.php" class="nav-link voltar-link text-white-50 ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

    <div class="container main-container">
        
        <?php if(isset($_GET['ok'])): ?>
            <div class="alert alert-success border-0 mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i> Ação realizada com sucesso!
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <h2 class="fw-bold">Gestão de <span style="color: var(--accent-red);">Usuários</span></h2>
            <p class="text-detail">Administre entregadores, clientes e a equipe interna.</p>
        </div>

        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="pills-entregadores-tab" data-bs-toggle="pill" data-bs-target="#pills-entregadores" type="button" role="tab">
                    <i class="bi bi-bicycle me-2"></i>Entregadores
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pills-clientes-tab" data-bs-toggle="pill" data-bs-target="#pills-clientes" type="button" role="tab">
                    <i class="bi bi-people me-2"></i>Clientes
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pills-admins-tab" data-bs-toggle="pill" data-bs-target="#pills-admins" type="button" role="tab">
                    <i class="bi bi-shield-lock me-2"></i>Admins
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            
            <div class="tab-pane fade show active" id="pills-entregadores" role="tabpanel">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome e Contato</th>
                                <th>Telefone</th>
                                <th>Veículo / Placa</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($entregadores)): ?>
                                <?php foreach ($entregadores as $e): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($e['nome']) ?></div>
                                            <div class="text-detail"><?= htmlspecialchars($e['email']) ?></div>
                                        </td>
                                        <td class="text-white-50"><?= htmlspecialchars($e['tel']) ?></td>
                                        <td>
                                            <div class="badge-veiculo"><?= htmlspecialchars($e['veiculo']) ?></div>
                                            <div class="text-detail"><?= htmlspecialchars($e['placa']) ?></div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn-action me-1" data-bs-toggle="modal" data-bs-target="#modalEditarEntregador"
                                                    data-bs-id="<?= $e['cod'] ?>" data-bs-nome="<?= htmlspecialchars($e['nome']) ?>"
                                                    data-bs-email="<?= htmlspecialchars($e['email']) ?>" data-bs-tel="<?= htmlspecialchars($e['tel']) ?>"
                                                    data-bs-veiculo="<?= htmlspecialchars($e['veiculo']) ?>" data-bs-placa="<?= htmlspecialchars($e['placa']) ?>"
                                                    title="Editar">
                                                <i class="bi bi-pencil-fill" style="font-size: 0.95rem;"></i>
                                            </button>
                                            <button type="button" class="btn-action" data-bs-toggle="modal" data-bs-target="#modalExcluir" 
                                                    data-bs-id="<?= $e['cod'] ?>" data-bs-nome="<?= htmlspecialchars($e['nome']) ?>" data-bs-tipo="Entregador"
                                                    title="Excluir">
                                                <i class="bi bi-trash3" style="font-size: 0.95rem;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Nenhum entregador cadastrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-clientes" role="tabpanel">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome e Cadastro</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($clientes)): ?>
                                <?php foreach ($clientes as $c): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($c['nome']) ?></div>
                                            <div class="text-detail">ID: #<?= $c['cod'] ?></div>
                                        </td>
                                        <td class="text-white-50"><?= htmlspecialchars($c['email']) ?></td>
                                        <td class="text-white-50"><?= htmlspecialchars($c['tel']) ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn-action me-1" data-bs-toggle="modal" data-bs-target="#modalEditarCliente"
                                                    data-bs-id="<?= $c['cod'] ?>" data-bs-nome="<?= htmlspecialchars($c['nome']) ?>"
                                                    data-bs-email="<?= htmlspecialchars($c['email']) ?>" data-bs-tel="<?= htmlspecialchars($c['tel']) ?>"
                                                    title="Editar">
                                                <i class="bi bi-pencil-fill" style="font-size: 0.95rem;"></i>
                                            </button>
                                            <button type="button" class="btn-action" data-bs-toggle="modal" data-bs-target="#modalExcluir" 
                                                    data-bs-id="<?= $c['cod'] ?>" data-bs-nome="<?= htmlspecialchars($c['nome']) ?>" data-bs-tipo="Cliente"
                                                    title="Excluir">
                                                <i class="bi bi-trash3" style="font-size: 0.95rem;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Nenhum cliente cadastrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-admins" role="tabpanel">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome / E-mail</th>
                                <th>Telefone</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admins)): ?>
                                <?php foreach ($admins as $a): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($a['nome']) ?></div>
                                            <div class="text-detail"><?= htmlspecialchars($a['email']) ?></div>
                                        </td>
                                        <td class="text-white-50"><?= htmlspecialchars($a['tel']) ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn-action me-1" 
                                                    data-bs-toggle="modal" data-bs-target="#modalEditarAdm"
                                                    data-bs-id="<?= $a['cod'] ?>" 
                                                    data-bs-nome="<?= htmlspecialchars($a['nome']) ?>"
                                                    data-bs-email="<?= htmlspecialchars($a['email']) ?>" 
                                                    data-bs-tel="<?= htmlspecialchars($a['tel']) ?>"
                                                    title="Editar">
                                                <i class="bi bi-pencil-fill" style="font-size: 0.95rem;"></i>
                                            </button>
                                            <?php if($a['cod'] != ($_SESSION['adm_id'] ?? 0)): ?>
                                                <button type="button" class="btn-action" 
                                                        data-bs-toggle="modal" data-bs-target="#modalExcluir" 
                                                        data-bs-id="<?= $a['cod'] ?>" 
                                                        data-bs-nome="<?= htmlspecialchars($a['nome']) ?>" 
                                                        data-bs-tipo="Admin"
                                                        title="Excluir">
                                                    <i class="bi bi-trash3" style="font-size: 0.95rem;"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3" class="text-center py-5 text-muted">Nenhum administrador cadastrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalEditarEntregador" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../../CONTROLLER/EntregadorController.php" method="POST">
                    <input type="hidden" name="acao" value="Atualizar">
                    <input type="hidden" name="cod" id="edit-ent-id">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Editar Entregador</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="text-detail mb-1">Nome</label>
                            <input type="text" name="nome" id="edit-ent-nome" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-detail mb-1">Email</label>
                                <input type="email" name="email" id="edit-ent-email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-detail mb-1">Telefone</label>
                                <input type="text" name="tel" id="edit-ent-tel" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-detail mb-1">Veículo</label>
                                <input type="text" name="veiculo" id="edit-ent-veiculo" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-detail mb-1">Placa</label>
                                <input type="text" name="placa" id="edit-ent-placa" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-modal-save">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../../CONTROLLER/ClienteController.php" method="POST">
                    <input type="hidden" name="acao" value="Atualizar">
                    <input type="hidden" name="cod" id="edit-cli-id">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Editar Cliente</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="text-detail mb-1">Nome</label>
                            <input type="text" name="nome" id="edit-cli-nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-detail mb-1">Email</label>
                            <input type="email" name="email" id="edit-cli-email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-detail mb-1">Telefone</label>
                            <input type="text" name="tel" id="edit-cli-tel" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-modal-save">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarAdm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="../../CONTROLLER/AdmController.php" method="POST">
                    <input type="hidden" name="acao" value="Atualizar">
                    <input type="hidden" name="cod" id="edit-adm-id">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Editar Administrador</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="text-detail mb-1">Nome</label>
                            <input type="text" name="nome" id="edit-adm-nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-detail mb-1">Email</label>
                            <input type="email" name="email" id="edit-adm-email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-detail mb-1">Telefone</label>
                            <input type="text" name="tel" id="edit-adm-tel" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="text-detail mb-1">Senha</label>
                            <input type="password" name="senha" class="form-control" placeholder="Mantenha vazia ou digite uma nova">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-modal-save">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Confirmar Remoção</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-white-50">
                    Deseja realmente remover o <span id="tipoExcluir"></span> <span id="nomeExcluir" class="text-white fw-bold"></span> do sistema? Esta ação não pode ser desfeita.
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <a id="linkConfirmarExcluir" href="#" class="btn btn-modal-save bg-danger">Remover Permanentemente</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Modal Excluir (Diferencia Cliente, Entregador e Admin)
        const modalExcluir = document.getElementById('modalExcluir');
        modalExcluir.addEventListener('show.bs.modal', event => {
            const btn = event.relatedTarget;
            const tipo = btn.getAttribute('data-bs-tipo');
            
            let controller = 'EntregadorController';
            if (tipo === 'Cliente') controller = 'ClienteController';
            if (tipo === 'Admin') controller = 'AdmController';
            
            document.getElementById('tipoExcluir').textContent = tipo.toLowerCase();
            document.getElementById('nomeExcluir').textContent = btn.getAttribute('data-bs-nome');
            document.getElementById('linkConfirmarExcluir').href = `../../CONTROLLER/${controller}.php?acao=Apagar&cod=${btn.getAttribute('data-bs-id')}`;
        });

        // Modal Editar Entregador
        const modalEditarEnt = document.getElementById('modalEditarEntregador');
        modalEditarEnt.addEventListener('show.bs.modal', event => {
            const btn = event.relatedTarget;
            document.getElementById('edit-ent-id').value = btn.getAttribute('data-bs-id');
            document.getElementById('edit-ent-nome').value = btn.getAttribute('data-bs-nome');
            document.getElementById('edit-ent-email').value = btn.getAttribute('data-bs-email');
            document.getElementById('edit-ent-tel').value = btn.getAttribute('data-bs-tel');
            document.getElementById('edit-ent-veiculo').value = btn.getAttribute('data-bs-veiculo');
            document.getElementById('edit-ent-placa').value = btn.getAttribute('data-bs-placa');
        });

        // Modal Editar Cliente
        const modalEditarCli = document.getElementById('modalEditarCliente');
        modalEditarCli.addEventListener('show.bs.modal', event => {
            const btn = event.relatedTarget;
            document.getElementById('edit-cli-id').value = btn.getAttribute('data-bs-id');
            document.getElementById('edit-cli-nome').value = btn.getAttribute('data-bs-nome');
            document.getElementById('edit-cli-email').value = btn.getAttribute('data-bs-email');
            document.getElementById('edit-cli-tel').value = btn.getAttribute('data-bs-tel');
        });

        // Modal Editar Admin
        const modalEditarAdm = document.getElementById('modalEditarAdm');
        modalEditarAdm.addEventListener('show.bs.modal', event => {
            const btn = event.relatedTarget;
            document.getElementById('edit-adm-id').value = btn.getAttribute('data-bs-id');
            document.getElementById('edit-adm-nome').value = btn.getAttribute('data-bs-nome');
            document.getElementById('edit-adm-email').value = btn.getAttribute('data-bs-email');
            document.getElementById('edit-adm-tel').value = btn.getAttribute('data-bs-tel');
        });
    </script>
</body>
</html>
