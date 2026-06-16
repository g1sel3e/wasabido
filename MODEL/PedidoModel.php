<?php

class Pedido
{

    private $num;
    private $valor_total;
    private $status;
    private $data;
    private $hora;
    private $cod_entregador;
    private $cod_administrador;
    private $cod_cliente;
    private $cod_pagamento;
    private $cod_endereco;
    private $cod;

    // GETTERS E SETTERS

    public function getNum()
    {
        return $this->num;
    }

    public function setNum($num)
    {
        $this->num = $num;
    }

    public function getValorTotal()
    {
        return $this->valor_total;
    }

    public function setValorTotal($valor)
    {
        $this->valor_total = $valor;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function getCodEntregador()
    {
        return $this->cod_entregador;
    }

    public function setCodEntregador($cod)
    {
        $this->cod_entregador = $cod;
    }

    public function getCodAdministrador()
    {
        return $this->cod_administrador;
    }

    public function setCodAdministrador($cod)
    {
        $this->cod_administrador = $cod;
    }

    public function getCodCliente()
    {
        return $this->cod_cliente;
    }

    public function setCodCliente($cod)
    {
        $this->cod_cliente = $cod;
    }

    public function getCodPagamento()
    {
        return $this->cod_pagamento;
    }

    public function setCodPagamento($cod)
    {
        $this->cod_pagamento = $cod;
    }

    public function getCodEndereco()
    {
        return $this->cod_endereco;
    }

    public function setCodEndereco($cod)
    {
        $this->cod_endereco = $cod;
    }

    public function getCod()
    {
        return $this->cod;
    }

    public function setCod($cod)
    {
        $this->cod = $cod;
    }
}