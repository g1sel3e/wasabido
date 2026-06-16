<?php
class EntregadorDAO
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
            die("Erro crítico: O arquivo de conexão não retornou uma instância válida do PDO no EntregadorDAO.");
        }
    }

    // ============================================================
    // CREATE - INSERIR
    // ============================================================
    function inserir($entregador)
    {
        try {
            $sql = "INSERT INTO entregador 
            (nome, email, senha, tel, cpf, rg, veiculo, placa)
            VALUES (:nome, :email, :senha, :tel, :cpf, :rg, :veiculo, :placa)";

            $consulta = $this->conexao->prepare($sql);

            $consulta->bindValue(":nome", $entregador->getNome());
            $consulta->bindValue(":email", $entregador->getEmail());
            $consulta->bindValue(":senha", $entregador->getSenha());
            $consulta->bindValue(":tel", $entregador->getTel());
            $consulta->bindValue(":cpf", $entregador->getCpf());
            $consulta->bindValue(":rg", $entregador->getRg());
            $consulta->bindValue(":veiculo", $entregador->getVeiculo());
            $consulta->bindValue(":placa", $entregador->getPlaca());

            return $consulta->execute();

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage(); // debug
            return false;
        }
    }

    // ============================================================
    // READ - LISTAR
    // ============================================================
    function listar()
    {
        $sql = "SELECT * FROM entregador ORDER BY nome";
        $consulta = $this->conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // BUSCAR POR ID (PERFIL)
    // ============================================================
    function buscarPorId($cod)
    {
        $sql = "SELECT email, tel, cpf, rg, veiculo, placa FROM entregador WHERE cod = :cod";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public function listarAprovados()
    {
        $sql = "SELECT * FROM entregador WHERE status = 'aprovado'";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // UPDATE
    // ============================================================
    function atualizar($entregador)
    {
        $sql = "UPDATE entregador 
                SET nome = :nome,
                    email = :email,
                    senha = :senha,
                    tel = :tel,
                    veiculo = :veiculo,
                    placa = :placa
                WHERE cod = :cod";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod", $entregador->getCod());
        $consulta->bindValue(":nome", $entregador->getNome());
        $consulta->bindValue(":email", $entregador->getEmail());
        $consulta->bindValue(":senha", $entregador->getSenha());
        $consulta->bindValue(":tel", $entregador->getTel());
        $consulta->bindValue(":veiculo", $entregador->getVeiculo());
        $consulta->bindValue(":placa", $entregador->getPlaca());

        return $consulta->execute();
    }

    function listarPendentes()
    {
        $sql = "SELECT * FROM entregador WHERE status = 'pendente'";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function atualizarStatus($cod, $status)
    {
        $sql = "UPDATE entregador SET status = :status WHERE cod = :cod";
        $stmt = $this->conexao->prepare($sql);

        $stmt->bindValue(":status", $status);
        $stmt->bindValue(":cod", $cod);

        return $stmt->execute();
    }

    // ============================================================
    // DELETE
    // ============================================================
    function apagar($cod)
    {
        try {
            $sql = "DELETE FROM entregador WHERE cod = :cod";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":cod", $cod);
            $consulta->execute();

            return true;

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "FK";
            }

            return false;
        }
    }

    // ============================================================
    // LOGIN
    // ============================================================
    function logar($email, $senha)
    {
        $sql = "SELECT * FROM entregador 
                WHERE email = :email AND senha = :senha";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":email", $email);
        $consulta->bindValue(":senha", $senha);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // BUSCAR
    // ============================================================
    function buscar($pesquisa)
    {
        $sql = "SELECT * FROM entregador 
                WHERE nome LIKE :pesquisa";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":pesquisa", "%" . $pesquisa . "%");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
