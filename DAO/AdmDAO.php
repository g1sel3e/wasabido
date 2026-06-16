<?php
class AdmDAO
{

    // ============================================================
    // CREATE - INSERIR
    // ============================================================
    function inserir($adm)
    {
        include __DIR__ . "/../conexao.php";

        try {

            $sql = "INSERT INTO administrador 
            (nome, email, senha, tel)
            VALUES (:nome, :email, :senha, :tel)";

            $consulta = $conexao->prepare($sql);

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
        include __DIR__ . "/../conexao.php";

        $sql = "SELECT email, tel FROM administrador WHERE cod = :cod";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod", $cod);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // READ - LISTAR
    // ============================================================
    function listar()
    {
        include __DIR__ . "/../conexao.php";

        $sql = "SELECT * FROM administrador ORDER BY nome";
        $consulta = $conexao->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // UPDATE
    // ============================================================
    function atualizar($adm)
    {
        include __DIR__ . "/../conexao.php";
        $sql = "UPDATE administrador SET nome = :nome, email = :email, senha = :senha, tel = :tel WHERE cod = :cod";
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":cod", $adm->getCod());
        $consulta->bindValue(":nome", $adm->getNome());
        $consulta->bindValue(":email", $adm->getEmail());
        $consulta->bindValue(":senha", $adm->getSenha());
        $consulta->bindValue(":tel", $adm->getTel()); // Ajustado de getTelefone para getTel
        return $consulta->execute();
    }

    // ============================================================
    // DELETE
    // ============================================================
    function apagar($cod)
    {
        include __DIR__ . "/../conexao.php";

        try {
            $sql = "DELETE FROM administrador WHERE cod = :cod";
            $consulta = $conexao->prepare($sql);
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
        include __DIR__ . "/../conexao.php";

        $sql = "SELECT * FROM administrador 
                WHERE email = :email AND senha = :senha";

        $consulta = $conexao->prepare($sql);
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
        include __DIR__ . "/../conexao.php";

        $sql = "SELECT * FROM administrador 
                WHERE nome LIKE :pesquisa";

        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":pesquisa", "%" . $pesquisa . "%");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>