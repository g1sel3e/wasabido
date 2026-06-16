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



    /* FILTRO REFINADO */

    .filter-container {

      background: rgba(15, 15, 15, 0.8);

      border: 1px solid var(--card-border);

      border-radius: 16px;

      padding: 1rem;

      backdrop-filter: blur(10px);

      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);

    }



    .select-custom {

      background-color: #000 !important;

      color: var(--text-light) !important;

      border: 1px solid var(--card-border) !important;

      border-radius: 10px !important;

      padding: 0.6rem 1rem !important;

      font-weight: 500;

      cursor: pointer;

      transition: border-color 0.2s ease;

    }



    .select-custom:focus {

      border-color: var(--accent-red) !important;

      box-shadow: 0 0 0 0.25rem rgba(230, 0, 0, 0.25) !important;

    }



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



    /* BARRA LATERAL (OFFCANVAS) REESTILIZADA */

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



    /* CONTROLES DE QUANTIDADE INTERNOS DO CARRINHO */

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

    .btn-qty:hover {

      background: rgba(255, 255, 255, 0.15);

    }

    .btn-qty i {

      color: #fff !important;

      font-weight: 800;

    }

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

    .btn-remove-item:hover {

      color: #ff6b6b;

    }



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



    /* NOVA BARRA DE PESQUISA E BOTÃO DE FILTRO */

    .search-wrapper {

      max-width: 600px;

      margin: 0 auto 1.5rem;

      display: flex;

      gap: 10px;

    }



    .search-input-group {

      position: relative;

      flex-grow: 1;

    }



    .search-input-group i {

      position: absolute;

      left: 15px;

      top: 50%;

      transform: translateY(-50%);

      color: #a1a1aa;

      font-size: 1.1rem;

    }



    .input-busca {

      background-color: rgba(20, 20, 20, 0.8) !important;

      border: 1px solid rgba(255, 255, 255, 0.05) !important;

      color: #fff !important;

      padding: 0.75rem 1rem 0.75rem 2.8rem !important;

      border-radius: 14px !important;

      font-weight: 500;

    }



    .input-busca:focus {

      border-color: #e60000 !important;

      box-shadow: 0 0 0 3px rgba(230, 0, 0, 0.15) !important;

    }



    .btn-filtro-trigger {

      background-color: rgba(20, 20, 20, 0.8);

      border: 1px solid rgba(255, 255, 255, 0.05);

      color: #fff;

      border-radius: 14px;

      padding: 0 1.2rem;

      display: flex;

      align-items: center;

      gap: 8px;

      font-weight: 600;

    }



    .btn-filtro-trigger.active, .btn-filtro-trigger:hover {

      border-color: #e60000;

      background-color: rgba(230, 0, 0, 0.05);

      color: #ff3333;

    }



    /* QUADRADOS DE CATEGORIA */

    .categorias-container {

      max-width: 800px;

      margin: 0 auto 2rem;

      display: grid;

      grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));

      gap: 10px;

      padding: 15px;

      background: rgba(15, 15, 15, 0.5);

      border-radius: 20px;

      border: 1px solid rgba(255, 255, 255, 0.05);

    }



    .btn-categoria-box {

      background: rgba(30, 30, 30, 0.4);

      border: 1px solid rgba(255, 255, 255, 0.05);

      border-radius: 12px;

      color: #a1a1aa;

      padding: 12px 8px;

      font-size: 0.85rem;

      font-weight: 600;

      text-align: center;

      cursor: pointer;

      display: flex;

      flex-direction: column;

      align-items: center;

      justify-content: center;

      gap: 6px;

      transition: all 0.2s ease;

    }



    .btn-categoria-box:hover {

      background: rgba(255, 255, 255, 0.03);

      color: #fff;

    }



    .btn-categoria-box.active {

      background: #e60000 !important;

      color: #fff !important;

      border-color: #e60000 !important;

      box-shadow: 0 8px 20px rgba(230, 0, 0, 0.3);

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



  <div class="container mb-4">

    <div class="search-wrapper">

      <div class="search-input-group">

        <i class="bi bi-search"></i>

        <input type="text" id="inputBuscaNome" class="form-control input-busca" placeholder="Buscar pelo nome do produto..." oninput="filtrarCardapio()">

      </div>

      <button class="btn btn-filtro-trigger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="true" id="btnFiltroCategorias">

        <i class="bi bi-funnel-fill"></i> <span>Filtros</span>

      </button>

    </div>



    <div class="collapse show" id="collapseCategorias">

      <div class="categorias-container">

        <div class="btn-categoria-box active" data-value="todos" onclick="selecionarCategoria(this)">

          <span class="fs-4">🍱</span><span>Todos</span>

        </div>

        <div class="btn-categoria-box" data-value="sushi" onclick="selecionarCategoria(this)">

          <span class="fs-4">🍣</span><span>Sushi</span>

        </div>

        <div class="btn-categoria-box" data-value="sashimi" onclick="selecionarCategoria(this)">

          <span class="fs-4">🐟</span><span>Sashimi</span>

        </div>

        <div class="btn-categoria-box" data-value="ramen" onclick="selecionarCategoria(this)">

          <span class="fs-4">🍜</span><span>Ramen</span>

        </div>

        <div class="btn-categoria-box" data-value="temaki" onclick="selecionarCategoria(this)">

          <span class="fs-4">📐</span><span>Temaki</span>

        </div>

        <div class="btn-categoria-box" data-value="bebida" onclick="selecionarCategoria(this)">

          <span class="fs-4">🥤</span><span>Bebidas</span>

        </div>

        <div class="btn-categoria-box" data-value="sobremesa" onclick="selecionarCategoria(this)">

          <span class="fs-4">🍡</span><span>Sobremesas</span>

        </div>

      </div>

    </div>

  </div>



  <main class="container pb-5">

    <div class="row g-4" id="gridProdutos">

      <?php foreach ($produtos as $p): ?>

        <div class="col-md-6 col-lg-4 item-produto" data-categoria="<?= htmlspecialchars($p['categoria'] ?? '') ?>" data-nome="<?= htmlspecialchars(strtolower($p['nome'])) ?>">

          <div class="card-produto">

            

            <div class="card-img-wrapper" data-bs-toggle="modal" data-bs-target="#modal<?= $p['cod'] ?>" style="cursor: pointer;">

              <span class="badge-preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span>

              <div class="view-details-overlay"><i class="bi bi-eye"></i></div>

              <img src="../produtos/<?= $p['foto1'] ?: 'https://via.placeholder.com/300x200?text=Sem+Imagem' ?>" alt="<?= $p['nome'] ?>">

            </div>



            <div class="card-body-custom">

              <div data-bs-toggle="modal" data-bs-target="#modal<?= $p['cod'] ?>" style="cursor: pointer;">

                <span class="nome-produto text-truncate"><?= $p['nome'] ?></span>

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

                <h5 class="modal-title fw-bold" style="color: #fff;"><?= $p['nome'] ?></h5>

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

                <p class="text-secondary mb-4"><?= $p['descricao'] ?: 'Sem descrição disponível.' ?></p>

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

                <span class="fw-bold text-white d-block mb-1 text-truncate" style="font-size: 0.95rem;"><?= $item['nome'] ?></span>

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

    if ($count > 0): ?>

      <span class="cart-count"><?= $count ?></span>

    <?php endif; ?>

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



    // LÓGICA DE FILTRAGEM DINÂMICA

    let categoriaSelecionada = "todos";



    function selecionarCategoria(elemento) {

      document.querySelectorAll('.btn-categoria-box').forEach(box => box.classList.remove('active'));

      elemento.classList.add('active');

      categoriaSelecionada = elemento.getAttribute('data-value');

      filtrarCardapio();

    }



    function filtrarCardapio() {

      const termoBusca = document.getElementById('inputBuscaNome').value.toLowerCase().trim();

      const itens = document.querySelectorAll('.item-produto'); 

      const msgVazio = document.getElementById('msgFiltroVazio');

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



      // Exibe mensagem caso nenhum produto corresponda ao filtro selecionado

      if (encontrouQualquer) {

        msgVazio.classList.add('d-none');

      } else {

        msgVazio.classList.remove('d-none');

      }

    }



    // Controla o visual do botão de filtro ativo

    const collapseCategorias = document.getElementById('collapseCategorias');

    const btnFiltro = document.getElementById('btnFiltroCategorias');

    if(collapseCategorias && btnFiltro) {

      collapseCategorias.addEventListener('shown.bs.collapse', () => btnFiltro.classList.add('active'));

      collapseCategorias.addEventListener('hidden.bs.collapse', () => btnFiltro.classList.remove('active'));

    }



    function verificarCarrinhoVazio() {

      let lista = document.getElementById('listaCarrinho');

      if (lista && lista.children.length === 0) {

        lista.innerHTML = `

          <li id="mensagemVazio" class="list-group-item text-center py-5 bg-transparent border-0 text-secondary">

            <i class="bi bi-cart-x fs-1 d-block mb-3 opacity-25"></i>Seu carrinho está vazio.

          </li>

        `;

        document.getElementById('containerTotal').style.display = 'none';

      }

    }



    function adicionarCarrinho(id, nome, preco) {

      const precoNum = parseFloat(String(preco).replace(',', '.'));



      if (isNaN(precoNum)) {

        console.error("Preço inválido recebido.");

        return;

      }



      fetch("../../CONTROLLER/CarrinhoController.php", {

        method: "POST",

        headers: { "Content-Type": "application/x-www-form-urlencoded" },

        body: `acao=Adicionar&id_produto=${id}&nome=${encodeURIComponent(nome)}&quantidade=1&preco=${precoNum}`

      })

      .then(response => response.text())

      .then(() => {

        let itemExistente = document.getElementById(`item-${id}`);

        

        if (itemExistente) {

          atualizarQuantidadeVisivel(id, 'somar', precoNum);

        } else {

          let msgVazio = document.getElementById('mensagemVazio');

          if (msgVazio) {

            msgVazio.remove();

            document.getElementById('containerTotal').style.display = 'block';

          }



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

      . 

