<?php
require_once __DIR__ . "/../verificacao.php";

class AvaliacaoDAO
{
    function salvarAvaliacao($dados)
    {
        // require_once impede que o arquivo de conexão seja reinvocado se já estiver na memória
        require_once __DIR__ . "/../conexao.php";

        // Adicionado 'cod_administrador' e ':cod_administrador' na Query
        $sql = "INSERT INTO avaliacao 
        (nota, comentario, tags, data, hora, cod_cliente, cod_entregador, cod_pedido, cod_produto, cod_administrador, tipo_avaliacao)
        VALUES (:nota, :comentario, :tags, :data, :hora, :cod_cliente, :cod_entregador, :cod_pedido, :cod_produto, :cod_administrador, :tipo_avaliacao)";

        $consulta = $conexao->prepare($sql);

        date_default_timezone_set('America/Sao_Paulo');

        $consulta->bindValue(":nota", $dados['nota']);
        $consulta->bindValue(":comentario", !empty($dados['comentario']) ? $dados['comentario'] : null);

        // Salvando as tags selecionadas (se houver)
        $consulta->bindValue(":tags", !empty($dados['tags']) ? $dados['tags'] : null);

        $consulta->bindValue(":data", date('Y-m-d'));
        $consulta->bindValue(":hora", date('H:i:s'));
        $consulta->bindValue(":tipo_avaliacao", $dados['tipo_avaliacao']);

        // REGRA DO ADMINISTRADOR: Se a avaliação veio do painel do Admin, grava o código dele, senão manda nulo
        $consulta->bindValue(":cod_administrador", !empty($dados['cod_administrador']) ? $dados['cod_administrador'] : null);

        // REGRA DO CLIENTE: Se for avaliação do tipo 'cliente' (vinda do entregador ou do admin), grava o código enviado
        $consulta->bindValue(":cod_cliente", !empty($dados['cod_cliente']) ? $dados['cod_cliente'] : null);

        // REGRA DO ENTREGADOR: Aceita o código se o tipo for 'entregador' (cliente/admin avaliando) 
        // OU se quem está avaliando é o próprio entregador ('cliente' ou 'estabelecimento')
        if (in_array($dados['tipo_avaliacao'], ['entregador', 'cliente', 'estabelecimento']) && !empty($dados['cod_entregador'])) {
            $cod_entregador = $dados['cod_entregador'];
        } else {
            $cod_entregador = null;
        }
        $consulta->bindValue(":cod_entregador", $cod_entregador);

        // Se o tipo for pedido, manda o código do pedido, senão manda nulo
        $cod_pedido = ($dados['tipo_avaliacao'] === 'pedido' && !empty($dados['cod_pedido'])) ? $dados['cod_pedido'] : null;
        $consulta->bindValue(":cod_pedido", $cod_pedido);

        // REGRA DO PRODUTO: Se o tipo for comida, manda o código do produto, senão manda nulo
        $cod_produto = ($dados['tipo_avaliacao'] === 'comida' && !empty($dados['cod_produto'])) ? $dados['cod_produto'] : null;
        $consulta->bindValue(":cod_produto", $cod_produto);

        return $consulta->execute();
    }

    function listarAvaliacoesEntregador($cod_entregador)
    {
        require_once __DIR__ . "/../conexao.php";

        // COALESCE escolhe o primeiro nome que não for nulo (Cliente ou ADM)
        // Fizemos LEFT JOIN com as duas tabelas para não sumir com avaliações se uma delas estiver vazia
        $sql = "SELECT a.*, 
                       COALESCE(c.nome, adm.nome, 'Sistema') AS nome_cliente, 
                       a.cod_pedido AS num_pedido, 
                       a.data AS data_avaliacao 
                FROM avaliacao a
                LEFT JOIN cliente c ON a.cod_cliente = c.cod
                LEFT JOIN administrador adm ON a.cod_administrador = adm.cod
                WHERE a.cod_entregador = :cod_entregador 
                  AND a.tipo_avaliacao = 'entregador' 
                ORDER BY a.data DESC, a.hora DESC";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod_entregador", $cod_entregador, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    function listarTodasComUsuarios()
    {
        require_once __DIR__ . "/../conexao.php";

        // Usamos LEFT JOIN nas 3 tabelas de usuários para trazer o nome correto de quem avaliou
        $sql = "SELECT 
                    a.nota, 
                    a.comentario, 
                    a.tipo_avaliacao,
                    c.nome AS nome_cliente,
                    e.nome AS nome_entregador,
                    adm.nome AS nome_admin
                FROM avaliacao a
                LEFT JOIN cliente c ON a.cod_cliente = c.cod
                LEFT JOIN entregador e ON a.cod_entregador = e.cod
                LEFT JOIN administrador adm ON a.cod_administrador = adm.cod
                ORDER BY a.cod DESC";

        $consulta = $conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
