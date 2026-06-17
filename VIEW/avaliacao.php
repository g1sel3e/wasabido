<?php
// 1. INICIALIZA A SESSÃO ANTES DE QUALQUER COISA
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. BYPASS INTELIGENTE: Se não houver ninguém logado, criamos uma sessão fantasma
$visitante_anonimo = false;
if (!isset($_SESSION['cod']) && !isset($_SESSION['usuario'])) {
    $_SESSION['cod'] = 999999;          
    $_SESSION['usuario'] = 'Visitante'; 
    $visitante_anonimo = true;          
}

// 3. Chamando o Controller
require_once __DIR__ . "/../CONTROLLER/AvaliacaoController.php"; 

$controller = new AvaliacaoController();
$avaliacoes_originais = $controller->listarAvaliacoesGerais();
$avaliacoes = [];

// --- SISTEMA DE FILTRO E ORDENAÇÃO (PHP) ---
$filtro_perfil = isset($_GET['perfil']) ? $_GET['perfil'] : 'todos';
$filtro_ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'recentes';

if (!empty($avaliacoes_originais)) {
    foreach ($avaliacoes_originais as $review) {
        // Identifica o cargo da mesma forma que você faz no HTML
        $cargo = "Membro";
        if (!empty($review['nome_cliente'])) $cargo = "Cliente";
        elseif (!empty($review['nome_entregador'])) $cargo = "Entregador";
        elseif (!empty($review['nome_admin'])) $cargo = "Administrador";

        // Aplica o filtro por perfil
        if ($filtro_perfil === 'todos' || strtolower($cargo) === strtolower($filtro_perfil)) {
            $avaliacoes[] = $review;
        }
    }

    // Aplica a ordenação por Nota (Melhores / Piores)
    if ($filtro_ordem === 'melhores') {
        usort($avaliacoes, function($a, $b) {
            return ($b['nota'] ?? 5) <=> ($a['nota'] ?? 5);
        });
    } elseif ($filtro_ordem === 'piores') {
        usort($avaliacoes, function($a, $b) {
            return ($a['nota'] ?? 5) <=> ($b['nota'] ?? 5);
        });
    }
}
// --------------------------------------------

// 4. DESTRÓI A SESSÃO FANTASMA IMEDIATAMENTE
if ($visitante_anonimo) {
    unset($_SESSION['cod']);
    unset($_SESSION['usuario']);
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
      padding: 60px 0 20px;
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

    /* FILTROS */
    .filtro-container {
      background: #111;
      border: 1px solid #222;
      border-radius: 10px;
    }
    .form-select {
      background-color: #1a1a1a;
      border: 1px solid #333;
      color: #fff;
    }
    .form-select:focus {
      background-color: #222;
      color: #fff;
      border-color: #e60000;
      box-shadow: 0 0 0 0.25rem rgba(230, 0, 0, 0.25);
    }
    .btn-filtro {
      background-color: #e60000;
      color: white;
      border: none;
    }
    .btn-filtro:hover {
      background-color: #b30000;
      color: white;
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

  <div class="container mb-4">
    <form method="GET" action="" class="filtro-container p-3">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label small text-muted">Filtrar por Usuário</label>
          <select name="perfil" class="form-select">
            <option value="todos" <?= $filtro_perfil == 'todos' ? 'selected' : '' ?>>Todos os Perfis</option>
            <option value="cliente" <?= $filtro_perfil == 'cliente' ? 'selected' : '' ?>>Clientes</option>
            <option value="administrador" <?= $filtro_perfil == 'administrador' ? 'selected' : '' ?>>Administradores</option>
            <option value="entregador" <?= $filtro_perfil == 'entregador' ? 'selected' : '' ?>>Entregadores</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label small text-muted">Ordenar por Nota</label>
          <select name="ordem" class="form-select">
            <option value="recentes" <?= $filtro_ordem == 'recentes' ? 'selected' : '' ?>>Padrão / Recentes</option>
            <option value="melhores" <?= $filtro_ordem == 'melhores' ? 'selected' : '' ?>>Melhores Avaliações (5★ a 1★)</option>
            <option value="piores" <?= $filtro_ordem == 'piores' ? 'selected' : '' ?>>Piores Avaliações (1★ a 5★)</option>
          </select>
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-filtro w-100 fw-bold">Aplicar Filtros</button>
        </div>
      </div>
    </form>
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
          <p class="text-muted">Nenhuma avaliação corresponde aos filtros selecionados.</p>
        </div>
      <?php endif; ?>

    </div>
  </div>

</body>
</html>
