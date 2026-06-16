<?php
// Inclui a sua verificação padrão do sistema
require_once __DIR__ . "/../../verificacao.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$cod_entregador_logado = $_SESSION['cod'] ?? null;

// --- BUSCA DE DADOS REAIS DO BANCO ---
require_once __DIR__ . "/../../DAO/ClienteDAO.php";

$clienteDAO = new ClienteDAO();
$todosOsClientes = $clienteDAO->listarClientes(); // Método genérico para trazer os clientes
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliar Entrega | WasabiDO</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <style>
    :root {
      --bg-main: #0d0d10;
      --bg-card: #141417;
      --bg-input: #1b1b1f;
      --border-color: #26262b;
      --text-light: #f4f4f4;
      --text-muted: #8a8a93;
      --wasabi-red: #e60000;
      --accent-red: #e60000;
      --accent-hover: #ff3333;
    }

    body {
      background-color: var(--bg-main);
      font-family: 'Inter', sans-serif;
      color: #f1f1f4;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* NAVBAR PADRONIZADA */
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

    /* Card Clean e Minimalista */
    .card-avaliacao {
      background-color: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 35px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
    }

    .form-label {
      font-weight: 500;
      color: #e2e2e5;
      font-size: 0.95rem;
    }

    /* Inputs focando no Vermelho Wasabi */
    .form-select,
    .form-control {
      background-color: var(--bg-input);
      border: 1px solid var(--border-color);
      color: #ffffff;
      border-radius: 8px;
      padding: 0.65rem 1rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-select:focus,
    .form-control:focus {
      background-color: var(--bg-input);
      border-color: var(--wasabi-red);
      color: #ffffff;
      box-shadow: 0 0 0 4px rgba(230, 0, 0, 0.15);
    }

    .form-select option {
      background-color: #141417;
      color: #ffffff;
    }

    /* Pílulas de Seleção (Checkboxes) */
    .btn-check + .btn-outline-custom {
      background-color: var(--bg-input);
      border: 1px solid var(--border-color);
      color: var(--text-muted);
      border-radius: 6px;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      transition: all 0.2s;
    }

    .btn-check + .btn-outline-custom:hover {
      border-color: rgba(230, 0, 0, 0.4);
      color: var(--text-light);
    }

    .btn-check:checked + .btn-outline-custom {
      background-color: var(--wasabi-red);
      border-color: var(--wasabi-red);
      color: #ffffff;
      font-weight: 500;
    }

    /* Estrelas com Vermelho Perfeito */
    .rating-container {
      background: var(--bg-input);
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 12px;
      display: flex;
      justify-content: center;
    }

    .rating-stars {
      display: flex;
      flex-direction: row-reverse;
      justify-content: center;
      gap: 10px;
    }

    .rating-stars input {
      display: none;
    }

    .rating-stars label {
      font-size: 2.3rem;
      color: #2b2b33;
      cursor: pointer;
      transition: color 0.15s ease, transform 0.1s ease;
    }

    .rating-stars label:hover {
      transform: scale(1.1);
    }

    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
      color: var(--wasabi-red);
    }

    /* Botão Sólido Vermelho Wasabi */
    .btn-enviar {
      background-color: var(--wasabi-red);
      color: #ffffff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      padding: 0.8rem;
      transition: background-color 0.2s, transform 0.2s;
    }

    .btn-enviar:hover {
      background-color: #bd0000;
      color: #ffffff;
      transform: translateY(-1px);
    }

    .secao-dinamica {
      display: none;
    }

    /* FOOTER */
    footer {
      background: #000000;
      border-top: 1px solid var(--border-color);
      padding: 20px 0;
      margin-top: auto;
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

  <main class="container my-5 animate__animated animate__fadeIn">
    <div class="row justify-content-center">
      <div class="col-md-9 col-lg-7 col-xl-6">

        <div class="card-avaliacao">
          <div class="text-center mb-4">
            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: rgba(230, 0, 0, 0.08); color: var(--wasabi-red);">
              <i class="bi bi-star-half fs-3"></i>
            </div>
            <h2 class="fw-bold mb-1">Avaliação da Corrida</h2>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Deixe seu feedback sobre o cliente ou o estabelecimento.</p>
          </div>

          <form action="../../CONTROLLER/AvaliacaoController.php?action=salvar" method="POST">

            <input type="hidden" name="cod_entregador" value="<?php echo htmlspecialchars($cod_entregador_logado); ?>">

            <div class="mb-4">
              <label for="tipo_avaliacao" class="form-label">Quem você deseja avaliar?</label>
              <select name="tipo_avaliacao" id="tipo_avaliacao" class="form-select" required onchange="mostrarCamposDinamicamente()">
                <option value="" disabled selected>Selecione uma opção...</option>
                <option value="cliente">O Cliente (Postura, Espera, Recepção)</option>
                <option value="estabelecimento">O Estabelecimento / Cozinha (Preparo, Embalagem)</option>
              </select>
            </div>

            <div id="wrapper-cliente" class="secao-dinamica mb-4 animate__animated animate__fadeIn animate__fast">
              <div class="mb-3">
                <label for="cod_cliente" class="form-label">Selecione o Cliente:</label>
                <select name="cod_cliente" id="cod_cliente" class="form-select">
                  <option value="" disabled selected>Escolha o cliente...</option>
                  <?php if (!empty($todosOsClientes)): ?>
                    <?php foreach ($todosOsClientes as $cli): ?>
                      <option value="<?php echo $cli['cod']; ?>">
                        <?php echo htmlspecialchars($cli['nome']); ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </div>

              <div class="mb-2">
                <label class="form-label text-muted"><i class="bi bi-tags me-1"></i> Houve algum problema? (Opcional)</label>
                <div class="d-flex flex-wrap gap-2">
                  <input type="checkbox" class="btn-check" id="tag_c1" name="tags_cliente[]" value="Demorou para atender">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_c1">Demorou a atender</label>

                  <input type="checkbox" class="btn-check" id="tag_c2" name="tags_cliente[]" value="Sem ponto de referência">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_c2">Sem ponto de referência</label>

                  <input type="checkbox" class="btn-check" id="tag_c3" name="tags_cliente[]" value="Local de difícil acesso">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_c3">Local de difícil acesso</label>

                  <input type="checkbox" class="btn-check" id="tag_c4" name="tags_cliente[]" value="Cliente mal-educado">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_c4">Falta de educação</label>
                </div>
              </div>
            </div>

            <div id="wrapper-estabelecimento" class="secao-dinamica mb-4 animate__animated animate__fadeIn animate__fast">
              <div class="mb-2">
                <label class="form-label text-muted"><i class="bi bi-tags me-1"></i> Houve algum problema? (Opcional)</label>
                <div class="d-flex flex-wrap gap-2">
                  <input type="checkbox" class="btn-check" id="tag_e1" name="tags_estab[]" value="Pedido atrasou muito">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_e1">Pedido atrasou muito</label>

                  <input type="checkbox" class="btn-check" id="tag_e2" name="tags_estab[]" value="Embalagem inadequada/vazando">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_e2">Embalagem mal protegida</label>

                  <input type="checkbox" class="btn-check" id="tag_e3" name="tags_estab[]" value="Sem local para esperar">
                  <label class="btn btn-outline-custom text-nowrap" for="tag_e3">Sem local para espera</label>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label d-block mb-2">Sua Nota:</label>
              <div class="rating-container">
                <div class="rating-stars">
                  <input type="radio" name="nota" id="star5" value="5" required />
                  <label for="star5" class="bi bi-star-fill"></label>

                  <input type="radio" name="nota" id="star4" value="4" />
                  <label for="star4" class="bi bi-star-fill"></label>

                  <input type="radio" name="nota" id="star3" value="3" />
                  <label for="star3" class="bi bi-star-fill"></label>

                  <input type="radio" name="nota" id="star2" value="2" />
                  <label for="star2" class="bi bi-star-fill"></label>

                  <input type="radio" name="nota" id="star1" value="1" />
                  <label for="star1" class="bi bi-star-fill"></label>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label for="comentario" class="form-label">Mais detalhes (Opcional):</label>
              <textarea name="comentario" id="comentario" class="form-control" rows="4"
                placeholder="Conte-nos brevemente o que houve de bom ou ruim..."></textarea>
            </div>

            <button type="submit" class="btn btn-enviar w-100 btn-lg">
              <i class="bi bi-send me-2"></i>Enviar Feedback
            </button>
          </form>
        </div>

      </div>
    </div>
  </main>

  <footer>
    <div class="container text-center text-muted small">
      &copy; 2026 WasabiDO System. Todos os direitos reservados.
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function mostrarCamposDinamicamente() {
      var tipo = document.getElementById('tipo_avaliacao').value;
      var wrapperCliente = document.getElementById('wrapper-cliente');
      var wrapperEstab = document.getElementById('wrapper-estabelecimento');
      var selectCliente = document.getElementById('cod_cliente');

      wrapperCliente.style.display = 'none';
      wrapperEstab.style.display = 'none';
      selectCliente.required = false;

      if (tipo === 'cliente') {
        wrapperCliente.style.display = 'block';
        selectCliente.required = true;
      } else if (tipo === 'estabelecimento') {
        wrapperEstab.style.display = 'block';
      }
    }
  </script>
</body>
</html>