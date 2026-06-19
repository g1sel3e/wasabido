<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>WasabiDO - Sistema para Restaurantes Japoneses</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    /* RESET */
    body,
    html {
      margin: 0;
      padding: 0;
      background-color: #0a0a0a;
      color: #eee;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      scroll-behavior: smooth;
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

    .navbar-brand {
      font-weight: 900;
      font-size: 1.8rem;
      letter-spacing: 3px;
      display: flex;
      align-items: center;
      gap: 0.2rem;
      color: #fff;
    }

    .navbar-brand img:first-child {
      height: 65px;
    }

    /* HERO */
    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
        url('https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
      height: 75vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 0 1rem;
    }

    .hero-content {
      max-width: 700px;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
    }

    .hero-content h1 {
      font-size: 3.5rem;
      font-weight: 900;
      letter-spacing: 3px;
    }

    .hero-content p {
      font-size: 1.2rem;
      color: #ccc;
      margin: 1rem 0 2rem;
    }

    .btn-hero {
      color: white;
      background-color: #e60000;
      border: none;
      padding: 14px 40px;
      font-weight: 700;
      border-radius: 40px;
      transition: 0.3s;
    }

    .btn-hero:hover {
      background-color: #b30000;
      transform: scale(1.05);
      color: white;
    }

    /* CARDS */
    .section-cards {
      padding: 5rem 1rem;
      background-color: #111;
    }

    .card-custom {
      background-color: #1a1a1a;
      border-radius: 15px;
      border: none;
      overflow: hidden;
      position: relative;
      transition: transform 0.3s ease;
    }

    /* Efeito de subir o card levemente */
    .card-custom:hover {
      transform: translateY(-10px);
    }

    /* Criação da linha vermelha na parte inferior usando pseudo-elemento */
    .card-custom::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px; /* Espessura da linha */
      background-color: #e60000;
      transform: scaleX(0); /* Começa invisível (tamanho zero) */
      transition: transform 0.3s ease;
    }

    /* Revela a linha expandindo-a pelas laterais ao passar o mouse */
    .card-custom:hover::after {
      transform: scaleX(1);
    }

    .card-custom img {
      height: 200px;
      width: 100%;
      object-fit: cover;
    }

    .card-body {
      text-align: center;
      padding: 1.5rem;
    }

    .card-title {
      color: #e60000;
      font-weight: 900;
    }

    .card-text {
      color: #ddd;
    }

    .btn-card {
      color: white;
      background-color: #e60000;
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      margin-top: 10px;
      transition: 0.3s;
    }

    .btn-card:hover {
      background-color: #b30000;
      color: white;
    }

    /* FOOTER */
    footer {
      background-color: #000;
      border-top: 3px solid #e60000;
      padding: 2rem 1rem;
      text-align: center;
      color: #bbb;
      font-size: 0.9rem;
    }

    /* RESPONSIVO AJUSTADO */
    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 2.3rem;
      }

      .hero-content p {
        font-size: 1rem;
      }

      .card-custom img {
        height: 180px;
      }
    }

    /* Ajuste fino para celulares muito pequenos (telas até 400px) */
    @media (max-width: 400px) {
      .hero-content h1 {
        font-size: 1.8rem;
      }
      
      .btn-card {
        font-size: 0.85rem;
        padding: 8px 15px;
      }
    }
  </style>
</head>

<body>

  <header>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">

        <a href="#" class="navbar-brand">
          <img src="imagens/ws.png" alt="Logo WasabiDO" />
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="VIEW/login.php" class="nav-link">
                <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
              </a>
            </li>
          </ul>
        </div>

      </div>
    </nav>
  </header>

  <main>

    <section class="hero">
      <div class="hero-content">
        <h1>Experiência Japonesa Digital</h1>
        <p>Controle pedidos, cardápio e atendimento com estilo e eficiência.</p>

        <a href="VIEW/cardapio.php" class="btn btn-hero">
          <i class="bi bi-bag-check me-2"></i> Fazer Pedido
        </a>
      </div>
    </section>

    <section class="section-cards">
      <div class="container">

        <div class="row g-4 justify-content-center">

          <div class="col-md-4 d-flex">
            <div class="card card-custom w-100">

              <img src="https://images.unsplash.com/photo-1553621042-f6e147245754?auto=format&fit=crop&w=800&q=80" alt="Cardápio">

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">Cardápio</h5>

                <p class="card-text">
                  Veja nossos pratos incríveis da culinária japonesa.
                </p>

                <a href="VIEW/cardapio.php" class="btn btn-card mt-auto">
                  <i class="bi bi-journal-text me-1"></i> Ver Cardápio
                </a>
              </div>

            </div>
          </div>

          <div class="col-md-4 d-flex">
            <div class="card card-custom w-100">

              <img src="https://images.unsplash.com/photo-1611143669185-af224c5e3252?auto=format&fit=crop&w=800&q=80" alt="Sobre">

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">Sobre</h5>

                <p class="card-text">
                  Conheça mais sobre nosso sistema e restaurante.
                </p>

                <a href="VIEW/sobre.php" class="btn btn-card mt-auto">
                  <i class="bi bi-info-circle me-1"></i> Saiba mais
                </a>
              </div>

            </div>
          </div>

          <div class="col-md-4 d-flex">
            <div class="card card-custom w-100">

              <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=800&q=80" alt="Avaliações">

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">Avaliações</h5>

                <p class="card-text">
                  Veja o que nossos clientes estão dizendo e compartilhe sua experiência.
                </p>

                <a href="VIEW/avaliacao.php" class="btn btn-card mt-auto">
                  <i class="bi bi-star-fill me-1"></i> Avaliar agora
                </a>
              </div>

            </div>
          </div>

        </div>

      </div>
    </section>

  </main>

  <footer>
    <p>&copy; 2026 WASABIDO - Sistema para restaurantes japoneses</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
