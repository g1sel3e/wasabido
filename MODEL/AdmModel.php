<?php

class Adm {

    private $cod;
    private $nome;
    private $email;
    private $senha;
    private $tel;

    // GET COD
    public function getCod() {
        return $this->cod;
    }

    public function setCod($value) {
        $this->cod = $value;
    }

    // GET NOME
    public function getNome() {
        return $this->nome;
    }

    public function setNome($value) {
        $this->nome = $value;
    }

    // GET EMAIL
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    // GET SENHA
    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($value) {
        $this->senha = $value;
    }

    // GET TELEFONE
    public function getTel() {
        return $this->tel;
    }

    public function setTel($value) {
        $this->tel = $value;
    }
}