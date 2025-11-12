<?php
    // Inclui o "molde" (a classe)
    include 'Database.php';

    // Cria o objeto "fábrica"
    $db = new Database();

    // Pede para a fábrica criar e entregar a conexão
    $pdo = $db->conectar();

    // Lógica de ADICIONAR (INSERT)
    // Verifica se o formulário de "novo_hobbie" foi enviado via POST
    if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['novo_hobbie'])) {
        $novo_hobbie = trim($_POST['novo_hobbie']);
        $user_identifier = trim($_POST['user_identifier']);

       try {
            $sql = "INSERT INTO hobbies (nome_hobbie, id_usuario) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$novo_hobbie, $user_identifier]);
            
            // Redireciona para a própria página para limpar o POST
            header("Location: admin.php");
            exit;
            
        } catch (Exception $e) {
            echo "Erro ao adicionar hobbie: " . $e->getMessage();
        }
    }
    
    // --- LÓGICA DE EXCLUIR (DELETE) --- (PARTE NOVA)
    // Verifica se um 'delete_id' foi passado na URL (via GET)
    if (isset($_GET['delete_id'])) {
        $id_para_deletar = $_GET['delete_id'];
        
        try {
            $sql = "DELETE FROM hobbies WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_para_deletar]);
            
            // Redireciona para a própria página para limpar o GET
            header("Location: admin.php");
            exit;
            
        } catch (Exception $e) {
            echo "Erro ao deletar hobbie: " . $e->getMessage();
        }
    }
    
    // Agora o header pode ser incluído
    include 'header.php';    // Inclui o topo (menu, etc.)

    // --- LÓGICA DE LISTAR (SELECT) --- (PARTE NOVA)
    // Precisamos buscar os hobbies *depois* de toda a lógica de adicionar/excluir
    try {
        $sql_select = "SELECT 
                            hobbies.id, 
                            hobbies.nome_hobbie, 
                            usuarios.nome AS nome_usuario
                       FROM hobbies 
                       LEFT JOIN usuarios ON hobbies.id_usuario = usuarios.id
                       ORDER BY hobbies.nome_hobbie ASC";
        $stmt_select = $pdo->query($sql_select);
        $hobbies_admin = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        echo "Erro ao buscar hobbies: " . $e->getMessage();
        $hobbies_admin = [];
    }

?>

    <main>
        <div style="color: #eee; font-weight:bold;">Estatísticas do Site</h3>
            <?php
                try {
                    // Contar Hobbies
                    $sql_count_hobbies = "SELECT COUNT(*) FROM hobbies";
                    $stmt_count_hobbies = $pdo->query($sql_count_hobbies);
                    $total_hobbies = $stmt_count_hobbies->fetchColumn(); // fetchColumn() é perfeito para pegar um único valor

                    // Contar Mensagens
                    $sql_count_msgs = "SELECT COUNT(*) FROM mensagens";
                    $stmt_count_msgs = $pdo->query($sql_count_msgs);
                    $total_mensagens = $stmt_count_msgs->fetchColumn();

                } catch (Exception $e) {
                    echo "Erro ao buscar estatísticas: " . $e->getMessage();
                    $total_hobbies = "N/D";
                    $total_mensagens = "N/D";
                }
            ?>
            <p style="margin: 5px 0;">
                <strong>Total de Hobbies Cadastrados:</strong> <?= $total_hobbies; ?>
            </p>
            <p style="margin: 5px 0;">
                <strong>Total de Mensagens Recebidas:</strong> <?= $total_mensagens; ?>
            </p>
        </div>

        <h2>Gerenciar Hobbies</h2>
            <form action="admin.php" method="POST">
            <label for="novo_hobbie">Adicionar Novo Hobbie:</label>
            <input type="text" id="novo_hobbie" name="novo_hobbie" required>
            <label for="user_identifier" id="usuario">Usuário(Somente número): </label>
            <input type="text" id="user_identifier" name="user_identifier" required placeholder="1 - Jean, 2 - Júnior, 3 - Kálita">
            <button type="submit">Adicionar</button>
        </form>
        <hr>

        <h3>Meus Hobbies Atuais</h3>
        <ul>
            <?php
                // Faz o loop para exibi-los
                foreach ($hobbies_admin as $hobbie) {
                    echo "<li style='color: #333;'>";

                    // Mostra o nome do hobbie
                    echo htmlspecialchars($hobbie['nome_hobbie']); 

                    // Mostra quem cadastrou (vindo do JOIN)
                    echo " <em>(Usuário: <strong>" . htmlspecialchars($hobbie['nome_usuario']) . "</strong>)</em>";

                    // Link de Editar
                    echo " <a href='editar_hobbie.php?id=" . $hobbie['id'] . "' style='color:green;'>Editar</a>";

                    // Link de Excluir
                    echo " <a href='admin.php?delete_id=" . $hobbie['id'] . "' style='color:red;' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>";

                    echo "</li>";
                }
            ?>
        </ul>

        <hr> <h3>Últimas 5 Mensagens de Contato</h3>
        <table border="1" style="width: 100%; color: #333; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #eee;">
                    <th style="padding: 8px;">ID</th>
                    <th style="padding: 8px;">Nome</th>
                    <th style="padding: 8px;">Email</th>
                    <th style="padding: 8px;">Mensagem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Busca as 5 mensagens MAIS NOVAS
                    try {
                        $sql_msg = "SELECT id, nome, email, mensagem FROM mensagens ORDER BY id DESC LIMIT 5";
                        $stmt_msg = $pdo->query($sql_msg);
                        $mensagens = $stmt_msg->fetchAll(PDO::FETCH_ASSOC);

                    } catch (Exception $e) {
                        echo "Erro ao buscar mensagens: " . $e->getMessage();
                        $mensagens = [];
                    }

                    // Faz o loop para exibir na tabela
                    foreach ($mensagens as $msg) {
                        echo "<tr>";
                        echo "<td style='padding: 8px;'>" . $msg['id'] . "</td>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($msg['nome']) . "</td>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($msg['email']) . "</td>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($msg['mensagem']) . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

        <hr> <h3>Relatório: Hobbies por Usuário</h3>
        <table border="1" style="width: 100%; color: #333; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #eee;">
                    <th style="padding: 8px;">Nome do Usuário</th>
                    <th style="padding: 8px;">Total de Hobbies Cadastrados</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Esta é a nossa query avançada!
                    try {
                        $sql_report = "SELECT 
                                            usuarios.nome, 
                                            COUNT(hobbies.id) AS total_hobbies
                                       FROM usuarios
                                       LEFT JOIN hobbies ON usuarios.id = hobbies.id_usuario
                                       GROUP BY usuarios.id
                                       HAVING total_hobbies >= 0"; // Mude para > 1 para ver o 'HAVING' em ação!

                        $stmt_report = $pdo->query($sql_report);
                        $relatorio = $stmt_report->fetchAll(PDO::FETCH_ASSOC);

                    } catch (Exception $e) {
                        echo "Erro ao gerar relatório: " . $e->getMessage();
                        $relatorio = [];
                    }

                    // Faz o loop para exibir na tabela
                    foreach ($relatorio as $linha) {
                        echo "<tr>";
                        echo "<td style='padding: 8px;'>" . htmlspecialchars($linha['nome']) . "</td>";
                        echo "<td style='padding: 8px;'>" . $linha['total_hobbies'] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

    </main>

<?php
       include 'footer.php';  // Inclui o rodapé
?>