<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliações | WasabiDO</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #0e0e0e;
      color: #ddd;
      font-family: 'Segoe UI', sans-serif;
    }

    /* NAVBAR (INALTERADA) */
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
      /* menor */
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

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="../imagens/ws.png" />
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

  <!-- HERO -->
  <div class="container hero">
    <h1>Avaliações do <span>WasabiDO</span></h1>
    <div class="nota">Experiências reais dos clientes</div>
  </div>

  <!-- AVALIAÇÕES -->
  <div class="container pb-5">
    <div class="row g-4">

      <!-- 1 -->
      <div class="col-md-6">
        <div class="avaliacao">
          <div class="avatar">J</div>
          <div>
            <div class="nome">João Silva</div>
            <div class="cargo">Cliente</div>
            <div class="estrelas">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="comentario">
              O sushi chegou muito rápido e estava delicioso, tudo bem fresco.
            </div>
          </div>
        </div>
      </div>

      <!-- 2 -->
      <div class="col-md-6">
        <div class="avaliacao">
          <div class="avatar">M</div>
          <div>
            <div class="nome">Maria Souza</div>
            <div class="cargo">Cliente</div>
            <div class="estrelas">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-half"></i>
            </div>
            <div class="comentario">
              Gostei muito do atendimento e a comida veio bem organizada.
            </div>
          </div>
        </div>
      </div>

      <!-- 3 -->
      <div class="col-md-6">
        <div class="avaliacao">
          <div class="avatar">C</div>
          <div>
            <div class="nome">Carlos Lima</div>
            <div class="cargo">Cliente</div>
            <div class="estrelas">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="comentario">
              As entregas são rápidas e os pedidos chegam certinhos.
            </div>
          </div>
        </div>
      </div>

      <!-- 4 -->
      <div class="col-md-6">
        <div class="avaliacao">
          <div class="avatar">A</div>
          <div>
            <div class="nome">Ana Costa</div>
            <div class="cargo">Cliente</div>
            <div class="estrelas">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star"></i>
            </div>
            <div class="comentario">
              Comida muito boa e bem feita, gostei bastante.
            </div>
          </div>
        </div>
      </div>

      <!-- 5 -->
      <div class="col-md-6">
        <div class="avaliacao">
          <div class="avatar">P</div>
          <div>
            <div class="nome">Pedro Oliveira</div>
            <div class="cargo">Cliente</div>
            <div class="estrelas">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i>
            </div>
            <div class="comentario">
              Qualidade excelente, tudo muito saboroso.
            </div>
          </div>
        </div>
      </div>

      <!-- 6 -->
      <div class="col-md-6">
        <div class="avaliacao">
          <div class="avatar">L</div>
          <div>
            <div class="nome">Lucas Ferreira</div>
            <div class="cargo">Cliente</div>
            <div class="estrelas">
              <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              <i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
              <i class="bi bi-star"></i>
            </div>
            <div class="comentario">
              Entrega foi tranquila e a comida veio quente.
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>

</html>