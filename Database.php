<?php
// Database.php

class Database {
    
    // Atributos (variáveis) para guardar as credenciais
    // Usamos 'private' para proteger esses dados, ninguém de fora pode vê-los
    private $host = 'localhost';
    private $dbname = 'meu_portfolio';
    private $username = 'root';
    private $password = '';
    
    // Método (função) que FAZ a conexão
    // 'public' significa que qualquer um pode chamar esse método
    public function conectar() {
        
        try {
            // Criamos a conexão USANDO os atributos da classe (com $this->)
            $pdo = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8", 
                $this->username, 
                $this->password
            );
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Entregamos (retornamos) a conexão pronta
            return $pdo;

        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}
?>