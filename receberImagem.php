<?php

function receberImagem($campo)
{
    if (!empty($_FILES[$campo]['name'])) {

        $tiposPermitidos = ["png", "jpeg", "jpg", "gif", "webp"]; // Adicionado webp por garantia

        $nome = $_FILES[$campo]['name'];
        $tmp  = $_FILES[$campo]['tmp_name'];
        $size = $_FILES[$campo]['size'];

        $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));

        // Valida extensão
        if (!in_array($extensao, $tiposPermitidos)) {
            return "";
        }

        // Valida tamanho (2MB)
        if ($size > 2 * 1024 * 1024) {
            return "";
        }

        // Nome único para evitar arquivos duplicados substituindo uns aos outros
        $novoNome = "produto_" . uniqid() . "." . $extensao;

        // 🔥 CORREÇÃO AQUI: Sobe um nível para sair de CONTROLLER, entra em VIEW e depois em produtos
        $pasta = __DIR__ . "/../VIEW/produtos/";

        // Cria a pasta 'produtos' automaticamente caso ela não exista no servidor
        if (!file_exists($pasta)) {
            mkdir($pasta, 0777, true);
        }

        // Move o arquivo para a pasta final
        if (move_uploaded_file($tmp, $pasta . $novoNome)) {
            return $novoNome; // Retorna o nome gerado para você salvar no Banco de Dados
        } else {
            return "";
        }
    }

    return "";
}
