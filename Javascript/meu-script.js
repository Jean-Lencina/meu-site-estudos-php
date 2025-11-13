document.addEventListener('DOMContentLoaded', function() {

    // --- BLOCO DO MODO NOTURNO (INDEX.PHP) ---
    
    // 1. Tenta encontrar os elementos do Modo Noturno
    var botao = document.getElementById('meu-botao');
    var container = document.getElementById('container-principal');

    // 2. SÓ EXECUTA o resto se o botão E o container existirem nesta página!
    if (botao && container) {
        var titulo = container.querySelector('h2');

        // 3. Ouve o clique no botão
        botao.addEventListener('click', function() {
            
            // "Liga/Desliga" a classe no container
            container.classList.toggle('modo-noturno');
            
            // Lógica para trocar o texto
            if (container.classList.contains('modo-noturno')) {
                titulo.innerText = "Modo Noturno Ativado!";
                botao.innerText = "Desativar Modo Noturno";
            } else {
                titulo.innerText = "Seja Bem-vindo ao meu site!";
                botao.innerText = "Ativar Modo Noturno";
            }
        });
    } // Fim do 'if (botao && container)'


    // --- BLOCO DE VALIDAÇÃO (CONTATO.PHP) ---

    // 1. Tenta encontrar o formulário de contato
    var formContato = document.getElementById('form-contato');
    
    // 2. SÓ EXECUTA se o formulário existir nesta página!
    if (formContato) {

        formContato.addEventListener('submit', function(event) {
            
            var inputNome = document.getElementById('name');
            var inputEmail = document.getElementById('email');
            var erroP = document.getElementById('mensagem-erro');
            
            erroP.innerText = "";
            
            if (inputNome.value.trim() === "" || inputEmail.value.trim() === "") {
                erroP.innerText = "Por favor, preencha os campos Nome e Email.";
                event.preventDefault(); 
            }
        });
    } // Fim do 'if (formContato)'

    // 1. Tenta encontrar a lista de hobbies
    var ulHobbies = document.getElementById('lista-hobbies');

    // 2. SÓ EXECUTA se a lista existir nesta página
    if (ulHobbies) {

        // 3. Mostra uma mensagem de "carregando"
        ulHobbies.innerHTML = "<li>Carregando hobbies...</li>";

        // 4. A MÁGICA: Chama a nossa API
        fetch('api_hobbies.php')
            .then(function(response) {
                // 5. Pega a resposta e a transforma em JSON
                return response.json();
            })
            .then(function(data) {
                // 6. 'data' agora é o nosso array de hobbies

                // Limpa o "Carregando..."
                ulHobbies.innerHTML = ""; 

                // 7. Faz um loop nos dados e cria o HTML
                data.forEach(function(hobbie) {
                    var novoLi = document.createElement('li'); // Cria um <li>
                    novoLi.innerText = hobbie.nome_hobbie;     // Coloca o texto
                    ulHobbies.appendChild(novoLi);             // Adiciona o <li> na <ul>
            });

        })
        .catch(function(error) {
            // 8. Se der erro na rede ou no JSON
            console.error('Erro ao buscar hobbies:', error);
            ulHobbies.innerHTML = "<li>Erro ao carregar hobbies.</li>";
        });
}

});