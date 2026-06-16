<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Análise de Cadastro - WasabiDO</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --bg-dark: #070707;
      --card-bg: rgba(20, 20, 20, 0.75);
      --card-border: rgba(255, 255, 255, 0.05);
      --text-light: #f4f4f4;
      --accent-red: #e60000;
    }
    body, html {
      margin: 0; padding: 0; color: var(--text-light); font-family: 'Inter', sans-serif;
      background: linear-gradient(rgba(7, 7, 7, 0.85), rgba(7, 7, 7, 0.98)), url('https://images.unsplash.com/photo-1553621042-f6e147245754?q=80&w=1400&auto=format&fit=crop') no-repeat center center/cover;
      min-height: 100vh; display: flex; align-items: center; justify-content: center;
    }
    .box-espera {
      width: 100%; max-width: 550px; padding: 45px; background: var(--card-bg);
      backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
      border-radius: 24px; border: 1px solid var(--card-border);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6); text-align: center;
    }
    .icon-clock { font-size: 4.5rem; color: var(--accent-red); animation: pulse 2s infinite; }
    h2 { font-weight: 800; margin-top: 20px; }
    p { color: #a1a1aa; font-size: 1.05rem; line-height: 1.6; }
    .btn-voltar {
      background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #fff;
      padding: 12px 30px; border-radius: 12px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; margin-top: 15px;
    }
    .btn-voltar:hover { background: #fff; color: #000; }
    @keyframes pulse {
      0% { transform: scale(1); opacity: 0.8; }
      50% { transform: scale(1.08); opacity: 1; }
      100% { transform: scale(1); opacity: 0.8; }
    }
  </style>
</head>
<body>

  <div class="box-espera">
    <i class="bi bi-clock-history icon-clock"></i>
    <h2>Cadastro em Análise!</h2>
    <p class="my-4">
      Olá! Recebemos suas informações de motorista e os documentos do seu veículo. Para garantir a segurança da comunidade <strong>WasabiDO</strong>, nossa equipe de administração está validando os dados fornecidos.
    </p>
    <p class="mb-4 text-sm" style="color: #e60000; font-weight: 500;">
      Assim que seu status mudar para aprovado, você será redirecionado automaticamente para a plataforma de entregas.
    </p>
    
    <a href="../VIEW/login.php" class="btn-voltar">Voltar para o Início</a>
  </div>

  <script>
    function checarStatusAprovacao() {
      // Faz uma requisição assíncrona para o arquivo PHP que criamos
      fetch('verificar_status.php')
        .then(response => response.json())
        .then(data => {
          if (data.status === 'Aprovado') {
            // Mude o caminho abaixo para a tela principal do entregador
            window.location.href = "../VIEW/entregador/principal.php"; 
          }
        })
        .catch(error => console.error('Erro ao verificar status:', error));
    }

    // Executa a função a cada 5000 milissegundos (5 segundos)
    setInterval(checarStatusAprovacao, 5000);
  </script>

</body>
</html>
