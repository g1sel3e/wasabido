<?php

class Entregador
{

    private $cod;
    private $nome;
    private $email;
    private $senha;
    private $tel;
    private $rg;
    private $cpf;
    private $veiculo;
    private $placa;
    private $status;

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // COD
    public function getCod()
    {
        return $this->cod;
    }

    public function setCod($value)
    {
        $this->cod = $value;
    }
    public function getRg()
    {
        return $this->rg;
    }

    public function setRg($value)
    {
        $this->rg = $value;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($value)
    {
        $this->cpf = $value;
    }


    // NOME
    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($value)
    {
        $this->nome = $value;
    }

    // EMAIL
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    // SENHA
    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($value)
    {
        $this->senha = $value;
    }

    // TELEFONE
    public function getTel()
    {
        return $this->tel;
    }

    public function setTel($value)
    {
        $this->tel = $value;
    }

    // VEICULO
    public function getVeiculo()
    {
        return $this->veiculo;
    }

    public function setVeiculo($value)
    {
        $this->veiculo = $value;
    }

    // PLACA
    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($value)
    {
        $this->placa = $value;
    }
}
?>