<?php
   // Inclui o "molde" (a classe)
    include 'Database.php';

    // Cria o objeto "fábrica"
    $db = new Database();

    // Pede para a fábrica criar e entregar a conexão
    $pdo = $db->conectar();

    // Inclui o cabeçalho do site
    include 'header.php';

    // Variável de controle
    $mensagem_enviada = false;
    $nome_usuario = "";
    $email_usuario = "";

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Coletamos TODOS os dados do formulário
        $nome_usuario = $_POST['name'];
        $email_usuario = $_POST['email'];
        $mensagem_usuario = $_POST['message']; // Capturamos a mensagem!

        try {
            // Preparamos o comando SQL (Seguro!)
            $sql = "INSERT INTO mensagens (nome, email, mensagem) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            // Executamos o comando, passando os dados
            $stmt->execute([$nome_usuario, $email_usuario, $mensagem_usuario]);

            // Se tudo deu certo, atualizamos a variável
            $mensagem_enviada = true;

        } catch (Exception $e) {
            // Se der erro, podemos mostrar (ou logar)
            echo "Erro ao salvar mensagem: " . $e->getMessage();
        }
    }
?>

    <link rel="stylesheet" href="css/contato-style.css">
    
    <main>
        <?php if ($mensagem_enviada == true): ?>
            <div class="mensagem-sucesso">
                <h2>Obrigado, <?= $nome_usuario; ?></h2>
                <p>Sua mensagem foi recebida com sucesso.</p>
                <p>Em breve, enviaremos uma confirmação para o e-mail: <strong><?= $email_usuario; ?></strong></p>
                <a href="contato.php">Enviar nova mensagem</a>
            </div>
        <?php else: ?>

            <h2>Entre em contato</h2>
            <form action="contato.php" method="post">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" rows="4" cols="50" required></textarea>

                <input type="submit" value="Enviar">
            </form>
        <?php endif; ?>
    </main>

<?php
    include 'footer.php';
?>