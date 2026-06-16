<?php
require "../DAO/ProdutoDAO.php";

$dao = new ProdutoDAO();
$produtos = $dao->listar();
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
      --accent-hover: #ff3333; /* Vermelho mais vivo e moderno */
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
      color: var(--accent-red) !important;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
    }
    .voltar-link:hover { color: var(--accent-hover) !important; }

    /* TÍTULO INICIAL ORIGINAL */
    .titulo {
      text-align: center;
      padding: 3rem 1rem 2rem;
    }
    .titulo h1 { font-size: 2.8rem; font-weight: 800; }
    .titulo span { color: var(--accent-red); }
    .titulo p { color: #bbb; font-size: 1rem; }

    /* CARDS DA FRENTE */
    .card-produto {
      background: var(--card-bg);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 24px;
      overflow: hidden;
      transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
      cursor: pointer;
      border: 1px solid var(--card-border);
      height: 100%;
      position: relative;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
    }

    .card-img-wrapper { position: relative; overflow: hidden; border-radius: 24px 24px 0 0; }
    .card-produto img { height: 250px; width: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1); }
    .card-produto:hover { transform: translateY(-8px); border-color: rgba(230, 0, 0, 0.4); box-shadow: 0 20px 40px rgba(230, 0, 0, 0.15); }
    .card-produto:hover img { transform: scale(1.06); }

    .badge-preco {
      position: absolute; top: 16px; right: 16px;
      background: rgba(230, 0, 0, 0.9); backdrop-filter: blur(8px);
      color: #fff; padding: 8px 16px; border-radius: 30px;
      font-weight: 700; font-size: 0.95rem; z-index: 2;
    }

    .view-details-overlay {
      position: absolute; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.4); display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.3s ease; font-size: 1.8rem; color: #fff; z-index: 1;
    }
    .card-produto:hover .view-details-overlay { opacity: 1; }

    .card-body { text-align: left; padding: 1.5rem; }
    .card-body h5 { font-size: 1.3rem; font-weight: 700; color: #fff; margin-bottom: 8px; letter-spacing: -0.02em; }
    .ver-mais-text { font-size: 0.85rem; color: var(--accent-hover); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }

    /* =========================================
       MODAL AJUSTADO - DESIGN CORRIGIDO
       ========================================= */
    .modal-content {
      background: #0a0a0a; /* Preto absoluto e profundo */
      color: var(--text-light);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 24px;
      overflow: hidden;
    }

    /* Estilização moderna do cabeçalho */
    .modal-header { 
      border-bottom: 1px solid rgba(255, 255, 255, 0.04); 
      padding: 1.5rem 2rem; 
      background: #000;
    }
    
    /* Título do Modal com degradê moderno (Sem branco chapado) */
    .modal-header .modal-title { 
      font-size: 1.5rem;
      font-weight: 800; 
      letter-spacing: -0.02em;
      background: linear-gradient(180deg, #ffffff 0%, #d4d4d8 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .carousel-container-custom {
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.05);
      background: #000;
      position: relative;
    }

    .carousel-item img {
      height: 400px;
      width: 100%;
      object-fit: cover;
    }

    /* Setas laterais integradas */
    .carousel-control-prev,
    .carousel-control-next {
      width: 45px;
      height: 45px;
      background: rgba(0, 0, 0, 0.6);
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
      margin: 0 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      transition: all 0.2s ease;
      opacity: 0;
    }

    .carousel-container-custom:hover .carousel-control-prev,
    .carousel-container-custom:hover .carousel-control-next {
      opacity: 1;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
      background: var(--accent-red);
      border-color: var(--accent-red);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      width: 18px;
      height: 18px;
    }

    /* Tracinhos restaurados sob a imagem */
    .carousel-indicators [data-bs-target] {
      width: 28px;
      height: 4px;
      background-color: rgba(255, 255, 255, 0.3);
      border: none;
      border-radius: 2px;
      transition: all 0.3s ease;
      margin: 0 4px;
    }

    .carousel-indicators .active {
      background-color: var(--accent-red);
      width: 40px;
    }

    /* Descrição do Produto */
    .modal-descricao { 
      color: #a1a1aa; 
      font-size: 1.05rem; 
      line-height: 1.7; 
      margin: 1.8rem 0 1rem; 
    }

    /* Valor reestilizado em Vermelho Neon */
    .modal-preco { 
      font-size: 2.2rem; 
      font-weight: 800; 
      color: var(--accent-hover); 
      margin: 0;
      letter-spacing: -0.03em;
      display: inline-block;
      text-shadow: 0 0 20px rgba(255, 51, 51, 0.2); 
    }

    /* ESTILO DO NOVO BOTÃO DE LOGIN/CADASTRO */
    .btn-modal-action {
      background-color: var(--accent-red);
      color: #fff;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      padding: 12px 30px;
      transition: all 0.2s ease-in-out;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-modal-action:hover {
      background-color: var(--accent-hover);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 51, 51, 0.4);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container"> 
      <a href="../index.php" class="navbar-brand"> 
        <img src="../imagens/ws.png" alt="Logo WasabiDO" /> 
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

  <div class="titulo">
    <h1>Cardápio da <span>WasabiDO</span></h1>
    <p>Produtos cadastrados</p>
  </div>

  <main class="container pb-5">
    <div class="row g-4">

      <?php foreach ($produtos as $p) { ?>

        <div class="col-md-6 col-lg-4">
          <div class="card card-produto" data-bs-toggle="modal" data-bs-target="#modal<?= $p['cod'] ?>">
            
            <div class="card-img-wrapper">
              <span class="badge-preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span>
              
              <div class="view-details-overlay">
                <i class="bi bi-eye"></i>
              </div>

              <?php if ($p['foto1'] != "") { ?>
                <img src="produtos/<?= $p['foto1'] ?>" alt="<?= $p['nome'] ?>">
              <?php } else { ?>
                <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" alt="Sem imagem">
              <?php } ?>
            </div>

            <div class="card-body">
              <h5><?= $p['nome'] ?></h5>
              <div class="card-body-footer">
                <span class="ver-mais-text">Ver detalhes <i class="bi bi-arrow-right ms-1"></i></span>
              </div>
            </div>

          </div>
        </div>

        <div class="modal fade" id="modal<?= $p['cod'] ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title"><?= $p['nome'] ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>

              <div class="modal-body">

                <div class="carousel-container-custom">
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
                            <img src="produtos/<?= $p[$foto] ?>" class="d-block w-100" alt="Foto de <?= $p['nome'] ?>">
                          </div>
                          <?php $active = false; ?>
                        <?php }
                      } ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $p['cod'] ?>" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $p['cod'] ?>" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>

                  </div>
                </div>

                <p class="modal-descricao"><?= $p['descricao'] ?></p>

                <div class="d-flex justify-content-between align-items-center mt-4">
                  <h4 class="modal-preco">
                    R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                  </h4>
                  
                  <a href="login.php" class="btn-modal-action">
                    <i class="bi bi-box-arrow-in-right"></i> Fazer Pedido / Entrar
                  </a>
                </div>

              </div>

            </div>
          </div>
        </div>

      <?php } ?>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>