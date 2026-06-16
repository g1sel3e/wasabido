<?php

class ContemDAO
{
    // ============================================================
    // INSERT - INSERIR ITEM NO PEDIDO
    // ============================================================
    public function inserir($contem)
    {
        // require_once garante o reuso limpo da conexão em loops de inserção
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        // 🛡️ REDE DE SEGURANÇA: Se a conexão global sumiu ou veio nula neste escopo, força a reinjeção local
        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

        try {

            $sql = "INSERT INTO contem 
                    (cod_pedido, cod_produto, quantidade, preco_unitario, subtotal)
                    VALUES 
                    (:cod_pedido, :cod_produto, :quantidade, :preco_unitario, :subtotal)";

            $stmt = $conexao->prepare($sql);

            $stmt->bindValue(":cod_pedido", $contem->getCodPedido());
            $stmt->bindValue(":cod_produto", $contem->getCodProduto());
            $stmt->bindValue(":quantidade", $contem->getQuantidade());
            $stmt->bindValue(":preco_unitario", $contem->getPrecoUnitario());
            $stmt->bindValue(":subtotal", $contem->getSubtotal());

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Erro ao inserir item do pedido: " . $e->getMessage();
            return false;
        }
    }

    // ============================================================
    // LISTAR ITENS DE UM PEDIDO
    // ============================================================
    public function listarPorPedido($cod_pedido)
    {
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

        $sql = "SELECT 
                    c.cod,
                    c.cod_pedido,
                    c.cod_produto,
                    c.quantidade,
                    c.preco_unitario,
                    c.subtotal,
                    p.nome AS nome_produto
                FROM contem c
                INNER JOIN produto p ON p.cod = c.cod_produto
                WHERE c.cod_pedido = :cod_pedido";

        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":cod_pedido", $cod_pedido);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // EXCLUIR ITEM
    // ============================================================
    public function excluir($cod)
    {
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

        try {
            $sql = "DELETE FROM contem WHERE cod = :cod";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":cod", $cod);

            return $stmt->execute();

        } catch (PDOException $e) {
            echo "Erro ao excluir item: " . $e->getMessage();
            return false;
        }
    }
}

?>
