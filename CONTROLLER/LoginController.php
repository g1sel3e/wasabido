<?php
// 1. Sempre inicie a sessão no topo do arquivo antes de qualquer output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Verifica se o arquivo DAO realmente existe para evitar erro fatal silencioso
$daoPath = "../DAO/LoginDAO.php";
if (file_exists($daoPath)) {
    require_once $daoPath;
} else {
    die("Erro crítico: O arquivo LoginDAO.php não foi encontrado no caminho especificado.");
}

$dao = new LoginDAO();

// Captura a ação tanto de POST quanto de GET
$acao = $_POST['acao'] ?? $_GET['acao'] ?? "";
$email = $_POST['email'] ?? "";
$senha = $_POST['senha'] ?? "";

switch ($acao) {

    case "Logar":
        $resultado = $dao->logar($email, $senha);

        if ($resultado != false) {
            // Sessão já foi iniciada no topo, basta preencher os dados
            $_SESSION['cod'] = $resultado['cod'];
            $_SESSION['nome'] = $resultado['nome'];
            $_SESSION['tipo'] = $resultado['tipo'];

            if (isset($resultado['status'])) {
                $_SESSION['status'] = $resultado['status'];
            }

            // Redirecionamento baseado no tipo de usuário
            if ($resultado['tipo'] == "admin") {
                header("Location: ../VIEW/adm/adm.php");
            } elseif ($resultado['tipo'] == "cliente") {
                header("Location: ../VIEW/cliente/cliente.php");
            } elseif ($resultado['tipo'] == "entregador") {
                header("Location: ../VIEW/entregador/entregador.php");
            } else {
                // Caso o tipo seja desconhecido
                header("Location: ../VIEW/login.php?erro=tipo_invalido");
            }
            exit();
        }

        // Se o login falhar
        header("Location: ../VIEW/login.php?erro=login");
        exit();
        break;

    case "Logout":
        // Limpa todas as variáveis da sessão
        $_SESSION = array();

        // Destrói os cookies de sessão no navegador
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destrói a sessão no servidor
        session_destroy();

        // Redireciona de volta para a tela de login inicial
        header("Location: ../index.php");
        exit();
        break;

    default:
        // Se alguém acessar o controlador diretamente sem uma ação válida, manda de volta para o login
        header("Location: ../VIEW/login.php");
        exit();
        break;
}
?>