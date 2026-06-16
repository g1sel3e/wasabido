<?php
// 1. Primeiro verifica se está logado (Usando caminho relativo seguro)
require_once __DIR__ . "/../../verificacao.php";

// 2. Depois carrega as dependências de banco de dados
require_once __DIR__ . "/../../DAO/PedidoDAO.php";
require_once __DIR__ . "/../../DAO/ContemDAO.php";

// 3. Instancia as classes e busca os dados
$pedidoDAO = new PedidoDAO();
$contemDAO = new ContemDAO();
$pedidos = $pedidoDAO->listarPedidosConfirmados();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entregas | WasabiDO</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-dark: #0a0a0a;
            --card-bg: #111;
            --card-border: #1f1f1f;
            --text-light: #eeeeee;
            --text-muted: #cccccc;
            --accent-red: #e60000;
            --accent-hover: #ff3333;
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

        /* NAVBAR PADRONIZADA PREMIUM */
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
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .voltar-link:hover {
            color: var(--text-light) !important;
        }

        /* CONTEÚDO DA PÁGINA */
        .page-title {
            font-weight: 900;
            font-size: 2.5rem;
            color: #eee;
        }

        .page-title span {
            color: var(--accent-red);
        }

        .order-card {
            background: var(--card-bg);
            border-radius: 15px;
            border: 1px solid var(--card-border);
            transition: 0.3s;
            height: 100%;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.25);
        }

        .card-header-custom {
            background-color: transparent;
            border-bottom: 1px dashed #333;
        }

        .info-icon {
            color: var(--accent-red);
            width: 25px;
            text-align: center;
            font-size: 1.1rem;
        }

        .items-box {
            background-color: #1a1a1a;
            border-radius: 12px;
            padding: 15px;
            border: 1px solid #222;
        }

        .text-secondary-custom {
            color: #bbb !important;
        }

        .btn-custom-action {
            border-radius: 8px;
            font-weight: 600;
            padding: 12px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-accept {
            background-color: var(--accent-red);
            border: none;
            color: #fff;
        }

        .btn-accept:hover {
            background-color: var(--accent-hover);
            box-shadow: 0 0 15px rgba(230, 0, 0, 0.4);
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

    <div class="container mt-5 mb-5">

        <div class="mb-5 text-center text-md-start">
            <h2 class="page-title">Entregas <span>Disponíveis</span></h2>
            <p class="text-secondary-custom">Selecione um pedido para iniciar a entrega</p>
        </div>

        <div class="row g-4">

            <?php if (empty($pedidos)) { ?>
                <div class="col-12 text-center mt-5">
                    <i class="bi bi-box-seam text-secondary" style="font-size: 3rem;"></i>
                    <p class="text-secondary-custom mt-3">Nenhum pedido aguardando entrega no momento.</p>
                </div>
            <?php } else { ?>

                <?php foreach ($pedidos as $p) { ?>

                    <div class="col-md-6 col-lg-4">
                        <div class="order-card d-flex flex-column">

                            <div class="card-header-custom p-3">
                                <h5 class="mb-0 fw-bold">
                                    Pedido <span style="color: #e60000;">#<?= $p['cod'] ?></span>
                                </h5>
                            </div>

                            <div class="p-3 flex-grow-1">
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-person-circle info-icon me-2"></i>
                                        <span class="fw-semibold"><?= htmlspecialchars($p['nome_cliente']) ?></span>
                                    </div>

                                    <div class="d-flex align-items-start mb-3">
                                        <i class="bi bi-geo-alt-fill info-icon me-2 mt-1"></i>
                                        <div>
                                            <span class="d-block fw-bold text-white">Endereço de Entrega:</span>
                                            <small class="text-secondary-custom">
                                                <?= htmlspecialchars($p['rua']) ?>, <?= htmlspecialchars($p['num']) ?><br>
                                                <?= htmlspecialchars($p['bairro']) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="items-box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Total a receber:</span>
                                        <span class="fs-5 fw-bold" style="color: #28a745;">
                                            R$ <?= number_format($p['valor_total'], 2, ',', '.') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 pt-0 mt-auto">
                                <form method="POST" action="../../CONTROLLER/PedidoController.php">

                                    <input type="hidden" name="acao" value="AceitarEntrega">
                                    <input type="hidden" name="cod_pedido" value="<?= $p['cod'] ?>">

                                    <button type="submit" class="btn btn-accept btn-custom-action w-100">
                                        <i class="bi bi-bicycle me-2"></i> Aceitar Entrega
                                    </button>

                                </form>
                            </div>

                        </div>
                    </div>

                <?php } ?>
            <?php } ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
