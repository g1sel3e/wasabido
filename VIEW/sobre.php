<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre o Sistema | WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --bg-dark: #070708;
      --card-bg: #111114;
      --card-border: #1f1f23;
      --accent-red: #e60000;
      --accent-glow: rgba(230, 0, 0, 0.15);
      --text-main: #eeeeee;
      --text-muted: #9999a1;
    }

    body {
      background: var(--bg-dark);
      color: var(--text-main);
      font-family: 'Inter', sans-serif;
      overflow-x: hidden;
    }

    /* NAVBAR (INALTERADA CONFORME DIRETRIZES) */
    .navbar {
      background-color: #000;
      border-bottom: 3px solid #e60000;
      padding: 0.8rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 3px 5px rgba(0, 0, 0, 0.7);
    }

    .navbar-brand {
      font-weight: 900;
      font-size: 1.8rem;
      letter-spacing: 3px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #fff;
    }

    .navbar-brand img {
      height: 50px;
    }

    .nav-link {
      color: #eee !important;
      font-weight: 600;
      letter-spacing: 1px;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #e60000 !important;
    }

    /* HERO */
    .hero {
      padding: 100px 0 80px 0;
      position: relative;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 900;
      color: #fff;
      letter-spacing: -1px;
    }

    .hero span {
      color: var(--accent-red);
      background: linear-gradient(45deg, #ff3333, #e60000);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero p {
      color: var(--text-muted);
      margin-top: 20px;
      font-size: 1.1rem;
      line-height: 1.7;
      max-width: 540px;
    }

    /* Efeito de flutuação e brilho na CPU */
    .hero-icon-wrapper {
      position: relative;
      display: inline-block;
      animation: float 4s ease-in-out infinite;
    }

    .hero-icon-wrapper::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 140px;
      height: 140px;
      background: var(--accent-red);
      filter: blur(80px);
      opacity: 0.4;
      z-index: -1;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }

    /* BLOCOS REESTILIZADOS */
    .bloco {
      padding: 80px 0;
      border-top: 1px solid var(--card-border);
    }

    .bloco h2 {
      font-size: 2rem;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
      margin-bottom: 25px;
      position: relative;
    }

    .bloco p {
      color: var(--text-muted);
      font-size: 1.05rem;
      line-height: 1.7;
    }

    /* LISTAS MODERNAS COM MARCADORES EM DESTAQUE */
    .lista {
      list-style: none;
      padding: 0;
    }

    .lista li {
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 14px;
      color: #e2e2e7;
      font-size: 1.05rem;
      font-weight: 500;
    }

    .lista i {
      color: var(--accent-red);
      background: rgba(230, 0, 0, 0.1);
      border: 1px solid rgba(230, 0, 0, 0.2);
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      font-size: 1.1rem;
    }

    /* CARDS DE USUÁRIOS PREMIUM */
    .user-card {
      background: linear-gradient(145deg, #121216, #16161c);
      border-radius: 16px;
      padding: 26px 22px;
      display: flex;
      align-items: center;
      gap: 18px;
      border: 1px solid var(--card-border);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .user-card:hover {
      border-color: rgba(230, 0, 0, 0.4);
      transform: translateY(-4px);
      box-shadow: 0 12px 30px var(--accent-glow);
    }

    .user-card i {
      font-size: 2rem;
      color: var(--accent-red);
      background: rgba(230, 0, 0, 0.08);
      padding: 12px;
      border-radius: 12px;
      border: 1px solid rgba(230, 0, 0, 0.15);
    }

    .user-card h5 {
      margin: 0 0 4px 0;
      font-weight: 700;
      font-size: 1.15rem;
      color: #fff;
    }

    .user-card small {
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    /* OBJETIVO COM DESIGN DE DESTAQUE (QUOTE-STYLE) */
    .objetivo-texto {
      font-size: 1.2rem;
      color: #e2e2e7;
      line-height: 1.8;
      border-left: 4px solid var(--accent-red);
      padding-left: 24px;
      font-weight: 400;
    }

    .objetivo-texto span {
      color: #fff;
      font-weight: 700;
      background: linear-gradient(0deg, var(--accent-red) 2px, transparent 2px);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="../imagens/ws.png" alt="WasabiDO Logo" />
      </a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="../index.php" class="nav-link active"><i class="bi bi-arrow-left small me-1"></i> Voltar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container hero">
    <div class="row align-items-center g-5">
      <div class="col-md-7">
        <h1>Sistema <span>WasabiDO</span></h1>
        <p>
          Um ecossistema inteligente projetado sob medida para simplificar a operação de restaurantes japoneses.
          Unificamos os processos para gerar agilidade na cozinha e precisão no atendimento.
        </p>
      </div>
      <div class="col-md-5 text-center">
        <div class="hero-icon-wrapper">
          <i class="bi bi-cpu" style="font-size: 130px; color: var(--accent-red); text-shadow: 0 0 20px var(--accent-glow);"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="container bloco">
    <div class="row align-items-center g-5">
      <div class="col-md-6">
        <h2>Sobre o sistema</h2>
        <p>
          O WasabiDO mitiga os gargalos operacionais ao centralizar o fluxo de pedidos, 
          otimizar a linha de produção da cozinha e refinar a logística interna. 
          A premissa é definitiva: eliminar redundâncias e potencializar a performance diária da sua equipe.
        </p>
      </div>
      <div class="col-md-6 ps-md-5">
        <ul class="lista">
          <li><i class="bi bi-check2"></i> Monitoramento de pedidos em tempo real</li>
          <li><i class="bi bi-check2"></i> Sincronia de fluxos na cozinha</li>
          <li><i class="bi bi-check2"></i> Interface responsiva e de alta performance</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container bloco">
    <h2 class="mb-5">Níveis de Acesso</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="user-card">
          <i class="bi bi-gear-fill"></i>
          <div>
            <h5>Administrador</h5>
            <small>Painel analítico e gestão global</small>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="user-card">
          <i class="bi bi-person-fill"></i>
          <div>
            <h5>Cliente</h5>
            <small>Cardápio interativo e checkout ágil</small>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="user-card">
          <i class="bi bi-bicycle"></i>
          <div>
            <h5>Entregador</h5>
            <small>Roteirização e status de entrega</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container bloco">
    <div class="row align-items-center g-4">
      <div class="col-md-4">
        <h2>Vantagens</h2>
      </div>
      <div class="col-md-8">
        <ul class="lista">
          <li><i class="bi bi-speedometer2"></i> Atendimento com tempo de resposta reduzido</li>
          <li><i class="bi bi-exclamation-triangle"></i> Minimização drástica de erros operacionais</li>
          <li><i class="bi bi-phone"></i> Curva de aprendizado intuitiva para novos usuários</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container bloco mb-5">
    <div class="row align-items-center g-4">
      <div class="col-md-4">
        <h2>Diretriz Central</h2>
      </div>
      <div class="col-md-8">
        <p class="objetivo-texto">
          Consolidar a estrutura organizacional de estabelecimentos gastronômicos, tornando o fluxo operacional 
          perfeitamente <span>simples</span>, veloz e escalável sob qualquer demanda.
        </p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
