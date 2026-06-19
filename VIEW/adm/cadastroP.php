<?php
require_once __DIR__ . "/../../verificacao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Cadastro de Produto - WasabiDO</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      color: #eee;
      font-family: 'Segoe UI', sans-serif;

      background:
        linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
        url('https://images.unsplash.com/photo-1553621042-f6e147245754?q=80&w=1400&auto=format&fit=crop') no-repeat center center/cover;

      min-height: 100vh;
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
      letter-spacing: 1px;
      transition: 0.3s;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #e60000 !important;
    }

    /* CONTAINER */
    .container-cadastro {
      min-height: calc(100vh - 70px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    /* BOX */
    .box-cadastro {
      width: 100%;
      max-width: 500px;
      padding: 35px;

      background: rgba(15, 15, 15, 0.85);
      backdrop-filter: blur(8px);

      border-radius: 15px;
      border: 1px solid rgba(230, 0, 0, 0.3);

      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
      color: #fff;
    }

    .input-group-text {
      background: #0d0d0d;
      border: 1px solid #222;
      color: #e60000;
    }

    .form-control,
    .form-select {
      background: #0d0d0d;
      border: 1px solid #222;
      color: #ddd;
    }

    .form-control::placeholder {
      color: #888;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #e60000;
      box-shadow: 0 0 6px rgba(230, 0, 0, 0.4);
      background: #0d0d0d;
      color: #fff;
    }

    /* REMOVE SETINHAS DO NUMBER */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type=number] {
      -moz-appearance: textfield;
    }

    /* BOTÃO */
    .btn-cadastro {
      width: 100%;
      padding: 12px;
      font-weight: 600;
      margin-top: 15px;
      background: #e60000;
      border: none;
      color: #fff;
      border-radius: 8px;
      transition: 0.2s;
    }

    .btn-cadastro:hover {
      background: #c40000;
    }

    .form-label {
      margin-top: 10px;
      color: #bbb;
    }

    /* UPLOAD BONITO */
    .upload-box {
      width: 100%;
      height: 120px;
      border: 2px dashed #333;
      border-radius: 12px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: 0.3s;
      background: #0d0d0d;
      position: relative; /* Adicionado para conter a imagem absoluta */
      overflow: hidden;    /* Adicionado para cortar a imagem nas curvas do card */
    }

    .upload-box i {
      font-size: 1.8rem;
      color: #e60000;
    }

    .upload-box span {
      font-size: 0.8rem;
      color: #aaa;
    }

    .upload-box:hover {
      border-color: #e60000;
      background: #111;
      transform: scale(1.03);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

      <div class="navbar-brand">
        <img src="../../imagens/ws.png" alt="Logo">
      </div>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="produtos.php" class="nav-link active">Voltar</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>

  <main class="container-cadastro">

    <div class="box-cadastro">

      <h2>Cadastro de Produto</h2>

      <form action="../../CONTROLLER/ProdutoController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="acao" value="Inserir">

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
          <input type="text" name="nome" class="form-control" placeholder="Nome do produto" required>
        </div>

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
          <input type="number" step="0.01" name="preco" class="form-control" placeholder="Preço" required>
        </div>



        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-tags"></i></span>
          <select name="categoria" class="form-select" required>
            <option value="">Selecione a categoria</option>

            <option value="sushi">Sushi</option>
            <option value="sashimi">Sashimi</option>
            <option value="ramen">Ramen</option>
            <option value="temaki">Temaki</option>
            <option value="tempura">Tempurá</option>
            <option value="yakitori">Yakitori</option>
            <option value="donburi">Donburi</option>
            <option value="udon_soba">Udon / Soba</option>
            <option value="onigiri">Onigiri</option>
            <option value="curry">Curry Japonês</option>
            <option value="bebida">Bebidas</option>
            <option value="sobremesa">Sobremesas (Wagashi)</option>

          </select>
        </div>

        <div class="mb-3 input-group">
          <span class="input-group-text"><i class="bi bi-card-text"></i></span>
          <textarea name="descricao" class="form-control" placeholder="Descrição" rows="3" required></textarea>
        </div>
        <h6 class="form-label">Fotos do Produto</h6>

        <div class="row g-3">

          <div class="col-6">
            <label class="upload-box">
              <i class="bi bi-image"></i>
              <span>Adicionar</span>
              <input type="file" name="foto1" accept="image/*" hidden>
            </label>
          </div>

          <div class="col-6">
            <label class="upload-box">
              <i class="bi bi-image"></i>
              <span>Adicionar</span>
              <input type="file" name="foto2" accept="image/*" hidden>
            </label>
          </div>

          <div class="col-6">
            <label class="upload-box">
              <i class="bi bi-image"></i>
              <span>Adicionar</span>
              <input type="file" name="foto3" accept="image/*" hidden>
            </label>
          </div>

          <div class="col-6">
            <label class="upload-box">
              <i class="bi bi-image"></i>
              <span>Adicionar</span>
              <input type="file" name="foto4" accept="image/*" hidden>
            </label>
          </div>

        </div>

        <button type="submit" class="btn btn-cadastro">
          <i class="bi bi-plus-circle me-1"></i> Cadastrar Produto
        </button>

      </form>

    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.querySelectorAll('.upload-box input[type="file"]').forEach(input => {
      input.addEventListener('change', function () {
        const arquivo = this.files[0];
        if (arquivo) {
          const box = this.closest('.upload-box');
          const icone = box.querySelector('i');
          const texto = box.querySelector('span');

          // Verifica se já existe uma tag img criada anteriormente, senão cria uma nova
          let img = box.querySelector('.preview-img');
          if (!img) {
            img = document.createElement('img');
            img.classList.add('preview-img');
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.position = 'absolute';
            img.style.top = '0';
            img.style.left = '0';
            box.appendChild(img);
          }

          // Alimenta o link temporário da imagem no src
          img.src = URL.createObjectURL(arquivo);

          // Oculta o ícone padrão e o texto para evidenciar o preview
          if (icone) icone.style.display = 'none';
          if (texto) texto.style.display = 'none';
        }
      });
    });
  </script>

</body>

</html>
