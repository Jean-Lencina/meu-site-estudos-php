<?php
// Usuario.php

class Usuario {

    // 1. Atributos (Propriedades)
    // Todos 'private' para proteger os dados.
    private $nome;
    private $idade;
    private $empresa;
    private $cargoAtual;
    private $objetivo;
    private $cargoPretendido;

    // 2. O Construtor Mágico
    // Ele vai receber TODOS os dados quando o objeto for criado
    public function __construct($nome, $idade, $empresa, $cargoAtual, $objetivo, $cargoPretendido) {
        // '->' Atribui o dado recebido ($nome) ao atributo interno ($this->nome)
        $this->nome = $nome;
        $this->idade = $idade;
        $this->empresa = $empresa;
        $this->cargoAtual = $cargoAtual;
        $this->objetivo = $objetivo;
        $this->cargoPretendido = $cargoPretendido;
    }

    // 3. "Getters" (Métodos Públicos para LER os dados privados)
    // Não dá para ler $usuario->nome (porque é private),
    // mas dá para chamar $usuario->getNome() (porque é public).
    
    public function getNome() {
        return $this->nome;
    }
    
    public function getIdade() {
        return $this->idade;
    }
    
    public function getEmpresa() {
        return $this->empresa;
    }

    public function getCargoAtual() {
        return $this->cargoAtual;
    }

    public function getObjetivo() {
        return $this->objetivo;
    }
    
    public function getCargoPretendido() {
        return $this->cargoPretendido;
    }
}
?>