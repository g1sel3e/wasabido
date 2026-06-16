<?php
// Inclui a sua verificação padrão do sistema
require_once __DIR__ . "/../../verificacao.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$cod_cliente_logado = $_SESSION['cod'] ?? null;

// --- BUSCA DE DADOS REAIS DO BANCO ---
require_once __DIR__ . "/../../DAO/PedidoDAO.php";
require_once __DIR__ . "/../../DAO/ProdutoDAO.php";

$pedidoDAO = new PedidoDAO();
$meusPedidos = $pedidoDAO->listarPorCliente($cod_cliente_logado);

// Utiliza o novo método do DAO que já possui o caminho correto da conexão!
$meusEntregadores = $pedidoDAO->listarEntregadores();

// Busca os produtos REAIS cadastrados na tabela do banco
$produtoDAO = new ProdutoDAO();
$meusProdutos = $produtoDAO->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliar - Wasabi</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #0a0a0a;
      font-family: 'Segoe UI', sans-serif;
      color: white;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background-color: #000;
      border-bottom: 3px solid #e60000;
      padding: 0.8rem 0;
    }

    .navbar-brand img {
      height: 50px;
    }

    .card-avaliacao {
      background-color: #111;
      border: 1px solid #222;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }

    .form-label {
      font-weight: 600;
      color: #eee;
    }

    .form-select,
    .form-control {
      background-color: #222;
      border: 1px solid #444;
      color: white;
    }

    .form-select:focus,
    .form-control:focus {
      background-color: #2a2a2a;
      border-color: #e60000;
      color: white;
      box-shadow: 0 0 0 0.25rem rgba(230, 0, 0, 0.25);
    }

    .preview-produto-wrapper {
      display: none;
      justify-content: center;
      width: 100%;
    }

    .preview-produto-box {
      text-align: center;
      background-color: #181818;
      padding: 12px;
      border: 1px solid #252525;
      border-radius: 12px;
      display: inline-block;
      animation: fadeIn 0.3s ease-in-out;
    }

    .preview-produto-box span {
      color: #e60000 !important;
    }

    .img-preview-produto {
      width: 180px;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      border: 3px solid #e60000;
      box-shadow: 0 4px 12px rgba(230, 0, 0, 0.4);
    }

    .info-pedido-box {
      display: none;
      background-color: #161616;
      border-left: 4px solid #e60000;
      border-top: 1px solid #252525;
      border-right: 1px solid #252525;
      border-bottom: 1px solid #252525;
      border-radius: 0 8px 8px 0;
      padding: 15px;
      animation: fadeIn 0.3s ease-in-out;
    }

    .info-pedido-box p.text-muted {
      color: #b5b5b5 !important;
    }

    .info-pedido-box p {
      margin-bottom: 6px;
      font-size: 0.9rem;
    }

    .info-pedido-box p:last-child {
      margin-bottom: 0;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .rating-stars {
      display: flex;
      flex-direction: row-reverse;
      justify-content: start;
      gap: 10px;
    }

    .rating-stars input {
      display: none;
    }

    .rating-stars label {
      font-size: 2.5rem;
      color: #444;
      cursor: pointer;
      transition: color 0.2s ease;
    }

    .rating-stars input:checked~label,
    .rating-stars label:hover,
    .rating-stars label:hover~label {
      color: #e60000;
    }

    .btn-enviar {
      background-color: #e60000;
      color: white;
      font-weight: 600;
      border: none;
      transition: 0.3s;
    }

    .btn-enviar:hover {
      background-color: #b30000;
      transform: scale(1.02);
      color: white;
    }

    .secao-dinamica {
      display: none;
    }

    footer {
      background: #000;
      border-top: 2px solid #e60000;
      padding: 20px 0;
      margin-top: auto;
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
            <a href="../../CONTROLLER/LoginController.php?acao=Logout" class="nav-link text-white-50 me-2">
              <i class="bi bi-box-arrow-left me-1"></i> Sair
            </a>
          <li class="nav-item d-none d-lg-block text-white-50 opacity-25 me-2">|</li>

          <li class="nav-item">
            <a href="../perfil.php" class="nav-link d-flex align-items-center gap-2 px-3 py-2 rounded-3 text-white border border-secondary border-opacity-25" style="background: rgba(255,255,255,0.03);">
              <i class="bi bi-person-circle fs-5" style="color: #e60000;"></i>
              <span class="small fw-semibold">Meu Perfil</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">

        <div class="card-avaliacao">
          <h2 class="text-center mb-2">Deixe sua Avaliação</h2>
          <p class="text-muted text-center mb-4">Escolha a categoria e dê sua nota!</p>

          <form action="../../CONTROLLER/AvaliacaoController.php?action=salvar" method="POST">

            <input type="hidden" name="cod_cliente" value="<?php echo htmlspecialchars($cod_cliente_logado); ?>">

            <div class="mb-3">
              <label for="tipo_avaliacao" class="form-label">O que você deseja avaliar?</label>
              <select name="tipo_avaliacao" id="tipo_avaliacao" class="form-select" required
                onchange="mostrarCamposDinamicamente()">
                <option value="" disabled selected>Selecione uma opção...</option>
                <option value="comida">Um Produto (Comida/Bebida)</option>
                <option value="pedido">Um Pedido Realizado (Entrega)</option>
                <option value="entregador">O Entregador</option>
                <option value="sistema">O Sistema Geral / App</option>
              </select>
            </div>

            <div id="campo-produto" class="mb-3 secao-dinamica">
              <label for="cod_produto" class="form-label">Selecione o Produto:</label>
              <select name="cod_produto" id="cod_produto" class="form-select" onchange="atualizarFotoProduto()">
                <option value="" data-imagem="">Escolha o produto...</option>
                <?php foreach ($meusProdutos as $prod): ?>
                  <option value="<?php echo $prod['cod']; ?>" data-imagem="../produtos/<?php echo $prod['imagem']; ?>">
                    <?php echo htmlspecialchars($prod['nome']); ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <div id="preview-produto-wrapper" class="preview-produto-wrapper mt-3">
                <div class="preview-produto-box">
                  <span class="text-muted d-block mb-2 fs-7 fw-semibold">Item Selecionado</span>
                  <img id="foto-produto-tag" src="" alt="Imagem do Produto" class="img-preview-produto">
                </div>
              </div>
            </div>

            <div id="campo-pedido" class="mb-3 secao-dinamica">
              <label for="cod_pedido" class="form-label">Selecione o Pedido:</label>
              <select name="cod_pedido" id="cod_pedido" class="form-select" onchange="atualizarDetalhesPedido()">
                <option value="" data-valor_total="" data-pagamento="" data-status="" data-data_entrega=""
                  data-entregador="" data-endereco="">Escolha o número do pedido...</option>
                <?php foreach ($meusPedidos as $ped):
                  $dataFormatada = isset($ped['data']) ? date('d/m/Y', strtotime($ped['data'])) : '-';
                  ?>
                  <option value="<?php echo $ped['cod']; ?>"
                    data-valor_total="<?php echo number_format($ped['valor_total'] ?? 0, 2, ',', '.'); ?>"
                    data-pagamento="<?php echo htmlspecialchars($ped['forma_pagamento'] ?? 'Não informado'); ?>"
                    data-status="<?php echo htmlspecialchars($ped['status'] ?? 'Concluído'); ?>"
                    data-data_entrega="<?php echo $dataFormatada; ?>"
                    data-entregador="<?php echo htmlspecialchars($ped['nome_entregador'] ?? 'Não atribuído'); ?>"
                    data-endereco="<?php echo htmlspecialchars($ped['endereco_entrega'] ?? 'Retirada no Balcão / Não informado'); ?>">
                    Pedido nº <?php echo htmlspecialchars($ped['num']); ?> (<?php echo $dataFormatada; ?>)
                  </option>
                <?php endforeach; ?>
              </select>

              <div id="info-pedido-container" class="info-pedido-box mt-3">
                <h6 class="text-white mb-2 fw-semibold"><i class="bi bi-info-circle me-2 text-danger"></i>Resumo do
                  Pedido:</h6>
                <p class="text-muted">Data Realizado: <strong class="text-white" id="info-pedido-data">-</strong></p>
                <p class="text-muted">Entregador Responsável: <strong class="text-white"
                    id="info-pedido-entregador">-</strong></p>
                <p class="text-muted">Endereço de Entrega: <strong class="text-white"
                    id="info-pedido-endereco">-</strong></p>
                <hr class="border-secondary my-2">
                <p class="text-muted">Valor Total: <strong class="text-white">R$ <span
                      id="info-pedido-valor_total">0,00</span></strong></p>
                <p class="text-muted">Pagamento: <strong class="text-white" id="info-pedido-pagamento">-</strong></p>
                <p class="text-muted">Status Atual: <span class="badge bg-secondary text-dark fw-bold"
                    id="info-pedido-status">-</span></p>
              </div>
            </div>

            <div id="campo-entregador" class="mb-3 secao-dinamica">
              <label for="cod_entregador" class="form-label">Selecione o Entregador:</label>
              <select name="cod_entregador" id="cod_entregador" class="form-select"
                onchange="atualizarDetalhesEntregador()">
                <option value="" data-veiculo="" data-placa="">Escolha o entregador...</option>
                <?php foreach ($meusEntregadores as $ent): ?>
                  <option value="<?php echo $ent['cod']; ?>"
                    data-veiculo="<?php echo htmlspecialchars($ent['veiculo'] ?? 'Não cadastrado'); ?>"
                    data-placa="<?php echo htmlspecialchars($ent['placa'] ?? 'Sem placa'); ?>">
                    <?php echo htmlspecialchars($ent['nome']); ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <div id="info-entregador-container" class="info-pedido-box mt-3">
                <h6 class="text-white mb-2 fw-semibold"><i class="bi bi-person-badge me-2 text-danger"></i>Dados do
                  Entregador:</h6>
                <p class="text-muted">Veículo de Entrega: <strong class="text-white"
                    id="info-entregador-veiculo">-</strong></p>
                <p class="text-muted">Placa do Veículo: <strong class="text-white" id="info-entregador-placa">-</strong>
                </p>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label d-block">Sua Nota:</label>
              <div class="rating-stars">
                <input type="radio" name="nota" id="star5" value="5" required /><label for="star5"
                  class="bi bi-star-fill"></label>
                <input type="radio" name="nota" id="star4" value="4" /><label for="star4"
                  class="bi bi-star-fill"></label>
                <input type="radio" name="nota" id="star3" value="3" /><label for="star3"
                  class="bi bi-star-fill"></label>
                <input type="radio" name="nota" id="star2" value="2" /><label for="star2"
                  class="bi bi-star-fill"></label>
                <input type="radio" name="nota" id="star1" value="1" /><label for="star1"
                  class="bi bi-star-fill"></label>
              </div>
            </div>

            <div class="mb-4">
              <label for="comentario" class="form-label">Comentário (Opcional):</label>
              <textarea name="comentario" id="comentario" class="form-control" rows="4"
                placeholder="Conte-nos detalhes da sua experiência..."></textarea>
            </div>

            <button type="submit" class="btn btn-enviar w-100 btn-lg">
              <i class="bi bi-send me-2"></i>Enviar Avaliação
            </button>
          </form>
        </div>

      </div>
    </div>
  </main>

  <footer class="text-center">
    <div class="container">
      <p class="mb-1 text-muted">&copy; 2026 WASABI System</p>
    </div>
  </footer>

  <script>
    function mostrarCamposDinamicamente() {
      var tipo = document.getElementById('tipo_avaliacao').value;

      document.getElementById('campo-produto').style.display = 'none';
      document.getElementById('campo-pedido').style.display = 'none';
      document.getElementById('campo-entregador').style.display = 'none';

      document.getElementById('cod_produto').required = false;
      document.getElementById('cod_pedido').required = false;
      document.getElementById('cod_entregador').required = false;

      // CORRIGIDO: Agora valida corretamente com 'pedido' em vez de 'entrega'
      if (tipo === 'comida') {
        document.getElementById('campo-produto').style.display = 'block';
        document.getElementById('cod_produto').required = true;
        atualizarFotoProduto();
      } else if (tipo === 'pedido') {
        document.getElementById('campo-pedido').style.display = 'block';
        document.getElementById('cod_pedido').required = true;
        atualizarDetalhesPedido();
      } else if (tipo === 'entregador') {
        document.getElementById('campo-entregador').style.display = 'block';
        document.getElementById('cod_entregador').required = true;
        atualizarDetalhesEntregador();
      }
    }

    function atualizarFotoProduto() {
      var select = document.getElementById('cod_produto');
      if (select.selectedIndex === -1) return;

      var opcaoSelecionada = select.options[select.selectedIndex];
      var caminhoImagem = opcaoSelecionada.getAttribute('data-imagem');

      var wrapperPreview = document.getElementById('preview-produto-wrapper');
      var tagImg = document.getElementById('foto-produto-tag');

      if (caminhoImagem && caminhoImagem.trim() !== "" && !caminhoImagem.endsWith('../produtos/')) {
        tagImg.src = caminhoImagem;
        wrapperPreview.style.display = 'flex';
      } else {
        wrapperPreview.style.display = 'none';
        tagImg.src = "";
      }
    }

    function atualizarDetalhesPedido() {
      var select = document.getElementById('cod_pedido');
      if (select.selectedIndex === -1) return;

      var opcaoSelecionada = select.options[select.selectedIndex];

      var valor_total = opcaoSelecionada.getAttribute('data-valor_total');
      var pagamento = opcaoSelecionada.getAttribute('data-pagamento');
      var status = opcaoSelecionada.getAttribute('data-status');
      var dataEntrega = opcaoSelecionada.getAttribute('data-data_entrega');
      var entregador = opcaoSelecionada.getAttribute('data-entregador');
      var endereco = opcaoSelecionada.getAttribute('data-endereco');

      var containerInfo = document.getElementById('info-pedido-container');

      if (select.value !== "" && valor_total !== null && valor_total !== "") {
        document.getElementById('info-pedido-valor_total').innerText = valor_total;
        document.getElementById('info-pedido-pagamento').innerText = pagamento;
        document.getElementById('info-pedido-status').innerText = status;
        document.getElementById('info-pedido-data').innerText = dataEntrega;
        document.getElementById('info-pedido-entregador').innerText = entregador;
        document.getElementById('info-pedido-endereco').innerText = endereco;

        containerInfo.style.display = 'block';
      } else {
        containerInfo.style.display = 'none';
      }
    }

    function atualizarDetalhesEntregador() {
      var select = document.getElementById('cod_entregador');
      if (select.selectedIndex === -1) return;

      var opcaoSelecionada = select.options[select.selectedIndex];

      var veiculo = opcaoSelecionada.getAttribute('data-veiculo');
      var placa = opcaoSelecionada.getAttribute('data-placa');

      var containerInfo = document.getElementById('info-entregador-container');

      if (select.value !== "" && veiculo !== null && veiculo !== "") {
        document.getElementById('info-entregador-veiculo').innerText = veiculo;
        document.getElementById('info-entregador-placa').innerText = placa;

        containerInfo.style.display = 'block';
      } else {
        containerInfo.style.display = 'none';
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


