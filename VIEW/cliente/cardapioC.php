<?php
session_start();
require "../../DAO/ProdutoDAO.php";

$dao = new ProdutoDAO();
$produtos = $dao->listar();
$nome = $_SESSION['nome'] ?? "Cliente";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cardápio | WasabiDO</title>

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

    body, html {
      margin: 0;
      padding: 0;
      background-color: var(--bg-dark);
      color: var(--text-light);
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
    }

    /* NAVBAR */
    .navbar {
      background-color: #000;
      border-bottom: 3px solid var(--accent-red);
      padding: 0.8rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
    }

    .navbar-brand img { height: 50px; }

    .voltar-link {
      color: #eee !important;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
    }
    .voltar-link:hover { color: var(--accent-red) !important; }

    /* TÍTULO INICIAL */
    .titulo {
      text-align: center;
      padding: 3rem 1rem 1.5rem;
    }
    .titulo h1 { font-size: 2.8rem; font-weight: 800; }
    .titulo span { color: var(--accent-red); }
    .titulo p { color: #bbb; font-size: 1rem; }

    /* FILTRO DE BUSCA AJUSTADO GOURMET */
    .search-box-gourmet {
      position: relative;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 50px;
      padding: 4px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
    }

    .search-box-gourmet:focus-within {
      border-color: var(--accent-red);
      background: rgba(230, 0, 0, 0.02);
      box-shadow: 0 0 15px rgba(230, 0, 0, 0.2);
    }

    .search-icon {
      color: var(--text-muted);
      font-size: 1.2rem;
      margin-left: 20px;
      transition: color 0.3s ease;
    }

    .search-box-gourmet:focus-within .search-icon {
      color: var(--accent-hover);
    }

    .input-gourmet {
      background: transparent !important;
      border: none !important;
      color: #fff !important;
      padding: 12px 20px 12px 12px !important;
      width: 100%;
      font-size: 1rem;
      outline: none;
    }

    .input-gourmet::placeholder {
      color: rgba(255, 255, 255, 0.3);
    }

    /* SELETOR DE PREÇO GOURMET */
    .select-custom {
      background-color: #111 !important;
      color: var(--text-light) !important;
      border: 1px solid var(--card-border) !important;
      border-radius: 12px !important;
      padding: 0.5rem 2rem 0.5rem 1rem !important;
      font-weight: 600;
      font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .select-custom:focus {
      border-color: var(--accent-red) !important;
      box-shadow: 0 0 0 0.25rem rgba(230, 0, 0, 0.20) !important;
    }

    /* BOTÃO TOGGLE CATEGORIAS */
    .btn-toggle-categorias {
      background: transparent;
      border: none;
      color: var(--text-muted);
      font-size: 0.9rem;
      font-weight: 500;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      transition: color 0.2s ease;
    }
    .btn-toggle-categorias:hover, .btn-toggle-categorias.active {
      color: var(--accent-hover);
    }

    /* CONTAINER DE CATEGORIAS (SCROLL HORIZONTAL) */
    .categorias-scroll-wrapper {
      display: flex;
      gap: 12px;
      overflow-x: auto;
      padding: 15px 5px;
      white-space: nowrap;
      scroll-behavior: smooth;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
    }

    .categorias-scroll-wrapper::-webkit-scrollbar {
      display: none;
    }

    /* PASTILHAS DE CATEGORIA */
    .category-pill {
      flex: 0 0 auto;
      background: rgba(20, 20, 20, 0.8);
      border: 1px solid rgba(255, 255, 255, 0.08);
      padding: 10px 24px;
      border-radius: 30px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-pill .pill-text {
      color: var(--text-muted);
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0.03em;
    }

    .category-pill:hover {
      background: rgba(255, 255, 255, 0.03);
      border-color: rgba(255, 255, 255, 0.2);
    }

    .category-pill:hover .pill-text { color: #fff; }

    .category-pill.active {
      background: var(--accent-red) !important;
      border-color: var(--accent-red) !important;
      box-shadow: 0 6px 20px rgba(230, 0, 0, 0.3);
    }

    .category-pill.active .pill-text { color: #fff !important; }

    /* CARDS DE PRODUTO GOURMET */
    .card-produto {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 24px;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
      border: 1px solid var(--card-border);
      height: 100%;
      position: relative;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    }

    .card-img-wrapper { position: relative; overflow: hidden; border-radius: 24px 24px 0 0; }
    .card-produto img { height: 230px; width: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1); }
    
    .card-produto:hover { 
      transform: translateY(-8px); 
      border-color: rgba(230, 0, 0, 0.4); 
      box-shadow: 0 20px 40px rgba(230, 0, 0, 0.15); 
    }
    .card-produto:hover img { transform: scale(1.06); }

    .badge-preco {
      position: absolute; top: 16px; right: 16px;
      background: rgba(230, 0, 0, 0.9); backdrop-filter: blur(8px);
      color: #fff; padding: 8px 16px; border-radius: 30px;
      font-weight: 700; font-size: 0.95rem; z-index: 2;
    }

    .view-details-overlay {
      position: absolute; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.3s ease; font-size: 2rem; color: #fff; z-index: 1;
    }
    .card-produto:hover .view-details-overlay { opacity: 1; }

    .card-body-custom { padding: 1.5rem; text-align: left; }
    .nome-produto { font-size: 1.2rem; font-weight: 700; color: #fff; margin-bottom: 5px; display: block; letter-spacing: -0.02em; }
    .ver-mais-text { font-size: 0.85rem; color: var(--accent-hover); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 15px; }

    .btn-add {
      background-color: var(--accent-red);
      color: #fff;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      padding: 11px;
      transition: all 0.2s ease-in-out;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      position: relative;
      z-index: 3;
    }

    .btn-add:hover {
      background-color: var(--accent-hover);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(255, 51, 51, 0.35);
    }

    /* CARROSSEL NO MODAL */
    .carousel-container-custom {
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.05);
      background: #000;
      position: relative;
    }

    .carousel-item img { height: 380px; width: 100%; object-fit: cover; }

    .carousel-control-prev, .carousel-control-next {
      width: 45px; height: 45px; background: rgba(0, 0, 0, 0.6); border-radius: 50%;
      top: 50%; transform: translateY(-50%); margin: 0 15px;
      border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.2s ease; opacity: 0;
    }

    .carousel-container-custom:hover .carousel-control-prev,
    .carousel-container-custom:hover .carousel-control-next { opacity: 1; }
    .carousel-control-prev:hover, .carousel-control-next:hover { background: var(--accent-red); border-color: var(--accent-red); }

    .carousel-indicators [data-bs-target] {
      width: 28px; height: 4px; background-color: rgba(255, 255, 255, 0.3);
      border: none; border-radius: 2px; transition: all 0.3s ease; margin: 0 4px;
    }
    .carousel-indicators .active { background-color: var(--accent-red); width: 40px; }

    /* BARRA LATERAL (OFFCANVAS) */
    .offcanvas-custom {
      background-color: #0a0a0a !important;
      border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .list-group-item {
      background: rgba(20, 20, 20, 0.6) !important;
      border: 1px solid rgba(255, 255, 255, 0.05) !important;
      color: #eee;
      border-radius: 16px !important;
      margin-bottom: 12px;
      padding: 15px !important;
    }

    /* CONTROLES DE QUANTIDADE */
    .cart-controls {
      display: flex;
      align-items: center;
      background: rgba(0, 0, 0, 0.4);
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: 10px;
      padding: 2px;
    }
    .btn-qty {
      background: transparent;
      border: none;
      color: #fff !important;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      border-radius: 8px;
      transition: background 0.2s;
    }
    .btn-qty:hover { background: rgba(255, 255, 255, 0.15); }
    .btn-qty i { color: #fff !important; font-weight: 800; }
    
    .qty-number {
      min-width: 25px;
      text-align: center;
      font-weight: 600;
      font-size: 0.9rem;
      color: #fff;
    }
    .btn-remove-item {
      background: transparent;
      border: none;
      color: #ef4444;
      padding: 5px 8px;
      font-size: 1.1rem;
      transition: color 0.2s;
    }
    .btn-remove-item:hover { color: #ff6b6b; }

    .total-container {
      background: #000;
      border: 1px solid rgba(255, 255, 255, 0.08);
      padding: 22px;
      border-radius: 20px;
      color: white;
      margin-top: auto;
      box-shadow: 0 -10px 30px rgba(0,0,0,0.5);
    }

    .total-container #totalValor {
      color: var(--accent-hover);
      text-shadow: 0 0 20px rgba(255, 51, 51, 0.2);
    }

    .btn-finalizar {
      background: var(--accent-red);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-weight: 700;
      padding: 12px;
      transition: all 0.2s ease;
    }
    .btn-finalizar:hover {
      background: var(--accent-hover);
      color: #fff;
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(255, 51, 51, 0.3);
    }

    /* BOTÃO FLUTUANTE DE CARRINHO */
    #btnCart {
      position: fixed;
      bottom: 35px;
      right: 35px;
      width: 68px;
      height: 68px;
      border-radius: 22px;
      background: var(--accent-red);
      border: none;
      color: white;
      font-size: 26px;
      box-shadow: 0 10px 30px rgba(230, 0, 0, 0.45);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    #btnCart:hover { transform: scale(1.05); background: var(--accent-hover); }

    .cart-count {
      position: absolute;
      top: -6px;
      right: -6px;
      background: white;
      color: var(--accent-red);
      border-radius: 9px;
      min-width: 25px;
      height: 25px;
      font-size: 13px;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
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

  <div class="titulo">
    <h1>Cardápio da <span>WasabiDO</span></h1>
    <p>Olá, <strong><?= htmlspecialchars($nome) ?></strong>! Selecione as melhores peças da culinária japonesa.</p>
  </div>

  <div class="container mb-5">
    <div class="row g-3 justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="search-box-gourmet">
          <i class="bi bi-search search-icon"></i>
          <input type="text" id="inputBuscaNome" class="input-gourmet" placeholder="O que você deseja saborear hoje?..." oninput="filtrarEOrdenarCardapio()">
        </div>
      </div>

      <div class="col-12 text-center mt-3 d-flex justify-content-center gap-3 flex-wrap align-items-center">
        <button class="btn-toggle-categorias" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="true" id="btnFiltroCategorias">
          <i class="bi bi-sliders2 me-2"></i> Filtrar por Categoria
        </button>

        <span class="text-white-50 opacity-25 d-none d-sm-inline">|</span>

        <div class="d-flex align-items-center gap-2">
          <label class="small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px; font-size: 0.75rem;">
            <i class="bi bi-arrow-down-up text-danger me-1"></i> Ordenar:
          </label>
          <select id="selectOrdemPreco" class="form-select select-custom" onchange="filtrarEOrdenarCardapio()">
            <option value="padrao">Padrão do Chefe</option>
            <option value="menor">Menor Preço</option>
            <option value="maior">Maior Preço</option>
          </select>
        </div>
      </div>
    </div>

    <div class="collapse show mt-4" id="collapseCategorias">
      <div class="categorias-scroll-wrapper">
        <div class="category-pill active" data-value="todos" onclick="selecionarCategoria(this)"><span class="pill-text">Todos</span></div>
        <div class="category-pill" data-value="sushi" onclick="selecionarCategoria(this)"><span class="pill-text">Sushi</span></div>
        <div class="category-pill" data-value="sashimi" onclick="selecionarCategoria(this)"><span class="pill-text">Sashimi</span></div>
        <div class="category-pill" data-value="ramen" onclick="selecionarCategoria(this)"><span class="pill-text">Ramen</span></div>
        <div class="category-pill" data-value="temaki" onclick="selecionarCategoria(this)"><span class="pill-text">Temaki</span></div>
        <div class="category-pill" data-value="tempura" onclick="selecionarCategoria(this)"><span class="pill-text">Tempurá</span></div>
        <div class="category-pill" data-value="yakitori" onclick="selecionarCategoria(this)"><span class="pill-text">Yakitori</span></div>
        <div class="category-pill" data-value="donburi" onclick="selecionarCategoria(this)"><span class="pill-text">Donburi</span></div>
        <div class="category-pill" data-value="udon_soba" onclick="selecionarCategoria(this)"><span class="pill-text">Udon / Soba</span></div>
        <div class="category-pill" data-value="onigiri" onclick="selecionarCategoria(this)"><span class="pill-text">Onigiri</span></div>
        <div class="category-pill" data-value="curry" onclick="selecionarCategoria(this)"><span class="pill-text">Curry Japonês</span></div>
        <div class="category-pill" data-value="bebida" onclick="selecionarCategoria(this)"><span class="pill-text">Bebidas</span></div>
        <div class="category-pill" data-value="sobremesa" onclick="selecionarCategoria(this)"><span class="pill-text">Sobremesas (Wagashi)</span></div>
      </div>
    </div>
  </div>

  <main class="container pb-5">
    <div class="row g-4" id="gridProdutos">
      <?php foreach ($produtos as $p): ?>
        <div class="col-md-6 col-lg-4 item-produto" 
             data-categoria="<?= htmlspecialchars(trim(strtolower($p['categoria'] ?? ''))) ?>" 
             data-nome="<?= htmlspecialchars(strtolower($p['nome'])) ?>"
             data-preco="<?= $p['preco'] ?>">
          <div class="card-produto">
            
            <div class="card-img-wrapper" data-bs-toggle="modal" data-bs-target="#modal<?= $p['cod'] ?>" style="cursor: pointer;">
              <span class="badge-preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span>
              <div class="view-details-overlay"><i class="bi bi-eye"></i></div>
              <img src="../produtos/<?= $p['foto1'] ?: 'https://via.placeholder.com/300x200?text=Sem+Imagem' ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
            </div>

            <div class="card-body-custom">
              <div data-bs-toggle="modal" data-bs-target="#modal<?= $p['cod'] ?>" style="cursor: pointer;">
                <span class="nome-produto text-truncate"><?= htmlspecialchars($p['nome']) ?></span>
                <span class="ver-mais-text">Ver detalhes <i class="bi bi-arrow-right ms-1"></i></span>
              </div>
              <button class="btn btn-add w-100" onclick="adicionarCarrinho(<?= $p['cod'] ?>, '<?= addslashes($p['nome']) ?>', <?= $p['preco'] ?>)">
                <i class="bi bi-cart-plus fs-5"></i> Adicionar ao Pedido
              </button>
            </div>

          </div>
        </div>

        <div class="modal fade" id="modal<?= $p['cod'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background: #0a0a0a; border: 1px solid rgba(255,255,255,0.08); border-radius: 24px;">
              <div class="modal-header" style="background: #000; border-bottom: 1px solid rgba(255,255,255,0.04);">
                <h5 class="modal-title fw-bold" style="color: #fff;"><?= htmlspecialchars($p['nome']) ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body p-4">
                <div class="carousel-container-custom mb-3">
                  <div id="carousel<?= $p['cod'] ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                      <?php 
                      $count = 0;
                      for ($i = 1; $i <= 4; $i++) {
                        if (!empty($p["foto$i"])) {
                          echo '<button type="button" data-bs-target="#carousel'.$p['cod'].'" data-bs-slide-to="'.$count.'" class="'.($count === 0 ? 'active' : '').'"></button>';
                          $count++;
                        }
                      }
                      ?>
                    </div>
                    <div class="carousel-inner">
                      <?php $active = true; ?>
                      <?php for ($i = 1; $i <= 4; $i++) {
                        $foto = "foto$i";
                        if (!empty($p[$foto])) { ?>
                          <div class="carousel-item <?= $active ? 'active' : '' ?>">
                            <img src="../produtos/<?= $p[$foto] ?>" class="d-block w-100" alt="Foto">
                          </div>
                          <?php $active = false; ?>
                        <?php }
                      } 
                      if ($active) { ?>
                        <div class="carousel-item active">
                          <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" class="d-block w-100" alt="Sem Imagem">
                        </div>
                      <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $p['cod'] ?>" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $p['cod'] ?>" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                  </div>
                </div>
                <p class="text-secondary mb-4"><?= htmlspecialchars($p['descricao'] ?? 'Sem descrição disponível.') ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <h4 style="color: var(--accent-hover); font-weight: 800; margin: 0;">R$ <?= number_format($p['preco'], 2, ',', '.') ?></h4>
                  <button class="btn btn-add" data-bs-dismiss="modal" onclick="adicionarCarrinho(<?= $p['cod'] ?>, '<?= addslashes($p['nome']) ?>', <?= $p['preco'] ?>)">
                    <i class="bi bi-cart-plus fs-5"></i> Adicionar ao Pedido
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <div id="msgFiltroVazio" class="text-center py-5 text-secondary d-none">
      <i class="bi bi-search fs-1 d-block mb-3 opacity-25"></i>
      Nenhum produto encontrado correspondente à busca.
    </div>
  </main>

  <div class="offcanvas offcanvas-end offcanvas-custom text-bg-dark shadow" tabindex="-1" id="carrinhoLateral" aria-labelledby="carrinhoLabel">
    <div class="offcanvas-header border-bottom border-secondary border-opacity-10 p-4">
      <div class="d-flex align-items-center">
        <div class="bg-danger p-2 rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
          <i class="bi bi-bag-check-fill fs-5 text-white"></i>
        </div>
        <h5 class="offcanvas-title fw-bold" id="carrinhoLabel">Resumo do Pedido</h5>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-4 d-flex flex-column">
      <ul id="listaCarrinho" class="list-group list-group-flush mb-4 flex-grow-1 overflow-auto pe-2" style="max-height: 55vh;">
        <?php
        $total = 0;
        if (!empty($_SESSION['carrinho'])):
          foreach ($_SESSION['carrinho'] as $idItem => $item):
            $subtotal = $item['preco'] * $item['quantidade'];
            $total += $subtotal;
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3" id="item-<?= $idItem ?>">
              <div style="max-width: 55%;">
                <span class="fw-bold text-white d-block mb-1 text-truncate" style="font-size: 0.95rem;"><?= htmlspecialchars($item['nome']) ?></span>
                <span class="fw-bold item-subtotal" style="color: var(--accent-hover);" data-preco="<?= $item['preco'] ?>">
                  R$ <?= number_format($subtotal, 2, ',', '.') ?>
                </span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <div class="cart-controls">
                  <button class="btn-qty" onclick="atualizarQuantidade(<?= $idItem ?>, 'subtrair', <?= $item['preco'] ?>)">
                    <i class="bi bi-minus text-white"></i>
                  </button>
                  <span class="qty-number" id="qty-<?= $idItem ?>"><?= $item['quantidade'] ?></span>
                  <button class="btn-qty" onclick="atualizarQuantidade(<?= $idItem ?>, 'somar', <?= $item['preco'] ?>)">
                    <i class="bi bi-plus text-white"></i>
                  </button>
                </div>
                <button class="btn-remove-item" onclick="atualizarQuantidade(<?= $idItem ?>, 'remover', <?= $item['preco'] ?>)" title="Remover item">
                  <i class="bi bi-trash3-fill"></i>
                </button>
              </div>
            </li>
          <?php endforeach; else: ?>
          <li id="mensagemVazio" class="list-group-item text-center py-5 bg-transparent border-0 text-secondary">
            <i class="bi bi-cart-x fs-1 d-block mb-3 opacity-25"></i>Seu carrinho está vazio.
          </li>
        <?php endif; ?>
      </ul>

      <div class="total-container" id="containerTotal" style="<?= $total == 0 ? 'display:none;' : '' ?>">
        <span class="d-block opacity-50 small text-uppercase fw-bold mb-1">Valor Total</span>
        <h3 class="mb-4 fw-800" id="totalValor">R$ <?= number_format($total, 2, ',', '.') ?></h3>
        <form method="POST" action="../../CONTROLLER/PedidoController.php">
          <input type="hidden" name="acao" value="Finalizar">
          <input type="hidden" name="total" id="inputTotal" value="<?= $total ?>">
          <button class="btn btn-finalizar py-3 w-100 shadow-sm text-uppercase font-weight-bold">
            Finalizar Pedido <i class="bi bi-arrow-right ms-1"></i>
          </button>
        </form>
      </div>
    </div>
  </div>

  <button type="button" id="btnCart" data-bs-toggle="offcanvas" data-bs-target="#carrinhoLateral">
    <i class="bi bi-cart3"></i>
    <?php
    $count = 0;
    if (!empty($_SESSION['carrinho'])) {
      foreach ($_SESSION['carrinho'] as $item) { $count += $item['quantidade']; }
    }
    ?>
    <span class="cart-count" id="globalCartCount" style="<?= $count == 0 ? 'display:none;' : '' ?>"><?= $count ?></span>
  </button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Animação inicial dos cards
    const cards = document.querySelectorAll('.card-produto');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(25px)';
      setTimeout(() => {
        card.style.transition = 'all 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 80);
    });

    // LÓGICA DE FILTRAGEM E ORDENAÇÃO DINÂMICA
    let categoriaSelecionada = "todos";

    function selecionarCategoria(elemento) {
      document.querySelectorAll('.category-pill').forEach(pill => pill.classList.remove('active'));
      elemento.classList.add('active');
      categoriaSelecionada = elemento.getAttribute('data-value').trim().toLowerCase();
      filtrarEOrdenarCardapio();
    }

    function filtrarEOrdenarCardapio() {
      const termoBusca = document.getElementById('inputBuscaNome').value.toLowerCase().trim();
      const grid = document.getElementById('gridProdutos');
      const itens = Array.from(grid.querySelectorAll('.item-produto')); 
      const msgVazio = document.getElementById('msgFiltroVazio');
      const criterioPreco = document.getElementById('selectOrdemPreco').value;
      
      let encontrouQualquer = false;

      itens.forEach(item => {
        const categoriaItem = item.getAttribute('data-categoria') ? item.getAttribute('data-categoria').trim().toLowerCase() : '';
        const nomeItem = item.getAttribute('data-nome') ? item.getAttribute('data-nome') : '';

        const bateCategoria = (categoriaSelecionada === 'todos' || categoriaItem === categoriaSelecionada);
        const bateNome = (termoBusca === '' || nomeItem.includes(termoBusca));

        if (bateCategoria && bateNome) {
          item.classList.remove('d-none');
          encontrouQualquer = true;
        } else {
          item.classList.add('d-none');
        }
      });

      if (criterioPreco !== 'padrao') {
        itens.sort((a, b) => {
          const precoA = parseFloat(a.getAttribute('data-preco'));
          const precoB = parseFloat(b.getAttribute('data-preco'));
          return criterioPreco === 'menor' ? precoA - precoB : precoB - precoA;
        });
        itens.forEach(item => grid.appendChild(item));
      }

      msgVazio.classList.toggle('d-none', encontrouQualquer);
    }

    function verificarCarrinhoVazio() {
      let lista = document.getElementById('listaCarrinho');
      if (lista && (lista.children.length === 0 || !lista.querySelector('.list-group-item:not(#mensagemVazio)'))) {
        lista.innerHTML = `
          <li id="mensagemVazio" class="list-group-item text-center py-5 bg-transparent border-0 text-secondary">
            <i class="bi bi-cart-x fs-1 d-block mb-3 opacity-25"></i>Seu carrinho está vazio.
          </li>
        `;
        document.getElementById('containerTotal').style.display = 'none';
        let contador = document.getElementById('globalCartCount');
        if (contador) contador.style.display = 'none';
      }
    }

    // OPERAÇÕES DO SEU SCRIPT ENCAIXADAS AQUI
    function adicionarCarrinho(id, nome, preco) {
      const precoNum = parseFloat(String(preco).replace(',', '.'));
      if (isNaN(precoNum)) return;

      fetch("../../CONTROLLER/CarrinhoController.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `acao=Adicionar&id_produto=${id}&nome=${encodeURIComponent(nome)}&quantidade=1&preco=${precoNum}`
      })
      .then(() => {
        let itemExistente = document.getElementById(`item-${id}`);
        if (itemExistente) {
          atualizarQuantidadeVisivel(id, 'somar', precoNum);
        } else {
          let msgVazio = document.getElementById('mensagemVazio');
          if (msgVazio) msgVazio.remove();

          document.getElementById('containerTotal').style.display = 'block';

          let lista = document.getElementById('listaCarrinho');
          let novoItem = document.createElement('li');
          novoItem.className = "list-group-item d-flex justify-content-between align-items-center p-3";
          novoItem.id = `item-${id}`;
          novoItem.innerHTML = `
            <div style="max-width: 55%;">
              <span class="fw-bold text-white d-block mb-1 text-truncate" style="font-size: 0.95rem;">${nome}</span>
              <span class="fw-bold item-subtotal" style="color: var(--accent-hover);" data-preco="${precoNum}">
                R$ ${precoNum.toLocaleString('pt-br', { minimumFractionDigits: 2 })}
              </span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="cart-controls">
                <button class="btn-qty" onclick="atualizarQuantidade(${id}, 'subtrair', ${precoNum})">
                  <i class="bi bi-minus text-white"></i>
                </button>
                <span class="qty-number" id="qty-${id}">1</span>
                <button class="btn-qty" onclick="atualizarQuantidade(${id}, 'somar', ${precoNum})">
                  <i class="bi bi-plus text-white"></i>
                </button>
              </div>
              <button class="btn-remove-item" onclick="atualizarQuantidade(${id}, 'remover', ${precoNum})">
                <i class="bi bi-trash3-fill"></i>
              </button>
            </div>
          `;
          lista.appendChild(novoItem);
          atualizarTotaisGerais(precoNum, 1);
        }
      });
    }

    function atualizarQuantidade(id, operacao, preco) {
      const precoNum = parseFloat(String(preco).replace(',', '.'));
      let acaoController = "Adicionar"; 
      let qtdVariacao = 1;

      let qtyEl = document.getElementById(`qty-${id}`);
      let qtdAtual = qtyEl ? parseInt(qtyEl.innerText) : 1;

      if (operacao === 'subtrair') {
        if (qtdAtual <= 1) {
          operacao = 'remover'; 
        } else {
          acaoController = "Subtrair"; 
          qtdVariacao = -1;
        }
      }

      if (operacao === 'remover') {
        acaoController = "Remover";
        qtdVariacao = -qtdAtual; 
      }

      fetch("../../CONTROLLER/CarrinhoController.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `acao=${acaoController}&id_produto=${id}&quantidade=1`
      })
      .then(() => {
        if (operacao === 'remover') {
          let item = document.getElementById(`item-${id}`);
          if (item) item.remove();
          atualizarTotaisGerais(precoNum * qtdVariacao, qtdVariacao);
          verificarCarrinhoVazio();
        } else {
          atualizarQuantidadeVisivel(id, operacao, precoNum);
        }
      });
    }

    function atualizarQuantidadeVisivel(id, operacao, preco) {
      const precoNum = parseFloat(String(preco).replace(',', '.'));
      let qtyEl = document.getElementById(`qty-${id}`);
      if (!qtyEl) return;

      let qtdAtual = parseInt(qtyEl.innerText) || 0;
      let novaQtd = operacao === 'somar' ? qtdAtual + 1 : qtdAtual - 1;
      if (novaQtd < 1) novaQtd = 1;
      
      qtyEl.innerText = novaQtd;

      let itemLi = document.getElementById(`item-${id}`);
      if (itemLi) {
        let subtotalEl = itemLi.querySelector('.item-subtotal');
        let novoSubtotal = novaQtd * precoNum;
        subtotalEl.innerText = "R$ " + novoSubtotal.toLocaleString('pt-br', { minimumFractionDigits: 2 });
      }

      let variacaoQtd = operacao === 'somar' ? 1 : -1;
      atualizarTotaisGerais(precoNum * variacaoQtd, variacaoQtd);
    }

    function atualizarTotaisGerais(valorVariacao, qtdVariacao) {
      let contador = document.getElementById('globalCartCount');
      if (contador) {
        let novaQtdTotal = (parseInt(contador.innerText) || 0) + qtdVariacao;
        if (novaQtdTotal <= 0) {
          contador.style.display = 'none';
          contador.innerText = "0";
        } else {
          contador.innerText = novaQtdTotal;
          contador.style.display = 'flex';
        }
      }

      let totalEl = document.getElementById('totalValor');
      let inputTotal = document.getElementById('inputTotal');
      
      if (totalEl && inputTotal) {
        let totalAtual = parseFloat(inputTotal.value) || 0;
        let novoTotal = totalAtual + valorVariacao;
        if (novoTotal < 0) novoTotal = 0;

        inputTotal.value = novoTotal.toFixed(2);
        totalEl.innerText = "R$ " + novoTotal.toLocaleString('pt-br', { minimumFractionDigits: 2 });
      }
    }
  </script>
</body>
</html>
