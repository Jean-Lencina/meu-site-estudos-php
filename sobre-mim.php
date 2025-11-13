<?php
    // Incluímos o header primeiro
    include 'header.php';
    
    // Inclui o "molde" (a classe)
    include 'Database.php';

    // Cria o objeto "fábrica"
    $db = new Database();

    // Pede para a fábrica criar e entregar a conexão
    $pdo = $db->conectar();

    // Buscamos os hobbies no banco de dados
    try {
        // Preparamos e executamos a query SQL
        $sql = "SELECT nome_hobbie FROM hobbies ORDER BY nome_hobbie ASC"; // "Selecione a coluna 'nome_hobbie' da tabela 'hobbies'"
        $stmt = $pdo->query($sql);
        
        // Buscamos TODOS os resultados como um array associativo
        $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo "Erro ao buscar hobbies: " . $e->getMessage();
        $hobbies = []; // Define um array vazio em caso de erro
    }
?>
    <main>
        <div>
            <h2><?= $usuario->getCargoPretendido(); ?></h2>
            <ul>
                <li><strong>Nome:</strong> <?= $usuario->getNome(); ?></li>
                <li><strong>Idade:</strong> <?= $usuario->getIdade(); ?></li>
                <li><strong>Empresa:</strong> <?= $usuario->getEmpresa(); ?></li>
                <li><strong>Cargo Atual:</strong> <?= $usuario->getCargoAtual(); ?></li>
                <li><strong>Objetivo:</strong> <?= $usuario->getObjetivo(); ?></li>
</ul>
        </div>
        <div>
            <h2>Meus Hobbies</h2>
                <ul id="lista-hobbies">
                    
                </ul>
        </div>
    </main>

<?php
    include 'footer.php'; 
?>