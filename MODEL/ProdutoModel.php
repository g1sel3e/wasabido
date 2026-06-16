<?php

class Produto
{

    private $cod;
    private $nome;
    private $preco;
    private $foto1;
    private $foto2;
    private $foto3;
    private $foto4;
    private $categoria;

    private $descricao;

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function getCod()
    {
        return $this->cod;
    }

    public function setCod($cod)
    {
        $this->cod = $cod;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function getFoto1()
    {
        return $this->foto1;
    }

    public function setFoto1($foto1)
    {
        $this->foto1 = $foto1;
    }

    public function getFoto2()
    {
        return $this->foto2;
    }

    public function setFoto2($foto2)
    {
        $this->foto2 = $foto2;
    }

    public function getFoto3()
    {
        return $this->foto3;
    }

    public function setFoto3($foto3)
    {
        $this->foto3 = $foto3;
    }

    public function getFoto4()
    {
        return $this->foto4;
    }

    public function setFoto4($foto4)
    {
        $this->foto4 = $foto4;
    }
}