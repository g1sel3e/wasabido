<?php

class Contem
{
    private $cod;
    private $cod_pedido;
    private $cod_produto;
    private $quantidade;
    private $preco_unitario;
    private $subtotal;

    // GETTERS E SETTERS

    public function getCod()
    {
        return $this->cod;
    }

    public function setCod($cod)
    {
        $this->cod = $cod;
    }

    public function getCodPedido()
    {
        return $this->cod_pedido;
    }

    public function setCodPedido($cod_pedido)
    {
        $this->cod_pedido = $cod_pedido;
    }

    public function getCodProduto()
    {
        return $this->cod_produto;
    }

    public function setCodProduto($cod_produto)
    {
        $this->cod_produto = $cod_produto;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function getPrecoUnitario()
    {
        return $this->preco_unitario;
    }

    public function setPrecoUnitario($preco_unitario)
    {
        $this->preco_unitario = $preco_unitario;
    }

    public function getSubtotal()
    {
        return $this->subtotal;
    }

    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }
}
?>