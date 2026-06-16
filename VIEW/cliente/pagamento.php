<?php
session_start();

// Garante que o usuário está logado obtendo o ID (cod) da sessão
if (!isset($_SESSION['cod'])) {
    header("Location: ../login.php");
    exit();
}

$idClienteLogado = $_SESSION['cod'];

// Busca direta dos endereços na raiz do projeto
include __DIR__ . "/../../conexao.php";

$sqlEnderecos = "SELECT cod, cep, rua, bairro, num, cidade, complemento FROM endereco WHERE cod_cliente = :cod_cliente";
$stmtEnderecos = $conexao->prepare($sqlEnderecos);
$stmtEnderecos->bindValue(":cod_cliente", $idClienteLogado, PDO::PARAM_INT);
$stmtEnderecos->execute();
$listaEnderecos = $stmtEnderecos->fetchAll(PDO::FETCH_ASSOC);

// ==========================================
// 🛠️ APAGUE O TRECHO ANTIGO E COLE ESTE AQUI:
// ==========================================
$cod_pedido = $_GET['cod'] ?? $_POST['cod_pedido'] ?? $_SESSION['cod_pedido'] ?? 0;
$total = $_GET['total'] ?? $_SESSION['total'] ?? 0;

// Salva na sessão para que o PagamentoController também consiga ler depois
if ($cod_pedido > 0) {
    $_SESSION['cod_pedido'] = $cod_pedido;
    $_SESSION['total'] = $total;
}
// ==========================================

$nome = $_SESSION['nome'] ?? "Cliente";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido | WasabiDO</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --bg-dark: #070707;
            --card-bg: rgba(20, 20, 20, 0.6);
            --card-border: rgba(255, 255, 255, 0.05);
            --text-light: #f4f4f4;
            --text-muted: #a1a1aa;
            --accent-red: #e60000;
            --accent-hover: #ff3333;
            --accent-green: #2ecc71;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background-color: #000;
            border-bottom: 3px solid var(--accent-red);
            padding: 0.8rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
        }

        .navbar-brand img {
            height: 50px;
        }

        .voltar-link {
            color: #eee !important;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .voltar-link:hover {
            color: var(--accent-red) !important;
        }

        .checkout-container {
            padding: 3rem 0 5rem;
        }

        .checkout-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            height: 100%;
        }

        .total-box {
            background: #000;
            border: 1px solid rgba(46, 204, 113, 0.15);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
        }

        .total-box h2 {
            color: var(--accent-green);
            font-weight: 800;
            text-shadow: 0 0 20px rgba(46, 204, 113, 0.15);
            margin: 0;
        }

        .form-label-custom {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-select,
        .form-control {
            background-color: rgba(0, 0, 0, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #fff !important;
            padding: 14px;
            border-radius: 12px;
            font-size: 0.95rem;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--accent-red) !important;
            box-shadow: 0 0 0 3px rgba(230, 0, 0, 0.2) !important;
        }

        .input-group-text-custom {
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-right: none;
            color: var(--text-muted);
            padding: 0 15px;
            border-radius: 12px 0 0 12px;
        }

        .btn-pagar {
            background: var(--accent-red);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-weight: 700;
            padding: 16px;
            letter-spacing: 0.05em;
            transition: all 0.2s ease-in-out;
        }

        .btn-pagar:hover {
            background: var(--accent-hover);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 51, 51, 0.35);
        }

        .payment-method-box {
            display: none;
            margin-top: 20px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            padding: 20px;
        }

        .qr-code-wrapper {
            background: #fff;
            padding: 15px;
            border-radius: 16px;
            display: inline-block;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
        }

        .qr-code-img {
            max-width: 160px;
            height: auto;
        }

        .btn-add-endereco {
            background-color: rgba(230, 0, 0, 0.1);
            border: 1px dashed var(--accent-red);
            color: #fff;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-add-endereco:hover {
            background-color: var(--accent-red);
            color: #fff;
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

    <div class="container checkout-container">
        <div class="row g-4 justify-content-center">

            <div class="col-lg-4 col-md-5 animate__animated animate__fadeInLeft">
                <div class="checkout-card d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-danger p-2 rounded-3 me-3 d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px; background-color: var(--accent-red) !important;">
                                <i class="bi bi-receipt-cutoff fs-5 text-white"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold m-0">Seu Pedido</h4>
                                <p class="text-secondary small m-0">Código: #<?= htmlspecialchars($cod_pedido) ?></p>
                            </div>
                        </div>
                        <hr style="border-color: rgba(255,255,255,0.1);">
                        <p class="text-secondary mb-4">Olá, <strong><?= htmlspecialchars($nome) ?></strong>! Verifique o
                            valor final antes de escolher o método de pagamento preferido.</p>
                    </div>

                    <div class="total-box mt-3">
                        <span class="text-uppercase small tracking-wider opacity-50 d-block mb-1"
                            style="font-size:0.75rem; font-weight:700;">Valor a Pagar</span>
                        <h2>R$ <?= number_format($total, 2, ',', '.') ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-7 animate__animated animate__fadeInRight">
                <div class="checkout-card">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-success p-2 rounded-3 me-3 d-flex align-items-center justify-content-center"
                            style="width: 45px; height: 45px; background-color: rgba(46, 204, 113, 0.2) !important;">
                            <i class="bi bi-credit-card-2-front fs-5" style="color: var(--accent-green);"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold m-0">Pagamento & Entrega</h4>
                            <p class="text-secondary small m-0">Preencha as informações para entrega</p>
                        </div>
                    </div>

                    <form method="POST" action="../../CONTROLLER/PagamentoController.php" id="paymentForm">
                        <input type="hidden" name="acao" value="Pagar">
                        <input type="hidden" name="cod_pedido" value="<?= htmlspecialchars($cod_pedido) ?>">
                        <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">

                        <div class="mb-4">
                            <label class="form-label form-label-custom">Endereço de Entrega</label>
                            <?php if (!empty($listaEnderecos)): ?>
                                <div class="input-group">
                                    <span class="input-group-text-custom">
                                        <i class="fa-solid fa-map-marker-alt"></i>
                                    </span>
                                    <select name="cod_endereco" id="selectEnderecoVisual" class="form-select"
                                        style="border-radius: 0 12px 12px 0;" required>
                                        <option value="" selected disabled>Selecione onde entregar...</option>
                                        <?php foreach ($listaEnderecos as $end): ?>
                                            <option value="<?= htmlspecialchars($end['cod']) ?>">
                                                <?= htmlspecialchars($end['rua'] ?? '') ?>,
                                                <?= htmlspecialchars($end['num'] ?? '') ?> -
                                                <?= htmlspecialchars($end['bairro'] ?? '') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-2">
                                    <p class="small text-secondary mb-2"><i class="bi bi-geo-fill text-danger"></i> Você não
                                        possui endereços cadastrados.</p>
                                    <a href="endereco.php" class="btn-add-endereco">
                                        <i class="bi bi-plus-circle me-1"></i> Cadastrar um Endereço agora
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label form-label-custom">Forma de Pagamento</label>
                            <div class="input-group">
                                <span class="input-group-text-custom">
                                    <i class="fa-solid fa-wallet"></i>
                                </span>
                                <select name="tipo" id="metodoPagamento" class="form-select"
                                    style="border-radius: 0 12px 12px 0;" required>
                                    <option value="" selected disabled>Clique para selecionar...</option>
                                    <option value="pix">🚀 PIX (Aprovação Instantânea)</option>
                                    <option value="cartao">💳 Cartão de Crédito</option>
                                    <option value="dinheiro">💵 Dinheiro</option>
                                </select>
                            </div>
                        </div>

                        <div id="dinheiroBox" class="payment-method-box animate__animated animate__fadeInUp">
                            <div class="mb-2">
                                <label class="form-label form-label-custom">Precisa de troco?</label>
                                <div class="input-group">
                                    <span class="input-group-text-custom">R$</span>
                                    <input type="number" step="0.01" name="troco" class="form-control"
                                        style="border-radius: 0 12px 12px 0;" placeholder="Troco para quanto?"
                                        min="<?= htmlspecialchars($total) ?>">
                                </div>
                                <small class="text-secondary mt-1 d-block">Deixe em branco caso não precise.</small>
                            </div>
                        </div>

                        <div id="pixBox" class="payment-method-box text-center animate__animated animate__fadeInUp">
                            <p class="small mb-3 text-secondary">Escaneie o QR Code abaixo no app do seu banco:</p>
                            <div class="qr-code-wrapper mb-3">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=PIX-WASABIDO"
                                    alt="QR Code" class="qr-code-img">
                            </div>
                            <p class="small mb-0 text-secondary">Chave CNPJ / E-mail:</p>
                            <span class="badge bg-dark border border-secondary text-white px-3 py-2 fw-bold mt-1"
                                style="font-size: 0.9rem;">wasabido@pix.com</span>
                        </div>

                        <div id="cartaoBox" class="payment-method-box text-center animate__animated animate__fadeInUp">
                            <p class="small text-info m-0"><i class="fa-solid fa-lock me-1"></i> Ambiente 100%
                                criptografado. Você será redirecionado para a nossa operadora de crédito segura.</p>
                        </div>

                        <button type="submit" class="btn btn-pagar w-100 mt-4">
                            Confirmar e Enviar Pedido <i class="fa-solid fa-chevron-right ms-2"
                                style="font-size:0.8rem;"></i>
                        </button>
                    </form>
                </div>

                <p class="text-center mt-4 text-secondary small opacity-50">
                    &copy; <?= date('Y') ?> WasabiDO - Checkout Seguro e Criptografado
                </p>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const metodoSelect = document.getElementById('metodoPagamento');
        const boxes = {
            pix: document.getElementById('pixBox'),
            dinheiro: document.getElementById('dinheiroBox'),
            cartao: document.getElementById('cartaoBox')
        };

        metodoSelect.addEventListener('change', function () {
            Object.values(boxes).forEach(box => box.style.display = 'none');
            const selected = this.value;
            if (boxes[selected]) {
                boxes[selected].style.display = 'block';
            }
        });
    </script>
</body>

</html>
