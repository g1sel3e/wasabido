<?php
class ClienteDAO
{
    // Criamos uma propriedade privada para guardar a conexão na classe
    private $conexao;

    // O construtor roda automaticamente sempre que você der um "new ClienteDAO()"
    public function __construct()
    {
        // Carrega o arquivo e disponibiliza a variável global para o construtor
        require_once __DIR__ . "/../conexao.php";
        global $conexao;
        
        // Armazena a conexão na propriedade da classe
        $this->conexao = $conexao;
    }

    function inserir($cliente)
    {
        try {
            // INSERE CLIENTE
            $sql = "INSERT INTO cliente (nome, email, senha, tel, cpf, rg)
                    VALUES (:nome, :email, :senha, :tel, :cpf, :rg)";
            $stmt = $this->conexao->prepare($sql); // Agora usamos $this->conexao
            $stmt->bindValue(":nome", $cliente->getNome());
            $stmt->bindValue(":email", $cliente->getEmail());
            $stmt->bindValue(":senha", $cliente->getSenha());
            $stmt->bindValue(":tel", $cliente->getTel());
            $stmt->bindValue(":cpf", $cliente->getCpf());
            $stmt->bindValue(":rg", $cliente->getRg());
            $stmt->execute();

            $clienteId = $this->conexao->lastInsertId();

            // INSERE ENDEREÇO
            $sql2 = "INSERT INTO endereco (cep, rua, bairro, num, cidade, complemento, cod_cliente)
                     VALUES (:cep, :rua, :bairro, :num, :cidade, :complemento, :cod_cliente)";
            $stmt2 = $this->conexao->prepare($sql2);
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
        $sql = "SELECT email, tel, cpf, rg FROM cliente WHERE cod = :cod";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function listarClientes()
    {
        $sql = "SELECT * FROM cliente ORDER BY nome ASC";
        $consulta = $this->conexao->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function apagar($cod)
    {
        try {
            // Primeiro removemos o endereço (chave estrangeira)
            $sqlEndereco = "DELETE FROM endereco WHERE cod_cliente = :cod";
            $p1 = $this->conexao->prepare($sqlEndereco);
            $p1->bindValue(":cod", $cod);
            $p1->execute();

            // Depois removemos o cliente
            $sqlCliente = "DELETE FROM cliente WHERE cod = :cod";
            $p2 = $this->conexao->prepare($sqlCliente);
            $p2->bindValue(":cod", $cod);
            return $p2->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($cliente)
    {
        $sql = "UPDATE cliente SET 
                nome = :nome, 
                email = :email, 
                tel = :tel 
                WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":nome", $cliente->getNome());
        $consulta->bindValue(":email", $cliente->getEmail());
        $consulta->bindValue(":tel", $cliente->getTel());
        $consulta->bindValue(":cod", $cliente->getCod());

        return $consulta->execute();
    }

    public function emailExisteGlobal($email)
    {
        // Correção aplicada: Removido o segundo UNION duplicado que quebraria o banco
        $sql = "SELECT email FROM cliente WHERE email = :email
                UNION
                SELECT email FROM administrador WHERE email = :email
                UNION
                SELECT email FROM entregador WHERE email = :email
                LIMIT 1";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // ============================================================
    // BUSCAR ENDEREÇOS DO CLIENTE
    // ============================================================
    public function buscarEnderecosPorCliente($codCliente)
    {
        try {
            $sql = "SELECT cep, rua, bairro, num, cidade, complemento 
                    FROM endereco 
                    WHERE cod_cliente = :cod_cliente";

            $consulta = $this->conexao->prepare($sql);
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
        try {
            $cepLimpo = trim($id_endereco);

            $sql = "DELETE FROM endereco WHERE cep = :id";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(":id", $cepLimpo);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    // INSERIR APENAS ENDEREÇO
    public function inserirApenasEndereco($endereco, $codCliente)
    {
        try {
            $sql = "INSERT INTO endereco (cep, rua, bairro, num, cidade, complemento, cod_cliente)
                    VALUES (:cep, :rua, :bairro, :num, :cidade, :complemento, :cod_cliente)";
            $stmt = $this->conexao->prepare($sql);

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
