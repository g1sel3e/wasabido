<?php
class ClienteDAO
{
    function inserir($cliente)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        try {
            // INSERE CLIENTE
            $sql = "INSERT INTO cliente (nome, email, senha, tel, cpf, rg)
                    VALUES (:nome, :email, :senha, :tel, :cpf, :rg)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":nome", $cliente->getNome());
            $stmt->bindValue(":email", $cliente->getEmail());
            $stmt->bindValue(":senha", $cliente->getSenha());
            $stmt->bindValue(":tel", $cliente->getTel());
            $stmt->bindValue(":cpf", $cliente->getCpf());
            $stmt->bindValue(":rg", $cliente->getRg());
            $stmt->execute();

            $clienteId = $conexao->lastInsertId();

            // INSERE ENDEREÇO
            $sql2 = "INSERT INTO endereco (cep, rua, bairro, num, cidade, complemento, cod_cliente)
                     VALUES (:cep, :rua, :bairro, :num, :cidade, :complemento, :cod_cliente)";
            $stmt2 = $conexao->prepare($sql2);
            $stmt2->bindValue(":cep", $cliente->getEndereco()->getCep());
            $stmt2->bindValue(":rua", $cliente->getEndereco()->getRua());
            $stmt2->bindValue(":bairro", $cliente->getEndereco()->getBairro());
            $stmt2->bindValue(":num", $cliente->getEndereco()->getNum());
            $stmt2->bindValue(":cidade", $cliente->getEndereco()->getCidade());
            $stmt2->bindValue(":complemento", $cliente->getEndereco()->getComplemento());
            $stmt2->bindValue(":cod_cliente", $clienteId);
            $stmt2->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
            return false;
        }
    }

    // ============================================================
    // BUSCAR POR ID (PERFIL)
    // ============================================================
    function buscarPorId($cod)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";

        $sql = "SELECT email, tel, cpf, rg FROM cliente WHERE cod = :cod";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function listarClientes()
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        $sql = "SELECT * FROM cliente ORDER BY nome ASC";
        $consulta = $conexao->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function apagar($cod)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        try {
            // Primeiro removemos o endereço (chave estrangeira)
            $sqlEndereco = "DELETE FROM endereco WHERE cod_cliente = :cod";
            $p1 = $conexao->prepare($sqlEndereco);
            $p1->bindValue(":cod", $cod);
            $p1->execute();

            // Depois removemos o cliente
            $sqlCliente = "DELETE FROM cliente WHERE cod = :cod";
            $p2 = $conexao->prepare($sqlCliente);
            $p2->bindValue(":cod", $cod);
            return $p2->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($cliente)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        $sql = "UPDATE cliente SET 
                nome = :nome, 
                email = :email, 
                tel = :tel 
                WHERE cod = :cod";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":nome", $cliente->getNome());
        $consulta->bindValue(":email", $cliente->getEmail());
        $consulta->bindValue(":tel", $cliente->getTel());
        $consulta->bindValue(":cod", $cliente->getCod());

        return $consulta->execute();
    }

    public function emailExisteGlobal($email)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        $sql = "SELECT email FROM cliente WHERE email = :email
                UNION
                SELECT email FROM administrador WHERE email = :email
                UNION
                SELECT email FROM entregador WHERE email = :email
                LIMIT 1";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // ============================================================
    // BUSCAR ENDEREÇOS DO CLIENTE (CORRIGIDO: Colunas exatas)
    // ============================================================
    public function buscarEnderecosPorCliente($codCliente)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        try {
            $sql = "SELECT cep, rua, bairro, num, cidade, complemento 
                    FROM endereco 
                    WHERE cod_cliente = :cod_cliente";

            $consulta = $conexao->prepare($sql);
            $consulta->bindValue(":cod_cliente", $codCliente);
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // ============================================================
    // APAGAR APENAS UM ENDEREÇO ESPECÍFICO
    // ============================================================
    public function apagarEnderecoIndividual($id_endereco)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        try {
            $cepLimpo = trim($id_endereco);

            $sql = "DELETE FROM endereco WHERE cep = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":id", $cepLimpo);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // INSERIR APENAS ENDEREÇO
    public function inserirApenasEndereco($endereco, $codCliente)
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/wasabido/conexao.php";
        try {
            $sql = "INSERT INTO endereco (cep, rua, bairro, num, cidade, complemento, cod_cliente)
                    VALUES (:cep, :rua, :bairro, :num, :cidade, :complemento, :cod_cliente)";
            $stmt = $conexao->prepare($sql);

            $stmt->bindValue(":cep", method_exists($endereco, 'getCep') ? $endereco->getCep() : ($endereco->cep ?? $_POST['cep']));
            $stmt->bindValue(":rua", method_exists($endereco, 'getRua') ? $endereco->getRua() : ($endereco->rua ?? $_POST['rua']));
            $stmt->bindValue(":bairro", method_exists($endereco, 'getBairro') ? $endereco->getBairro() : ($endereco->bairro ?? $_POST['bairro']));
            $stmt->bindValue(":num", method_exists($endereco, 'getNum') ? $endereco->getNum() : ($endereco->num ?? $_POST['num']));
            $stmt->bindValue(":cidade", method_exists($endereco, 'getCidade') ? $endereco->getCidade() : ($endereco->cidade ?? $_POST['cidade']));
            $stmt->bindValue(":complemento", method_exists($endereco, 'getComplemento') ? $endereco->getComplemento() : ($endereco->complemento ?? $_POST['complemento']));
            $stmt->bindValue(":cod_cliente", $codCliente);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>