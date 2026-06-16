<?php
class PagamentoDAO
{

    // =========================
    // CREATE - INSERIR
    // =========================
    function inserir($pagamento)
    {
        include __DIR__ . "/../conexao.php";



        $sql = "INSERT INTO pagamento (tipo, status)
                VALUES (:tipo, :status)";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":tipo", $pagamento->getTipo());
        $consulta->bindValue(":status", $pagamento->getStatus());

        $consulta->execute();

        // retorna o ID gerado
        return $conexao->lastInsertId();
    }

    public function vincularPagamento($codPedido, $codPagamento, $novoStatus = 'Pago')
    {
        include __DIR__ . "/../conexao.php";

        try {
            // Ajuste o nome da coluna 'cod_pagamento' se no seu banco for diferente (ex: fk_pagamento)
            $sql = "UPDATE pedido 
                SET cod_pagamento = :codPagamento, status = :novoStatus 
                WHERE cod = :codPedido";

            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":codPagamento", $codPagamento);
            $stmt->bindValue(":novoStatus", $novoStatus);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao vincular pagamento ao pedido: " . $e->getMessage();
            return false;
        }
    }

    // =========================
    // READ - LISTAR TODOS
    // =========================
    function listar()
    {
        include __DIR__ . "/../conexao.php";

        $sql = "SELECT * FROM pagamento ORDER BY cod DESC";
        $consulta = $conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // =========================
    // UPDATE - ATUALIZAR STATUS
    // =========================
    function atualizarStatus($cod, $status)
    {
        include __DIR__ . "/../conexao.php";

        $sql = "UPDATE pagamento
                SET status = :status
                WHERE cod = :cod";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);
        $consulta->bindValue(":status", $status);

        return $consulta->execute();
    }

    // =========================
    // DELETE - APAGAR
    // =========================
    function apagar($cod)
    {
        include __DIR__ . "/../conexao.php";

        $sql = "DELETE FROM pagamento WHERE cod = :cod";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);

        return $consulta->execute();
    }
}
?>