<?php
require_once "../../verificacao.php";
require_once "../../DAO/AvaliacaoDAO.php"; 

$avaliacaoDAO = new AvaliacaoDAO(); 
$avaliacoes = $avaliacaoDAO->listarAvaliacoesEntregador($_SESSION['cod']); 

$totalAvaliacoes = count($avaliacoes);
$somaNotas = 0;
foreach ($avaliacoes as $av) {
    $somaNotas += $av['nota']; 
}
$mediaNota = $totalAvaliacoes > 0 ? number_format($somaNotas / $totalAvaliacoes, 1, ',', '.') : '0,0';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Avaliações | WasabiDO</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --bg-dark: #0b0b0c;
            --card-bg: rgba(18, 18, 20, 0.7);
            --card-border: rgba(255, 255, 255, 0.08); 
            --text-light: #ffffff;  
            --text-muted: #a1a1aa;
            --accent-red: #ff2a2a;  
            --accent-gold: #ffb800; 
            --glass-panel: rgba(255, 255, 255, 0.02);
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-light);
            background: radial-gradient(circle at top right, rgba(255, 42, 42, 0.06), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(255, 184, 0, 0.02), transparent 40%),
                        var(--bg-dark);
            min-height: 100vh;
        }

        /* NAVBAR PADRONIZADA (Inalterada) */
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

        .voltar-link {
            color: var(--text-muted) !important;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .voltar-link:hover {
            color: var(--accent-hover) !important;
        }

        /* HEADER SECTION */
        .page-title {
            font-weight: 800;
            letter-spacing: -1.5px;
            font-size: 2.5rem;
            background: linear-gradient(180deg, #ffffff 30%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* RESUMO GERAL */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3.5rem;
        }

        .metric-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        }

        .metric-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .metric-icon-bg {
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-size: 5.5rem;
            opacity: 0.03;
            color: var(--text-light);
            pointer-events: none;
        }

        .nota-gigante {
            font-size: 4.5rem !important;
            font-weight: 800;
            color: var(--text-light);
            line-height: 1;
            letter-spacing: -2px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .stars-indicator i {
            color: var(--accent-gold);
            font-size: 1.2rem;
            margin: 0 2px;
            filter: drop-shadow(0 0 5px rgba(255, 184, 0, 0.3));
        }

        /* CARDS DE AVALIAÇÃO INDIVIDUAIS */
        .review-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transition: all 0.3s ease;
        }

        .review-card:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(24, 24, 27, 0.8);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
        }

        .estrelas-foco i {
            font-size: 1.05rem;
            margin-right: 3px;
        }
        .estrelas-foco .bi-star-fill { 
            color: var(--accent-gold); 
            filter: drop-shadow(0 0 4px rgba(255, 184, 0, 0.2));
        }
        .estrelas-foco .bi-star { color: rgba(255, 255, 255, 0.12); }

        .badge-pedido {
            background: rgba(255, 255, 255, 0.04) !important;
            color: var(--text-light) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            border-radius: 12px !important;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .comentario-texto {
            color: #f4f4f5 !important;
            font-size: 0.95rem;
            line-height: 1.6;
            background: rgba(0, 0, 0, 0.3);
            padding: 1.2rem;
            border-radius: 14px;
            border-left: 3px solid var(--accent-red);
            margin-top: 1.2rem;
            position: relative;
        }

        .text-date {
            color: var(--text-muted);
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.02);
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.03);
        }

        /* EMPTY STATE ALERT */
        .alert-custom {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-muted);
            border-radius: 24px;
            padding: 5rem 2rem;
            backdrop-filter: blur(20px);
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
            <a href="entregador.php" class="nav-link voltar-link ms-2">
              <i class="bi bi-box-arrow-left text-danger me-1"></i> Voltar
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>


    <div class="container my-5" style="max-width: 900px;">
        
        <div class="text-center mb-5 animate__animated animate__fadeInDown">
            <h1 class="page-title mb-2">Suas Avaliações</h1>
            <p class="text-secondary fs-6">Acompanhe seu desempenho em tempo real e o feedback dos clientes</p>
        </div>

        <div class="metrics-grid animate__animated animate__fadeIn">
            <div class="metric-card text-center d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-star metric-icon-bg"></i>
                <span class="text-uppercase text-secondary small fw-bold mb-3" style="letter-spacing: 1.5px; font-size: 0.75rem;">Média Geral</span>
                <span class="nota-gigante mb-3"><?php echo $mediaNota; ?></span>
                <div class="stars-indicator">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
            
            <div class="metric-card text-center d-flex flex-column justify-content-center align-items-center">
                <i class="bi bi-chat-square-heart metric-icon-bg"></i>
                <span class="text-uppercase text-secondary small fw-bold mb-3" style="letter-spacing: 1.5px; font-size: 0.75rem;">Total de Feedbacks</span>
                <span class="text-white fw-bold display-4 mb-2" style="font-weight: 800;"><?php echo $totalAvaliacoes; ?></span>
                <span class="text-secondary small mt-1">Avaliações computadas</span>
            </div>
        </div>

        <?php if ($totalAvaliacoes > 0): ?>
            <div class="animate__animated animate__fadeInUp">
                <?php foreach ($avaliacoes as $av): ?>
                    <div class="review-card">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="estrelas-foco">
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $av['nota']) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }
                                    }
                                    ?>
                                </div>
                                <span class="badge badge-pedido">
                                    #<?php echo substr($av['num_pedido'] ?? $av['cod_pedido'] ?? '00000000', 0, 8); ?>
                                </span>
                            </div>
                            <div class="text-date d-flex align-items-center gap-2">
                                <i class="bi bi-calendar3 opacity-70"></i>
                                <span><?php echo date('d/m/Y', strtotime($av['data_avaliacao'] ?? $av['data'] ?? date('Y-m-d'))); ?></span>
                            </div>
                        </div>

                        <div class="text-secondary small fw-medium d-flex align-items-center gap-2 px-1">
                            <i class="bi bi-person fs-5 opacity-70" style="color: var(--accent-red)"></i>
                            <span>Avaliador: <strong class="text-white fw-semibold"><?php echo !empty($av['nome_cliente']) ? htmlspecialchars($av['nome_cliente']) : 'Anônimo'; ?></strong></span>
                        </div>

                        <?php if (!empty($av['comentario'])): ?>
                            <div class="comentario-texto fw-medium">
                                "<?php echo htmlspecialchars($av['comentario']); ?>"
                            </div>
                        <?php else: ?>
                            <div class="text-secondary small mt-3 px-1" style="font-style: italic; opacity: 0.5;">
                                <i class="bi bi-chat-left-dots me-2"></i>O avaliador atribuiu apenas a nota por estrelas.
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-custom text-center animate__animated animate__zoomIn">
                <div class="d-inline-flex p-3 rounded-circle bg-dark mb-3 border" style="border-color: var(--card-border) !important;">
                    <i class="bi bi-chat-square-text text-secondary fs-3"></i>
                </div>
                <h5 class="text-white fw-bold mb-2">Nenhum feedback por enquanto</h5>
                <p class="text-secondary m-0 max-width-auto small">Suas avaliações pós-entrega aparecerão listadas de forma detalhada aqui.</p>
            </div>
        <?php endif; ?>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>