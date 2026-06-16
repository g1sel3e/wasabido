<?php
// 1. INICIALIZA A SESSÃO ANTES DE QUALQUER COISA
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. BYPASS INTELIGENTE: Se não houver ninguém logado, criamos uma sessão fantasma
// Isso impede que o 'verificacao.php' jogue o visitante para a tela de login
$visitante_anonimo = false;
if (!isset($_SESSION['cod']) && !isset($_SESSION['usuario'])) {
    $_SESSION['cod'] = 999999;          // Um ID fictício que não existe no banco
    $_SESSION['usuario'] = 'Visitante'; // Nome fictício
    $visitante_anonimo = true;          // Marcamos que ele é um visitante
}

// 3. Agora podemos chamar o Controller com segurança. 
// O DAO vai rodar a verificação, ver que a sessão existe e deixar a página carregar!
require_once __DIR__ . "/../CONTROLLER/AvaliacaoController.php"; 

$controller = new AvaliacaoController();
$avaliacoes = $controller->listarAvaliacoesGerais();

// 4. DESTRÓI A SESSÃO FANTASMA IMEDIATAMENTE
// Limpamos a memória para que o visitante não fique logado de verdade no resto do site
if ($visitante_anonimo) {
    unset($_SESSION['cod']);
    unset($_SESSION['usuario']);
    // Se o seu verificacao.php usar outras variáveis (como $_SESSION['perfil']), destrua-as aqui também
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliações | WasabiDO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #0e0e0e;
      color: #ddd;
      font-family: 'Segoe UI', sans-serif;
    }

    /* NAVBAR */
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

    .nav-link {
      color: #eee !important;
      font-weight: 600;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #e60000 !important;
    }

    /* HERO */
    .hero {
      padding: 80px 0 40px;
      text-align: center;
    }

    .hero h1 {
      font-size: 2.8rem;
      font-weight: 800;
      color: #fff;
    }

    .hero span {
      color: #e60000;
    }

    .nota {
      color: #ccc;
      margin-top: 10px;
    }

    .estrelas i {
      color: #e60000;
      font-size: 0.85rem;
      margin-right: 2px;
      text-shadow: 0 0 6px rgba(230, 0, 0, 0.4);
    }

    /* AVALIAÇÃO */
    .avaliacao {
      background: #161616;
      border: 1px solid #222;
      border-radius: 14px;
      padding: 20px;
      display: flex;
      gap: 15px;
      transition: 0.2s;
      height: 100%;
    }

    .avaliacao:hover {
      border-color: #e60000;
    }

    .avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: #e60000;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: bold;
      flex-shrink: 0;
    }

    .nome {
      color: #fff;
      font-weight: 600;
    }

    .cargo {
      font-size: 0.85rem;
      color: #e60000;
    }

    .comentario {
      color: #bbb;
      margin-top: 5px;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="../imagens/ws.png" alt="Logo" />
      </a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="../index.php" class="nav-link active">Voltar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container hero">
    <h1>Avaliações do <span>WasabiDO</span></h1>
    <div class="nota">Experiências reais da nossa comunidade</div>
  </div>

  <div class="container pb-5">
    <div class="row g-4">

      <?php if (!empty($avaliacoes)): ?>
        <?php foreach ($avaliacoes as $review): 
            $nomeExibido = "Membro do Sistema";
            $cargoExibido = "Membro";

            if (!empty($review['nome_cliente'])) {
                $nomeExibido = $review['nome_cliente'];
                $cargoExibido = "Cliente";
            } elseif (!empty($review['nome_entregador'])) {
                $nomeExibido = $review['nome_entregador'];
                $cargoExibido = "Entregador";
            } elseif (!empty($review['nome_admin'])) {
                $nomeExibido = $review['nome_admin'];
                $cargoExibido = "Administrador";
            }

            $primeiraLetra = mb_strtoupper(mb_substr($nomeExibido, 0, 1, 'UTF-8'), 'UTF-8');
            
            $notaReal = isset($review['nota']) ? (int)$review['nota'] : 5;
            if ($notaReal < 1) $notaReal = 1;
            if ($notaReal > 5) $notaReal = 5;
        ?>
          
          <div class="col-md-6">
            <div class="avaliacao">
              <div class="avatar"><?= htmlspecialchars($primeiraLetra) ?></div>
              <div>
                <div class="nome"><?= htmlspecialchars($nomeExibido) ?></div>
                <div class="cargo"><?= $cargoExibido ?></div>
                
                <div class="estrelas">
                  <?php 
                  for ($i = 1; $i <= 5; $i++) {
                      if ($i <= $notaReal) {
                          echo '<i class="bi bi-star-fill"></i>';
                      } else {
                          echo '<i class="bi bi-star"></i>';
                      }
                  }
                  ?>
                </div>

                <div class="comentario">
                  <?= !empty($review['comentario']) ? nl2br(htmlspecialchars($review['comentario'])) : '<i>Avaliação enviada sem comentários em texto.</i>' ?>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center py-5">
          <p class="text-muted">Nenhuma avaliação encontrada no banco de dados.</p>
        </div>
      <?php endif; ?>

    </div>
  </div>

</body>
</html>
