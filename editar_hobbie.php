<?php
// editar_hobbie.php
include 'conexao.php';
include 'header.php';

$hobbie_nome = ""; // Variável para guardar o nome do hobbie
$hobbie_id = null;   // Variável para guardar o ID

// --- LÓGICA DE ATUALIZAÇÃO (POST) ---
// Primeiro, checa se o formulário foi ENVIADO (via POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Pegamos os dados do formulário
    $hobbie_id = $_POST['hobbie_id'];
    $novo_nome = trim($_POST['novo_nome']);

    try {
        // 2. Preparamos o comando UPDATE
        $sql = "UPDATE hobbies SET nome_hobbie = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        // 3. Executamos
        $stmt->execute([$novo_nome, $hobbie_id]);
        
        // 4. Redirecionamos de volta para o admin
        header("Location: admin.php");
        exit;

    } catch (Exception $e) {
        echo "Erro ao atualizar hobbie: " . $e->getMessage();
    }
}

// --- LÓGICA DE CARREGAMENTO (GET) ---
// Se não for POST, é a primeira vez que a página carrega (via GET)
else if (isset($_GET['id'])) {
    $hobbie_id = $_GET['id'];

    try {
        // 1. Buscamos o hobbie atual no banco
        $sql = "SELECT nome_hobbie FROM hobbies WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$hobbie_id]);
        
        // 2. Pegamos o resultado
        $hobbie = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($hobbie) {
            $hobbie_nome = $hobbie['nome_hobbie'];
        } else {
            echo "Hobbie não encontrado!";
            exit;
        }

    } catch (Exception $e) {
        echo "Erro ao buscar hobbie: " . $e->getMessage();
        exit;
    }
} else {
    // Se ninguém passou um ID na URL, encerra
    echo "ID do hobbie não fornecido!";
    exit;
}
?>

<main>
    <h2>Editar Hobbie</h2>
    
    <form action="editar_hobbie.php" method="POST">
        
        <label for="nome_hobbie">Nome do Hobbie:</label>
        <input type="text" 
               id="nome_hobbie" 
               name="nome_hobbie" 
               value="<?= htmlspecialchars($hobbie_nome); ?>" 
               required>
        
        <input type="hidden" name="hobbie_id" value="<?= $hobbie_id; ?>">
        
        <button type="submit">Salvar Alterações</button>
    </form>
</main>

<?php
include 'footer.php';
?>