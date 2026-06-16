<?php

class AvaliacaoModel
{
    private $cod;
    private $nota;
    private $comentario;
    private $data;
    private $hora;
    private $codCliente;
    private $codEntregador;
    private $codAdministrador;
    private $codPedido;
    private $tipoAvaliacao;

    // --- GETTERS E SETTERS ---

    public function getCod() {
        return $this->cod;
    }

    public function setCod($cod) {
        $this->cod = $cod;
    }

    public function getNota() {
        return $this->nota;
    }

    public function setNota($nota) {
        // Validação simples para garantir que a nota fique entre 1 e 5
        if ($nota >= 1 && $nota <= 5) {
            $this->nota = $nota;
        } else {
            $this->nota = 5; // Padrão caso venha algo fora do escopo
        }
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function getCodCliente() {
        return $this->codCliente;
    }

    public function setCodCliente($codCliente) {
        $this->codCliente = $codCliente;
    }

    public function getCodEntregador() {
        return $this->codEntregador;
    }

    public function setCodEntregador($codEntregador) {
        $this->codEntregador = $codEntregador;
    }

    public function getCodAdministrador() {
        return $this->codAdministrador;
    }

    public function setCodAdministrador($codAdministrador) {
        $this->codAdministrador = $codAdministrador;
    }

    public function getCodPedido() {
        return $this->codPedido;
    }

    public function setCodPedido($codPedido) {
        $this->codPedido = $codPedido;
    }

    public function getTipoAvaliacao() {
        return $this->tipoAvaliacao;
    }

    public function setTipoAvaliacao($tipoAvaliacao) {
        // Valida se o tipo enviado é um dos aceitos pelo ENUM do banco
        $tiposValidos = ['sistema', 'comida', 'entrega', 'entregador'];
        if (in_array($tipoAvaliacao, $tiposValidos)) {
            $this->tipoAvaliacao = $tipoAvaliacao;
        }
    }
}