<?php
class PagamentoDAO
{

    // =========================
    // CREATE - INSERIR
    // =========================
    function inserir($pagamento)
    {
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        // 🛡️ REDE DE SEGURANÇA: Se a conexão global sumiu ou veio nula, força a reinjeção local
        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

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
        require_once __DIR__ . "/../conexao.php";
        global $conexao; 

        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

        try {
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
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

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
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

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
        require_once __DIR__ . "/../conexao.php";
        global $conexao;

        if (!isset($conexao) || $conexao === null) {
            include __DIR__ . "/../conexao.php";
        }

        $sql = "DELETE FROM pagamento WHERE cod = :cod";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);

        return $consulta->execute();
    }
}
?>
