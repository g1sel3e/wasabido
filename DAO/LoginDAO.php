<?php
class LoginDAO {

    function logar($email, $senha) {
        // require_once impede que o arquivo de conexão seja reinvocado se já estiver na memória
        require_once __DIR__ . "/../conexao.php";

        // ================= ADMIN =================
        $sql = "SELECT * FROM administrador WHERE email = :email AND senha = :senha";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':senha' => $senha
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user['tipo'] = 'admin';
            return $user;
        }

        // ================= CLIENTE =================
        $sql = "SELECT * FROM cliente WHERE email = :email AND senha = :senha";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':senha' => $senha
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user['tipo'] = 'cliente';
            return $user;
        }

        // ================= ENTREGADOR =================
        $sql = "SELECT * FROM entregador 
                WHERE email = :email 
                AND senha = :senha 
                AND status = 'aprovado'";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':senha' => $senha
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user['tipo'] = 'entregador';
            return $user;
        }

        return false;
    }
}
?>
