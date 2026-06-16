<?php
require "../MODEL/AdmModel.php";
require "../DAO/AdmDAO.php";

$adm = new Adm();
$dao = new AdmDAO();

// Usamos $_REQUEST para aceitar tanto POST (formulários) quanto GET (links de exclusão)
$acao = $_REQUEST['acao'] ?? "";

$cod   = $_REQUEST['cod'] ?? "";
$nome  = $_POST['nome'] ?? "";
$email = $_POST['email'] ?? "";
$senha = $_POST['senha'] ?? "";
$tel   = $_POST['tel'] ?? "";

switch ($acao) {

    // ============================================================
    // INSERIR
    // ============================================================
    case "Inserir":
        $adm->setNome($nome);
        $adm->setEmail($email);
        $adm->setSenha($senha);
        $adm->setTel($tel);

        if ($dao->inserir($adm)) {
            header("Location: ../VIEW/adm/listadoE.php?ok=1");
        } else {
            header("Location: ../VIEW/adm/cadastroAdm.php?erro=1");
        }
        break;

    // ============================================================
    // ATUALIZAR
    // ============================================================
    case "Atualizar":
        $adm->setCod($cod);
        $adm->setNome($nome);
        $adm->setEmail($email);
        $adm->setSenha($senha);
        $adm->setTel($tel);

        if ($dao->atualizar($adm)) {
            // Redireciona de volta para a sua tela de gestão
            header("Location: ../VIEW/adm/listadoE.php?ok=1");
        } else {
            header("Location: ../VIEW/adm/listadoE.php?erro=1");
        }
        break;

    // ============================================================
    // APAGAR
    // ============================================================
    case "Apagar":
        $resultado = $dao->apagar($cod);

        if ($resultado === true) {
            // Se apagou com sucesso, volta para a tela de usuários
            header("Location: ../VIEW/adm/listadoE.php?ok=1");
        } elseif ($resultado === "FK") {
            header("Location: ../VIEW/adm/listadoE.php?erro=fk");
        } else {
            header("Location: ../VIEW/adm/listadoE.php?erro=2");
        }
        break;

    // ============================================================
    // LOGIN
    // ============================================================
    case "Logar":
        $resultado = $dao->logar($email, $senha);

        if ($resultado != false) {
            session_start();
            $_SESSION['adm_id'] = $resultado['cod'];
            $_SESSION['adm_nome'] = $resultado['nome'];
            header("Location: ../VIEW/adm/painel.php"); // Ajustado para seu painel
        } else {
            header("Location: ../VIEW/login.php?erro=login");
        }
        break;

    default:
        echo "Ação não reconhecida: " . htmlspecialchars($acao);
        break;
}
?>