<?php
require_once __DIR__ . "/../verificacao.php";

class PedidoDAO
{
    // Propriedade privada que armazenará o objeto PDO ativo
    private $conexao;

    // O construtor captura o retorno direto do arquivo conexao.php
    public function __construct()
    {
        // Força a inclusão do arquivo e guarda o seu "return $conexao;"
        $this->conexao = require __DIR__ . "/../conexao.php";
        
        // Verificação de segurança: impede que a classe rode se o banco falhar
        if (!$this->conexao instanceof PDO) {
            die("Erro crítico: O arquivo de conexão não retornou uma instância válida do PDO no PedidoDAO.");
        }
    }

    function inserir($pedido)
    {
        try {
            $sql = "INSERT INTO pedido 
            (num, valor_total, status, data, hora, cod_cliente, cod_pagamento)
            VALUES (:num, :valor_total, :status, :data, :hora, :cod_cliente, :cod_pagamento)";

            $consulta = $this->conexao->prepare($sql);

            $consulta->bindValue(":num", $pedido->getNum());
            $consulta->bindValue(":valor_total", $pedido->getValorTotal());
            $consulta->bindValue(":status", $pedido->getStatus());
            $consulta->bindValue(":data", $pedido->getData());
            $consulta->bindValue(":hora", $pedido->getHora());
            $consulta->bindValue(":cod_cliente", $pedido->getCodCliente());
            $consulta->bindValue(":cod_pagamento", $pedido->getCodPagamento());

            if ($consulta->execute()) {
                return $this->conexao->lastInsertId();
            }

            return false;

        } catch (PDOException $e) {
            error_log("Erro ao inserir pedido no Banco de Dados: " . $e->getMessage());
            return false;
        }
    }

    public function listarPorCliente($cod_cliente)
    {
        $sql = "SELECT 
                p.cod,
                p.num,
                p.data,
                p.status,
                p.valor_total,
                pag.tipo AS forma_pagamento,
                IFNULL(ent.nome, 'Não atribuído') AS nome_entregador, 
                CONCAT(e.rua, ', nº ', e.num, ' - ', e.bairro) AS endereco_entrega
            FROM pedido p
            LEFT JOIN pagamento pag ON p.cod_pagamento = pag.cod
            LEFT JOIN entregador ent ON p.cod_entregador = ent.cod
            LEFT JOIN endereco e ON e.cod_cliente = :cod_cliente
            WHERE p.cod_cliente = :cod_cliente
            ORDER BY p.data DESC, p.cod DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":cod_cliente", $cod_cliente);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // BUSCAR TODOS OS PEDIDOS DE UM DETERMINADO CLIENTE
    // ============================================================
    public function buscarPedidosDoCliente($codCliente)
    {
        try {
            $sql = "SELECT cod, num, status, data, hora, hora_saida, hora_chegada, valor_total 
                FROM pedido 
                WHERE cod_cliente = :codCliente 
                ORDER BY data DESC, hora DESC";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(":codCliente", $codCliente);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Erro ao buscar pedidos: " . $e->getMessage();
            return [];
        }
    }

    public function listarEntregadores()
    {
        $sql = "SELECT cod, nome, veiculo, placa FROM entregador WHERE status = 'aprovado'";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorEntregador($cod_entregador)
    {
        $sql = "SELECT 
                p.cod,
                p.num,
                p.data,
                p.status,
                p.valor_total,
                pag.tipo AS forma_pagamento,
                IFNULL(c.nome, 'Cliente não identificado') AS nome_cliente,
                'Wasabi Central' AS nome_estabelecimento,
                CONCAT(e.rua, ', nº ', e.num, ' - ', e.bairro) AS endereco_entrega
            FROM pedido p
            LEFT JOIN pagamento pag ON p.cod_pagamento = pag.cod
            LEFT JOIN cliente c ON p.cod_cliente = c.cod
            LEFT JOIN endereco e ON e.cod_cliente = p.cod_cliente
            WHERE p.cod_entregador = :cod_entregador
            ORDER BY p.data DESC, p.cod DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":cod_entregador", $cod_entregador);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function atualizarPagamento($codPedido, $codPagamento, $status)
    {
        $sql = "UPDATE pedido 
            SET cod_pagamento = :cod_pagamento,
                status = :status
            WHERE cod = :cod_pedido";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(":cod_pagamento", $codPagamento);
        $stmt->bindValue(":status", $status);
        $stmt->bindValue(":cod_pedido", $codPedido);

        return $stmt->execute();
    }

    public function listarPedidosPagos()
    {
        $sql = "SELECT 
                pedido.*,
                cliente.nome AS nome_cliente,
                cliente.tel AS telefone_cliente,
                endereco.cep,
                endereco.bairro,
                endereco.rua,
                endereco.num,
                endereco.complemento,
                endereco.cidade,
                pagamento.tipo AS forma_pagamento
            FROM pedido
            INNER JOIN cliente 
                ON pedido.cod_cliente = cliente.cod
            INNER JOIN endereco 
                ON cliente.cod = endereco.cod_cliente
            INNER JOIN pagamento
                ON pedido.cod_pagamento = pagamento.cod
            WHERE pedido.status = 'Pago'";

        $consulta = $this->conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarStatusPedido($codPedido, $status, $codAdmin = null)
    {
        $sql = "UPDATE pedido 
            SET status = :status,
                cod_administrador = :cod_admin 
            WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":status", $status);
        $consulta->bindValue(":cod_admin", $codAdmin);
        $consulta->bindValue(":cod", $codPedido);

        return $consulta->execute();
    }

    function listarPedidosConfirmados()
    {
        $sql = "SELECT 
                    pedido.*,
                    cliente.nome AS nome_cliente,
                    cliente.tel AS telefone_cliente,
                    endereco.cep,
                    endereco.bairro,
                    endereco.rua,
                    endereco.num,
                    endereco.complemento,
                    endereco.cidade
                FROM pedido
                INNER JOIN cliente 
                    ON pedido.cod_cliente = cliente.cod
                INNER JOIN endereco 
                    ON cliente.cod = endereco.cod_cliente
                WHERE pedido.status = 'confirmado'
                ORDER BY pedido.data DESC, pedido.hora DESC";

        $consulta = $this->conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function aceitarEntrega($codPedido, $codEntregador)
    {
        $sql = "UPDATE pedido 
            SET status = 'entrega aceita',
                cod_entregador = :cod_entregador 
            WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":cod_entregador", $codEntregador);
        $consulta->bindValue(":cod", $codPedido);

        return $consulta->execute();
    }

    public function atualizarStatusPorEntregador($codPedido, $novoStatus, $codEntregador)
    {
        $sql = "UPDATE pedido SET status = :status WHERE cod = :cod AND cod_entregador = :cod_entregador";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":status", $novoStatus);
        $consulta->bindValue(":cod", $codPedido);
        $consulta->bindValue(":cod_entregador", $codEntregador);
        return $consulta->execute();
    }

    public function listarMinhasEntregas($codEntregador)
    {
        $sql = "SELECT 
                pedido.*,
                cliente.nome AS nome_cliente,
                cliente.tel AS telefone_cliente,
                endereco.bairro,
                endereco.rua,
                endereco.num,
                endereco.complemento
            FROM pedido
            INNER JOIN cliente ON pedido.cod_cliente = cliente.cod
            INNER JOIN endereco ON cliente.cod = endereco.cod_cliente
            WHERE pedido.status = 'entrega aceita' 
              AND pedido.cod_entregador = :cod_entregador
            ORDER BY pedido.data DESC";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod_entregador", $codEntregador);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarMinhasEntregasEmCurso($codEntregador)
    {
        $sql = "SELECT 
                    pedido.*,
                    cliente.nome AS nome_cliente,
                    cliente.tel AS telefone_cliente,
                    endereco.bairro,
                    endereco.rua,
                    endereco.num,
                    endereco.complemento,
                    endereco.cidade
                FROM pedido
                INNER JOIN cliente ON pedido.cod_cliente = cliente.cod
                INNER JOIN endereco ON cliente.cod = endereco.cod_cliente
                WHERE pedido.status = 'saiu para entrega' 
                  AND pedido.cod_entregador = :cod_entregador
                ORDER BY pedido.data DESC, pedido.hora DESC";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod_entregador", $codEntregador);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- NOVOS MÉTODOS COM REGISTRO DE TEMPO ---

    public function confirmarSaidaParaEntrega($codPedido)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d');
        $horaAtual = date('H:i:s');

        $sql = "UPDATE pedido 
                SET status = 'saiu para entrega',
                    data_entrega = :data,
                    hora_saida = :hora 
                WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":data", $dataAtual);
        $consulta->bindValue(":hora", $horaAtual);
        $consulta->bindValue(":cod", $codPedido);

        return $consulta->execute();
    }

    public function finalizarEntregaPedido($codPedido)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $horaAtual = date('H:i:s');

        $sql = "UPDATE pedido 
                SET status = 'entregue',
                    hora_chegada = :hora 
                WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":hora", $horaAtual);
        $consulta->bindValue(":cod", $codPedido);

        return $consulta->execute();
    }

    public function mudarStatusApenas($codPedido, $status)
    {
        $sql = "UPDATE pedido SET status = :status WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":status", $status);
        $consulta->bindValue(":cod", $codPedido);

        return $consulta->execute();
    }
    
    public function listarHistoricoEntregas($codEntregador)
    {
        $sql = "SELECT 
                p.num,
                p.valor_total,
                p.data_entrega,
                p.hora_saida,
                p.hora_chegada,
                e.rua,
                e.num AS numero_casa,
                e.bairro,
                e.cidade,
                e.complemento
            FROM pedido p
            INNER JOIN cliente c ON p.cod_cliente = c.cod
            INNER JOIN endereco e ON c.cod = e.cod_cliente
            WHERE p.cod_entregador = :cod 
              AND p.status = 'entregue'
            ORDER BY p.data_entrega DESC, p.hora_chegada DESC";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod", $codEntregador);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS PARA RELATÓRIOS ADMINISTRATIVOS ---

    public function obtenerMetricasFaturamento()
    {
        $sql = "SELECT 
                    SUM(valor_total) as faturamento_mes,
                    COUNT(cod) as total_pedidos
                FROM pedido 
                WHERE MONTH(data) = MONTH(NOW()) AND YEAR(data) = YEAR(NOW())";

        $consulta = $this->conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function listarVendasRecentes($limite = 6)
    {
        $sql = "SELECT 
                    p.num, 
                    c.nome as cliente, 
                    p.data, 
                    p.valor_total as valor, 
                    IFNULL(pag.tipo, 'Não Informado') AS metodo 
                FROM pedido p
                INNER JOIN cliente c ON p.cod_cliente = c.cod
                LEFT JOIN pagamento pag ON p.cod_pagamento = pag.cod
                ORDER BY p.data DESC, p.hora DESC, p.cod DESC 
                LIMIT :limite";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":limite", (int) $limite, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
