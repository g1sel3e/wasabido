<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/wasabido/verificacao.php";
include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";

$nome_admin = $_SESSION['nome'] ?? "Administrador";

try {
    $sql = "SELECT * FROM produto ORDER BY nome ASC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar produtos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos | WasabiDO</title>

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

    /* NAVBAR PADRONIZADA */
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

    .btn-sair-nav {
      color: var(--text-muted) !important;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .btn-sair-nav:hover {
      color: var(--text-light) !important;
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

    .main-container { padding: 40px 20px; }

    /* ESTILO DO TÍTULO ORIGINAL */
    .fw-bold { color: #ffffff !important; }

    /* TABELA ESTILO PREMIUM CARD */
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

    /* Badge de Preço */
    .price-badge {
        color: var(--accent-hover);
        font-weight: 700;
    }

    .img-produto {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--card-border);
    }

    /* Botões Gerais */
    .btn-add {
        background-color: var(--accent-red);
        color: white;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        padding: 10px 24px;
        transition: all 0.2s ease;
    }

    .btn-add:hover {
        background-color: var(--accent-hover);
        color: white;
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

    /* MODAIS PREMIUM */
    .modal-content {
        background-color: #0d0d0d;
        border: 1px solid var(--card-border);
        border-radius: 24px;
        color: white;
        padding: 15px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    }
    
    .modal-header {
        border-bottom: none !important;
    }

    .modal-title {
        font-size: 1.3rem;
        letter-spacing: -0.02em;
    }

    .modal-footer {
        border-top: none !important;
    }

    .form-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted) !important; 
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        background-color: #000 !important; 
        border: 1px solid rgba(255,255,255,0.08) !important;
        color: white !important;
        border-radius: 12px;
        padding: 12px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--accent-red) !important;
        box-shadow: 0 0 15px rgba(230, 0, 0, 0.15) !important; 
    }

    textarea.form-control {
        resize: none;
        line-height: 1.6;
    }

    .upload-zone {
        border: 1px dashed rgba(255,255,255,0.15);
        background-color: #050505;
        border-radius: 12px;
        padding: 28px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .upload-zone:hover {
        border-color: var(--accent-red);
        background-color: rgba(230, 0, 0, 0.02);
    }

    .upload-zone i {
        font-size: 1.5rem;
        color: var(--text-muted);
        transition: color 0.2s ease;
    }

    .upload-zone:hover i {
        color: var(--accent-hover);
    }

    .btn-discard {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .btn-discard:hover {
        color: #ffffff;
    }

    .modal-danger-icon {
        background-color: rgba(230, 0, 0, 0.1);
        color: var(--accent-red);
    }

    .btn-confirmar-del {
        background-color: var(--accent-red) !important;
        color: white !important;
    }

    .btn-confirmar-del:hover {
        background-color: var(--accent-hover) !important;
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
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> Operação concluída com sucesso!
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
            <div>
                <h2 class="fw-bold mb-0">Gestão de <span style="color: var(--accent-red);">Produtos</span></h2>
                <p class="small text-white-50 text-truncate mb-0">Controle o cardápio digital do Wasabido</p>
            </div>
            <a href="cadastroP.php" class="btn btn-add">
                <i class="bi bi-plus-circle-fill me-2"></i> Adicionar Produto
            </a>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th width="80">Item</th>
                        <th>Detalhes</th>
                        <th width="150">Preço</th>
                        <th width="120" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($produtos) > 0): ?>
                        <?php foreach ($produtos as $p): ?>
                            <tr>
                                <td>
                                    <?php
                                    $foto = !empty($p['foto1']) ? "../produtos/" . $p['foto1'] : "https://placehold.co/100x100/111/fff?text=Wasabi";
                                    ?>
                                    <img src="<?php echo $foto; ?>" alt="Produto" class="img-produto">
                                </td>
                                <td>
                                    <div class="fw-bold text-white mb-1"><?php echo htmlspecialchars($p['nome']); ?></div>
                                    <div class="small text-white-50 text-truncate" style="max-width: 300px;">
                                        <?php echo htmlspecialchars($p['descricao'] ?? 'Sem descrição cadastrada'); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="price-badge">
                                        R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn-action" 
                                                data-bs-toggle="modal" data-bs-target="#modalEditar"
                                                data-bs-cod="<?php echo $p['cod']; ?>"
                                                data-bs-nome="<?php echo htmlspecialchars($p['nome']); ?>"
                                                data-bs-preco="<?php echo $p['preco']; ?>"
                                                data-bs-categoria="<?php echo htmlspecialchars($p['categoria']); ?>"
                                                data-bs-descricao="<?php echo htmlspecialchars($p['descricao']); ?>"
                                                title="Editar">
                                            <i class="bi bi-pencil-fill" style="font-size: 0.95rem;"></i>
                                        </button>

                                        <button type="button" class="btn-action"
                                                data-bs-toggle="modal" data-bs-target="#modalDeletar"
                                                data-bs-cod="<?php echo $p['cod']; ?>"
                                                data-bs-nome="<?php echo htmlspecialchars($p['nome']); ?>"
                                                title="Excluir">
                                            <i class="bi bi-trash3" style="font-size: 0.95rem;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-inbox text-muted d-block mb-2" style="font-size: 2rem;"></i>
                                <span class="text-muted">Nenhum produto encontrado.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                        <i class="bi bi-sliders text-danger me-2" style="font-size: 1.25rem;"></i> Editar Produto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="font-size: 0.8rem;"></button>
                </div>
                <form action="../../CONTROLLER/ProdutoController.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="acao" value="Atualizar">
                        <input type="hidden" name="cod" id="edit-cod">

                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label">Nome do Item</label>
                                <input type="text" name="nome" id="edit-nome" class="form-control" placeholder="Ex: Temaki de Salmão" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Preço Unitário</label>
                                <input type="number" step="0.01" name="preco" id="edit-preco" class="form-control" placeholder="0,00" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Categoria do Cardápio</label>
                                <select name="categoria" id="edit-categoria" class="form-select" required>
                                    <option value="sushi">Sushi</option>
                                    <option value="sashimi">Sashimi</option>
                                    <option value="ramen">Ramen</option>
                                    <option value="temaki">Temaki</option>
                                    <option value="tempura">Tempurá</option>
                                    <option value="yakitori">Yakitori</option>
                                    <option value="donburi">Donburi</option>
                                    <option value="udon_soba">Udon / Soba</option>
                                    <option value="onigiri">Onigiri</option>
                                    <option value="curry">Curry Japonês</option>
                                    <option value="bebida">Bebidas</option>
                                    <option value="sobremesa">Sobremesas (Wagashi)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descrição dos Ingredientes / Detalhes</label>
                                <textarea name="descricao" id="edit-descricao" class="form-control" rows="4" placeholder="Descreva os componentes do prato..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Imagem do Produto</label>
                                <div class="upload-zone">
                                    <i class="bi bi-cloud-arrow-up-fill"></i>
                                    <span class="text-white fw-medium small">Clique para fazer upload de uma nova foto</span>
                                    <span class="text-muted" style="font-size: 0.75rem;">Formatos aceitos: JPG, PNG ou WEBP</span>
                                    <input type="file" name="foto1" class="form-control form-control-sm bg-transparent border-0 text-white-50 mx-auto mt-2" style="max-width: 290px; font-size: 0.8rem;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-link btn-discard text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-add px-4 py-2" style="border-radius: 12px;">Confirmar Mudanças</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeletar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content">
                <div class="modal-body text-center p-4 pt-5">
                    <div class="d-inline-flex align-items-center justify-content-center modal-danger-icon rounded-circle mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.6rem;"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-2">Excluir Produto?</h5>
                    <p class="text-white-50 small mb-4">
                        Você está prestes a remover <span id="del-nome-produto" class="text-white fw-bold"></span> permanentemente do sistema.
                    </p>
                    
                    <div class="d-flex gap-2 justify-content-center w-100">
                        <button type="button" class="btn btn-action w-50 py-2 fw-medium" data-bs-dismiss="modal" style="border-radius: 12px; height: auto;">Cancelar</button>
                        <a id="btn-confirmar-exclusao" href="#" class="btn btn-add w-50 py-2 d-flex align-items-center justify-content-center btn-confirmar-del">
                            Confirmar Exclusão
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Logica para preencher a telinha de Editar
        const modalEditar = document.getElementById('modalEditar')
        if (modalEditar) {
            modalEditar.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget 
                
                const cod = button.getAttribute('data-bs-cod')
                const nome = button.getAttribute('data-bs-nome')
                const preco = button.getAttribute('data-bs-preco')
                const categoria = button.getAttribute('data-bs-categoria')
                const descricao = button.getAttribute('data-bs-descricao')

                modalEditar.querySelector('#edit-cod').value = cod
                modalEditar.querySelector('#edit-nome').value = nome
                modalEditar.querySelector('#edit-preco').value = preco
                modalEditar.querySelector('#edit-categoria').value = categoria
                modalEditar.querySelector('#edit-descricao').value = descricao
            })
        }

        // Lógica para configurar a telinha de Apagar
        const modalDeletar = document.getElementById('modalDeletar')
        if (modalDeletar) {
            modalDeletar.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const cod = button.getAttribute('data-bs-cod')
                const nome = button.getAttribute('data-bs-nome')
                
                modalDeletar.querySelector('#del-nome-produto').textContent = nome
                modalDeletar.querySelector('#btn-confirmar-exclusao').setAttribute('href', `../../CONTROLLER/ProdutoController.php?acao=Apagar&cod=${cod}`)
            })
        }
    </script>
</body>
</html>