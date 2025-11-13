<?php
// api_hobbies.php

// 1. Inclui o "molde" do Banco de Dados
include 'Database.php';

// 2. Conecta ao banco
$db = new Database();
$pdo = $db->conectar();

// 3. Prepara e executa a busca
try {
    $sql = "SELECT nome_hobbie FROM hobbies ORDER BY nome_hobbie ASC";
    $stmt = $pdo->query($sql);
    $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. A MÁGICA: Define o cabeçalho como JSON
    header('Content-Type: application/json');

    // 5. Imprime os dados no formato JSON
    echo json_encode($hobbies);

} catch (Exception $e) {
    // Em caso de erro, devolve um JSON de erro
    header('Content-Type: application/json');
    http_response_code(500); // Código de Erro Interno do Servidor
    echo json_encode(['erro' => 'Erro ao buscar hobbies: ' . $e->getMessage()]);
}

// NOTA: Este arquivo NÃO tem HTML. Só PHP.
?>