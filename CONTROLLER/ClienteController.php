<?php
// CORREÇÃO UNIVERSAL DE CAMINHOS USANDO __DIR__
require_once __DIR__ . "/../MODEL/ClienteModel.php";
require_once __DIR__ . "/../MODEL/enderecoModel.php";
require_once __DIR__ . "/../DAO/ClienteDAO.php";

// Garante que as classes existam antes de instanciá-las
if (!class_exists('Cliente')) { class Cliente {} }
if (!class_exists('Endereco')) { class Endereco {} }

$cliente = new Cliente();
$endereco = new Endereco();
$dao = new ClienteDAO();

// Captura a ação tanto por POST (formulários) quanto por GET (links de exclusão)
$acao = $_POST['acao'] ?? $_GET['acao'] ?? "";

// Dados básicos do Cliente
$cod = $_POST['cod'] ?? $_GET['cod'] ?? $_POST['id_cliente'] ?? ""; // Adicionado o 'id_cliente' vindo do form de endereço
$nome = $_POST['nome'] ?? "";
$email = $_POST['email'] ?? "";
$senha = $_POST['senha'] ?? "";
$tel = $_POST['tel'] ?? "";
$cpf = $_POST['cpf'] ?? "";
$rg = $_POST['rg'] ?? "";

// Dados de Endereço (usados no Inserir e InserirEndereco)
$id_endereco = $_GET['id'] ?? ""; // Captura o ID do endereço para exclusão individual
$cep = $_POST['cep'] ?? "";
$rua = $_POST['rua'] ?? "";
$bairro = $_POST['bairro'] ?? "";
$num = $_POST['num'] ?? "";
$cidade = $_POST['cidade'] ?? "";
$complemento = $_POST['complemento'] ?? "";

// ============================================================
// NOVO: FUNÇÃO PARA A VIEW BUSCAR OS ENDEREÇOS DO CLIENTE
// ============================================================
function listarEnderecosDoCliente($codCliente)
{
    $dao = new ClienteDAO();
    return $dao->buscarEnderecosPorCliente($codCliente);
}

// CORREÇÃO: O switch só roda se uma ação real for disparada!
if (!empty($acao)) {
    switch ($acao) {

        case "Inserir":
            if ($dao->emailExisteGlobal($email)) {
                header("Location: ../VIEW/cliente/cadastroC.php?erro=email");
                exit;
            }

            $cliente->setNome($nome);
            $cliente->setEmail($email);
            $cliente->setSenha($senha);
            $cliente->setTel($tel);
            $cliente->setCpf($cpf);
            $cliente->setRg($rg);

            $endereco->setCep($cep);
            $endereco->setRua($rua);
            $endereco->setBairro($bairro);
            $endereco->setNum($num);
            $endereco->Cidade($cidade);
            $endereco->setComplemento($complemento);

            $cliente->setEndereco($endereco);

            if ($dao->inserir($cliente)) {
                header("Location: ../VIEW/login.php?sucesso=cliente");
                exit;
            } else {
                header("Location: ../VIEW/cliente/cadastroC.php?erro=1");
                exit;
            }
            break;

        // ============================================================
        // NOVO CASE: INSERIR APENAS UM NOVO ENDEREÇO (PÁGINA DE ENDEREÇOS)
        // ============================================================
        case "InserirEndereco":
            $endereco->setCep($cep);
            $endereco->setRua($rua);
            $endereco->setBairro($bairro);
            $endereco->setNum($num);
            $endereco->setCidade($cidade);
            $endereco->setComplemento($complemento);

            // CORREÇÃO DA ROTA DE RETORNO: Voltando uma pasta a partir da CONTROLLER para achar a VIEW
            if ($dao->inserirApenasEndereco($endereco, $cod)) {
                header("Location: ../VIEW/cliente/endereco.php?sucesso=1");
                exit;
            } else {
                header("Location: ../VIEW/cliente/endereco.php?erro=1");
                exit;
            }
            break;

        // ============================================================
        // NOVO CASE: APAGAR APENAS UM ENDEREÇO ESPECÍFICO (CORRIGIDO COM EXIT)
        // ============================================================
        case "ExcluirEndereco":
            if ($dao->apagarEnderecoIndividual($id_endereco)) {
                header("Location: ../VIEW/cliente/endereco.php?sucesso=delete");
                exit;
            } else {
                header("Location: ../VIEW/cliente/endereco.php?erro=delete");
                exit;
            }
            break;

        case "Atualizar":
            $cliente->setCod($cod);
            $cliente->setNome($nome);
            $cliente->setEmail($email);
            $cliente->setTel($tel);

            if ($dao->atualizar($cliente)) {
                header("Location: ../VIEW/adm/listadoE.php?ok=1");
                exit;
            } else {
                header("Location: ../VIEW/adm/listadoE.php?erro=1");
                exit;
            }
            break;

        case "Apagar":
            if ($dao->apagar($cod)) {
                header("Location: ../VIEW/adm/listadoE.php?ok=1");
                exit;
            } else {
                header("Location: ../VIEW/adm/listadoE.php?erro=fk");
                exit;
            }
            break;

        default:
            echo "Ação não reconhecida";
            break;
    }
}
?>
