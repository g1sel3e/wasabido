<?php
require "../MODEL/ProdutoModel.php";
require "../DAO/ProdutoDAO.php";
require "../receberImagem.php"; // ✅ IMPORTANTE

$produto = new Produto();
$dao = new ProdutoDAO();
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

        // ✅ Upload das 4 fotos
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
        $produto->setCategoria($categoria); // Adicione isso
        $produto->setDescricao($descricao); // Adicione isso

        // Fotos
        $produto->setFoto1(receberImagem("foto1"));
        $produto->setFoto2(receberImagem("foto2"));
        $produto->setFoto3(receberImagem("foto3"));
        $produto->setFoto4(receberImagem("foto4"));

        if ($dao->atualizar($produto)) {
            header("Location: ../VIEW/adm/produtos.php?edit=1"); // Verifique se o caminho está certo
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
        echo "Ação não reconhecida!";
        break;
}