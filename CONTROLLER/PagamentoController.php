<?php
// Gerenciamento seguro da sessão para permitir o uso de $_SESSION sem quebras
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclusões estáveis baseadas no diretório atual do arquivo
require_once __DIR__ . "/../verificacao.php";
require_once __DIR__ . "/../MODEL/PagamentoModel.php";
require_once __DIR__ . "/../MODEL/ContemModel.php"; 
require_once __DIR__ . "/../DAO/PagamentoDAO.php";
require_once __DIR__ . "/../DAO/ContemDAO.php";

$pagamento = new Pagamento();
$dao = new PagamentoDAO();
$contemDAO = new ContemDAO();

$acao = $_POST['acao'] ?? "";
$tipo = $_POST['tipo'] ?? "";
$codPedido = $_POST['cod_pedido'] ?? ($_SESSION['cod_pedido'] ?? null);

// 📥 RECEBE O CÓDIGO DO ENDEREÇO E TRATA STRINGS VAZIAS COMO NULL SEGURO
$codEnderecoRaw = $_POST['cod_endereco'] ?? '';
$codEndereco = (!empty($codEnderecoRaw) && is_numeric($codEnderecoRaw)) ? (int)$codEnderecoRaw : null;

switch ($acao) {

    case "Pagar":

        $pagamento->setTipo($tipo);
        $pagamento->setStatus("Pago");

        $codPagamento = $dao->inserir($pagamento);

        // ============================================================
        // 🎯 SOLUÇÃO DA CONEXÃO NULA: 
        // Em vez de fazer include manual e arriscar quebras de escopo,
        // delegamos a atualização do pedido diretamente para o PagamentoDAO 
        // usando o método que já criamos anteriormente!
        // ============================================================
        $dao->vincularPagamento($codPedido, $codPagamento, 'Pago');

        // Se o seu banco exige atualizar o endereço especificamente neste momento,
        // fazemos a query diretamente aqui trazendo a variável global explicitamente:
        if ($codEndereco !== null) {
            require_once __DIR__ . "/../conexao.php";
            // Força o PHP a enxergar a conexão que foi instanciada globalmente
            global $conexao; 
            
            if ($conexao !== null) {
                $sql = "UPDATE pedido SET cod_endereco = :cod_endereco WHERE cod = :cod_pedido";
                $consulta = $conexao->prepare($sql);
                $consulta->bindValue(":cod_endereco", $codEndereco, PDO::PARAM_INT);
                $consulta->bindValue(":cod_pedido", $codPedido, PDO::PARAM_INT);
                $consulta->execute();
            }
        }

        // =========================
        // 🔥 INSERIR ITENS NA CONTEM (COM SWITCH)
        // =========================
        $carrinho = $_SESSION['carrinho'] ?? [];

        switch (true) {

            case empty($carrinho):
                // carrinho vazio → não faz nada
                break;

            default:
                foreach ($carrinho as $item) {

                    $contem = new Contem();

                    $contem->setCodPedido($codPedido);
                    $contem->setCodProduto($item['id']);
                    $contem->setQuantidade($item['quantidade']);
                    $contem->setPrecoUnitario($item['preco']);
                    $contem->setSubtotal($item['quantidade'] * $item['preco']);

                    $contemDAO->inserir($contem);
                }
                break;
        }

        // =========================
        // LIMPA CARRINHO
        // =========================
        unset($_SESSION['carrinho']);
        unset($_SESSION['cod_pedido']);

        // =========================
        // REDIRECIONA
        // =========================
        header("Location: ../VIEW/cliente/meuP.php");
        exit();

        break;

    default:
        echo "Ação não reconhecida";
        break;
}
?>
