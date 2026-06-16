<?php
// Ativa a exibição de erros caso precise monitorar uploads falhos ou tipos de arquivo inválidos
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusões robustas utilizando caminhos absolutos baseados no diretório do controller
require_once __DIR__ . "/../MODEL/ProdutoModel.php";
require_once __DIR__ . "/../DAO/ProdutoDAO.php";
require_once __DIR__ . "/../receberImagem.php"; // ✅ Importação corrigida com __DIR__

$produto = new Produto();
$dao = new ProdutoDAO();

// Captura a ação tanto de POST (formulários) quanto de GET (links de exclusão)
$acao = $_REQUEST['acao'] ?? "";
$cod = $_REQUEST['cod'] ?? "";

$nome = $_POST['nome'] ?? "";
$preco = $_POST['preco'] ?? "";
$categoria = $_POST['categoria'] ?? "";
$descricao = $_POST['descricao'] ?? "";

switch ($acao) {

    // ======================================================
    // ✅ INSERIR PRODUTO
    // ======================================================
    case "Inserir":

        $produto->setNome($nome);
        $produto->setPreco($preco);
        $produto->setDescricao($descricao);
        $produto->setCategoria($categoria);

        // Upload das 4 fotos usando o script utilitário importado
        $produto->setFoto1(receberImagem("foto1"));
        $produto->setFoto2(receberImagem("foto2"));
        $produto->setFoto3(receberImagem("foto3"));
        $produto->setFoto4(receberImagem("foto4"));

        if ($dao->inserir($produto)) {
            header("Location: ../VIEW/adm/cadastroP.php?ok=1");
        } else {
            header("Location: ../VIEW/adm/cadastroP.php?erro=1");
        }
        break;

    // ======================================================
    // ✅ ATUALIZAR PRODUTO
    // ======================================================
    case "Atualizar":
        $produto->setCod($cod);
        $produto->setNome($nome);
        $produto->setPreco($preco);
        $produto->setCategoria($categoria);
        $produto->setDescricao($descricao);

        // Upload/Atualização das fotos
        $produto->setFoto1(receberImagem("foto1"));
        $produto->setFoto2(receberImagem("foto2"));
        $produto->setFoto3(receberImagem("foto3"));
        $produto->setFoto4(receberImagem("foto4"));

        if ($dao->atualizar($produto)) {
            header("Location: ../VIEW/adm/produtos.php?edit=1");
        } else {
            header("Location: ../VIEW/adm/produtos.php?erro=3");
        }
        break;

    // ======================================================
    // ✅ APAGAR PRODUTO
    // ======================================================
    case "Apagar":

        if ($dao->apagar($cod)) {
            header("Location: ../VIEW/adm/produtos.php?ok=3");
        } else {
            header("Location: ../VIEW/adm/produtos.php?erro=2");
        }
        break;

    // ======================================================
    // ❌ AÇÃO INVÁLIDA
    // ======================================================
    default:
        echo "Ação não reconhecida: " . htmlspecialchars($acao);
        break;
}
?>
