<?php
class ProdutoDAO
{

    // CREATE
    function inserir($produto)
    {
        // require_once impede que o arquivo de conexão seja reinvocado se já estiver na memória
        require_once __DIR__ . "/../conexao.php";

        $sql = "INSERT INTO produto 
    (nome, preco, foto1, foto2, foto3, foto4, categoria, descricao) 
    VALUES 
    (:nome, :preco, :foto1, :foto2, :foto3, :foto4, :categoria, :descricao)";

        $consulta = $conexao->prepare($sql);

        $consulta->bindValue(":nome", $produto->getNome());
        $consulta->bindValue(":preco", $produto->getPreco());
        $consulta->bindValue(":foto1", $produto->getFoto1());
        $consulta->bindValue(":foto2", $produto->getFoto2());
        $consulta->bindValue(":foto3", $produto->getFoto3());
        $consulta->bindValue(":foto4", $produto->getFoto4());
        $consulta->bindValue(":categoria", $produto->getCategoria());
        $consulta->bindValue(":descricao", $produto->getDescricao());

        return $consulta->execute();
    }

    // READ
    function listar()
    {
        require_once __DIR__ . "/../conexao.php";

        $sql = "SELECT * FROM produto";
        $consulta = $conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // CORRIGIDO: Agora busca 'foto1' e joga na chave 'imagem' que a sua View espera receber
    public function listarTodos()
    {
        require_once __DIR__ . "/../conexao.php";

        // Usamos "foto1 AS imagem" para mapear a coluna certa do seu banco
        $sql = "SELECT cod, nome, foto1 AS imagem FROM produto ORDER BY nome ASC";

        $consulta = $conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    function atualizar($produto)
    {
        require_once __DIR__ . "/../conexao.php";

        // Adicionei categoria e descricao aqui
        $sql = "UPDATE produto SET nome = :nome, preco = :preco, categoria = :categoria, descricao = :descricao";

        // Fotos dinâmicas
        if ($produto->getFoto1() != "") {
            $sql .= ", foto1 = :foto1";
        }
        if ($produto->getFoto2() != "") {
            $sql .= ", foto2 = :foto2";
        }
        if ($produto->getFoto3() != "") {
            $sql .= ", foto3 = :foto3";
        }
        if ($produto->getFoto4() != "") {
            $sql .= ", foto4 = :foto4";
        }

        $sql .= " WHERE cod = :cod";

        $consulta = $conexao->prepare($sql);

        $consulta->bindValue(":cod", $produto->getCod());
        $consulta->bindValue(":nome", $produto->getNome());
        $consulta->bindValue(":preco", $produto->getPreco());
        $consulta->bindValue(":categoria", $produto->getCategoria()); // Faltava este
        $consulta->bindValue(":descricao", $produto->getDescricao()); // Faltava este

        // Binds das fotos
        if ($produto->getFoto1() != "") {
            $consulta->bindValue(":foto1", $produto->getFoto1());
        }
        if ($produto->getFoto2() != "") {
            $consulta->bindValue(":foto2", $produto->getFoto2());
        }
        if ($produto->getFoto3() != "") {
            $consulta->bindValue(":foto3", $produto->getFoto3());
        }
        if ($produto->getFoto4() != "") {
            $consulta->bindValue(":foto4", $produto->getFoto4());
        }

        return $consulta->execute();
    }

    // DELETE
    function apagar($cod)
    {
        require_once __DIR__ . "/../conexao.php";

        try {
            $sql = "DELETE FROM produto WHERE cod = :cod";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":cod", $cod);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {

            if ($e->getCode() == "23000") {
                return false;
            }

            throw $e;
        }
    }
}
?>
