<?php
class AdmDAO
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
            die("Erro crítico: O arquivo de conexão não retornou uma instância válida do PDO no AdmDAO.");
        }
    }

    // ============================================================
    // CREATE - INSERIR
    // ============================================================
    function inserir($adm)
    {
        try {
            $sql = "INSERT INTO administrador 
            (nome, email, senha, tel)
            VALUES (:nome, :email, :senha, :tel)";

            $consulta = $this->conexao->prepare($sql);

            $consulta->bindValue(":nome", $adm->getNome());
            $consulta->bindValue(":email", $adm->getEmail());
            $consulta->bindValue(":senha", $adm->getSenha());
            $consulta->bindValue(":tel", $adm->getTel());

            return $consulta->execute();

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    // ============================================================
    // BUSCAR POR ID (PERFIL)
    // ============================================================
    function buscarPorId($cod)
    {
        $sql = "SELECT email, tel FROM administrador WHERE cod = :cod";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // READ - LISTAR
    // ============================================================
    function listar()
    {
        $sql = "SELECT * FROM administrador ORDER BY nome";
        $consulta = $this->conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // UPDATE
    // ============================================================
    function atualizar($adm)
    {
        $sql = "UPDATE administrador SET nome = :nome, email = :email, senha = :senha, tel = :tel WHERE cod = :cod";
        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":cod", $adm->getCod());
        $consulta->bindValue(":nome", $adm->getNome());
        $consulta->bindValue(":email", $adm->getEmail());
        $consulta->bindValue(":senha", $adm->getSenha());
        $consulta->bindValue(":tel", $adm->getTel());
        
        return $consulta->execute();
    }

    // ============================================================
    // DELETE
    // ============================================================
    function apagar($cod)
    {
        try {
            $sql = "DELETE FROM administrador WHERE cod = :cod";
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
        $sql = "SELECT * FROM administrador 
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
        $sql = "SELECT * FROM administrador 
                WHERE nome LIKE :pesquisa";

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":pesquisa", "%" . $pesquisa . "%");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
