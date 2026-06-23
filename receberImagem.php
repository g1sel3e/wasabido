<?php

function receberImagem($campo)
{
    if (!empty($_FILES[$campo]['name'])) {

        $tiposPermitidos = ["png", "jpeg", "jpg", "gif"];

        $nome = $_FILES[$campo]['name'];
        $tmp  = $_FILES[$campo]['tmp_name'];
        $size = $_FILES[$campo]['size'];

        $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));

        // valida extensão
        if (!in_array($extensao, $tiposPermitidos)) {
            return "";
        }

        // valida tamanho (2MB)
        if ($size > 2 * 1024 * 1024) {
            return "";
        }

        // nome único
        $novoNome = "produto_" . uniqid() . "." . $extensao;

        // 🚀 SOLUÇÃO RÁPIDA: Salva diretamente na mesma pasta onde está este script
        $pasta = __DIR__ . "/";

        // move arquivo
        if (move_uploaded_file($tmp, $pasta . $novoNome)) {
            return $novoNome; // Retorna apenas o nome do arquivo para salvar no banco
        } else {
            return "";
        }
    }

    return "";
}
