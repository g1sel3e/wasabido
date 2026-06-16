<?php
// Usando caminhos absolutos baseados no diretório atual para evitar falhas de inclusão
require_once __DIR__ . "/../MODEL/EntregadorModel.php";
require_once __DIR__ . "/../DAO/EntregadorDAO.php";

$entregador = new Entregador();
$dao = new EntregadorDAO();

// $_REQUEST captura a ação de forma limpa, seja vinda de POST (formulários) ou GET (links)
$acao = $_REQUEST['acao'] ?? "";

$nome    = $_POST['nome'] ?? "";
$email   = $_POST['email'] ?? "";
$senha   = $_POST['senha'] ?? "";
$tel     = $_POST['tel'] ?? "";
$cpf     = $_POST['cpf'] ?? "";
$rg      = $_POST['rg'] ?? "";
$veiculo = $_POST['veiculo'] ?? "";
$placa   = $_POST['placa'] ?? "";

switch ($acao) {

    case "Inserir":
        $entregador->setNome($nome);
        $entregador->setEmail($email);
        $entregador->setSenha($senha);
        $entregador->setTel($tel);
        $entregador->setCpf($cpf);
        $entregador->setRg($rg);
        $entregador->setVeiculo($veiculo);
        $entregador->setPlaca($placa);

        // MODIFICADO: Agora redireciona para a tela de análise em caso de sucesso
        if ($dao->inserir($entregador)) {
            header("Location: ../VIEW/entregador/aguardandoAprovacao.php");
        } else {
            header("Location: ../VIEW/entregador/cadastroE.php?erro=1");
        }
        break;

    case "AtualizarStatus":
        $id     = $_POST['cod'] ?? "";
        $status = $_POST['status'] ?? "";

        if (!empty($id) && !empty($status)) {
            $dao->atualizarStatus($id, $status);
        }

        header("Location: ../VIEW/adm/confirmacao.php");
        break;

    // NOVO CASE PARA APAGAR
    case "Apagar":
        $id = $_GET['cod'] ?? ""; // Captura o código vindo do link (via GET)

        if (!empty($id)) {
            $resultado = $dao->apagar($id);

            if ($resultado === true) {
                header("Location: ../VIEW/adm/listadoE.php?ok=1");
            } elseif ($resultado === "FK") {
                // Erro de integridade (tem pedidos vinculados)
                header("Location: ../VIEW/adm/listadoE.php?erro=fk");
            } else {
                header("Location: ../VIEW/adm/listadoE.php?erro=1");
            }
        }
        break;

    case "Atualizar":
        $id = $_POST['cod'] ?? "";
        $entregador->setCod($id);
        $entregador->setNome($nome);
        $entregador->setEmail($email);
        $entregador->setSenha($senha);
        $entregador->setTel($tel);
        $entregador->setVeiculo($veiculo);
        $entregador->setPlaca($placa);

        if ($dao->atualizar($entregador)) {
            header("Location: ../VIEW/adm/listadoE.php?ok=2"); // ok=2 para "Atualizado"
        } else {
            header("Location: ../VIEW/adm/listadoE.php?erro=2");
        }
        break;

    default:
        echo "Ação não reconhecida";
        exit;
}
?>
