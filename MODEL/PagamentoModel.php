<?php
class Pagamento {

    private $cod;
    private $tipo;
    private $status;

    // =========================
    // GETTERS
    // =========================

    public function getCod() {
        return $this->cod;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getStatus() {
        return $this->status;
    }

    // =========================
    // SETTERS
    // =========================

    public function setCod($cod) {
        $this->cod = $cod;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}
?>