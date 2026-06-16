<?php
require_once "../../verificacao.php";
require_once "../../DAO/PedidoDAO.php";

$pedidoDAO = new PedidoDAO();
// Pega o histórico detalhado do entregador logado
$historico = $pedidoDAO->listarHistoricoEntregas($_SESSION['cod']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Entregas | WasabiDO</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            --accent-green: #22c55e;
            --table-hover: #1b1b1f;
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
        .card-historico {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            margin-top: 2rem;
        }

        /* ESTILIZAÇÃO DA TABELA PADRONIZADA */
        .table-responsive {
            background-color: transparent;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .table {
            color: #ffffff !important;
            margin-bottom: 0;
            vertical-align: middle;
            --bs-table-bg: transparent !important;
            --bs-table-hover-bg: transparent !important;
        }

        .table th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            padding: 16px;
            border-bottom: 2px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            background-color: #0a0a0c !important;
        }

        .table td {
            padding: 20px 16px;
            border-bottom: 1px solid var(--border-color) !important;
            font-size: 0.9rem;
            background-color: transparent !important;
        }

        .table-hover tbody tr:hover td {
            background-color: var(--table-hover) !important;
            transition: background-color 0.2s ease;
        }

        /* COMPONENTES INTERNOS */
        .text-vermelho-marca {
            color: var(--wasabi-red) !important;
        }

        .text-ganho {
            color: var(--accent-green) !important;
            font-weight: 700 !important;
            font-size: 1.05rem !important;
            text-shadow: 0 0 10px rgba(34, 197, 94, 0.15);
        }

        .badge-pedido {
            background-color: var(--bg-input) !important;
            color: var(--text-light) !important;
            border: 1px solid var(--border-color) !important;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .badge-complemento {
            background-color: rgba(255, 255, 255, 0.03) !important;
            color: var(--text-muted) !important;
            border: 1px solid var(--border-color) !important;
            font-size: 0.75rem;
        }

        .info-local strong {
            color: #ffffff !important;
            font-size: 0.95rem;
            display: block;
            margin-bottom: 2px;
        }

        .info-local .text-muted-custom {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* ALERT CUSTOMIZADO */
        .alert-custom {
            background: #0a0a0c;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            border-radius: 8px;
            padding: 40px;
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

    <main class="container mb-5 animate__animated animate__fadeIn">
        <div class="card-historico">
            <div class="text-center mb-4">
                <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: rgba(230, 0, 0, 0.08); color: var(--wasabi-red);">
                    <i class="bi bi-clock-history fs-3"></i>
                </div>
                <h2 class="fw-bold mb-1">Histórico de Entregas</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">Todas as suas corridas finalizadas na plataforma.</p>
            </div>

            <?php if (count($historico) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="12%">Pedido</th>
                                <th scope="col" width="15%">Data</th>
                                <th scope="col" width="40%">Destino</th>
                                <th scope="col" width="20%">Horários</th>
                                <th scope="col" width="13%">Valor Ganho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historico as $entrega): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-pedido py-2 px-3">
                                            #<?php echo substr($entrega['num'], 0, 8); ?>
                                        </span>
                                    </td>

                                    <td class="text-nowrap fw-medium text-white">
                                        <i class="bi bi-calendar3 text-vermelho-marca me-2"></i><?php echo date('d/m/Y', strtotime($entrega['data_entrega'])); ?>
                                    </td>

                                    <td class="info-local">
                                        <strong><?php echo htmlspecialchars($entrega['rua']) . ", " . htmlspecialchars($entrega['numero_casa']); ?></strong>
                                        <?php if (!empty($entrega['complemento'])): ?>
                                            <span class="badge badge-complemento my-1 font-monospace">
                                                <?php echo htmlspecialchars($entrega['complemento']); ?>
                                            </span><br>
                                        <?php endif; ?>
                                        <span class="text-muted-custom"><?php echo htmlspecialchars($entrega['bairro']) . " — " . htmlspecialchars($entrega['cidade']); ?></span>
                                    </td>

                                    <td class="text-nowrap">
                                        <div class="mb-1" style="font-size: 0.85rem;">
                                            <span class="text-muted"><i class="bi bi-box-arrow-up me-1 text-vermelho-marca"></i> Coleta:</span> 
                                            <span class="text-white fw-semibold"><?php echo !empty($entrega['hora_saida']) ? date('H:i', strtotime($entrega['hora_saida'])) : '--:--'; ?></span>
                                        </div>
                                        <div style="font-size: 0.85rem;">
                                            <span class="text-muted"><i class="bi bi-check2-all me-1" style="color: var(--accent-green);"></i> Entrega:</span> 
                                            <span style="color: var(--accent-green);" class="fw-semibold"><?php echo !empty($entrega['hora_chegada']) ? date('H:i', strtotime($entrega['hora_chegada'])) : '--:--'; ?></span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="text-ganho text-nowrap">
                                            R$ <?php echo number_format($entrega['valor_total'], 2, ',', '.'); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-custom text-center mt-3">
                    <i class="bi bi-inbox text-muted display-5 d-block mb-3"></i>
                    <span class="fs-6 text-muted">Nenhuma entrega finalizada encontrada no seu histórico.</span>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container text-center text-muted small">
            &copy; 2026 WasabiDO System. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>