<?php
    // 1. Incluímos o header primeiro
    include 'header.php';
    
    // 2. Incluímos a conexão com o banco
    include 'conexao.php';

    // 3. Buscamos os hobbies no banco de dados
    try {
        // 4. Preparamos e executamos a query SQL
        $sql = "SELECT nome_hobbie FROM hobbies ORDER BY nome_hobbie ASC"; // "Selecione a coluna 'nome_hobbie' da tabela 'hobbies'"
        $stmt = $pdo->query($sql);
        
        // 5. Buscamos TODOS os resultados como um array associativo
        $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Erro ao buscar hobbies: " . $e->getMessage();
        $hobbies = []; // Define um array vazio em caso de erro
    }
?>
    <main>
        <div>
            <h2><?= $detalhes_pessoais["Cargo pretendido"] ?></h2>
                <ul>
                    <?php foreach ($detalhes_pessoais as $chave => $valor) { ?>
                    <li>
                        <strong><?= $chave; ?>:</strong> <?= $valor; ?>
                    </li>
                    <?php } ?>
                </ul>
        </div>
        <div>
            <h2>Meus Hobbies</h2>
                <ul>
                    <?php foreach ($hobbies as $hobbie_row) { ?>
                        <li><?= $hobbie_row['nome_hobbie']; ?></li>
                    <?php } ?>
                </ul>
        </div>
    </main>

<?php
    include 'footer.php'; 
?>