<?php
session_start();

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Resumo do Pedido</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#111; color:#fff;">

<div class="container py-5">
  <div class="col-md-8 mx-auto">

    <h3 class="text-center mb-4">Resumo do Pedido</h3>

    <ul class="list-group mb-3">

    <?php if (!empty($_SESSION['carrinho'])): ?>

        <?php foreach ($_SESSION['carrinho'] as $item): ?>

            <?php
                $subtotal = $item['preco'] * $item['quantidade'];
                $total += $subtotal;
            ?>

            <li class="list-group-item d-flex justify-content-between">
                Produto <?= $item['id'] ?> (x<?= $item['quantidade'] ?>)
                <strong>R$ <?= number_format($subtotal,2,',','.') ?></strong>
            </li>

        <?php endforeach; ?>

    <?php else: ?>

        <li class="list-group-item text-center">Carrinho vazio</li>

    <?php endif; ?>

    </ul>

    <h4 class="text-center text-success">
      Total: R$ <?= number_format($total,2,',','.') ?>
    </h4>

    <!-- 🔥 AGORA VAI PARA A TELA DE PAGAMENTO -->
    <form method="POST" action="pagamento.php">

        <input type="hidden" name="total" value="<?= $total ?>">
        <input type="hidden" name="cod_pedido" value="<?= $_SESSION['cod_pedido'] ?? '' ?>">

        <button class="btn btn-danger w-100 mt-4">
            Ir para pagamento
        </button>
    </form>

  </div>
</div>

</body>
</html>