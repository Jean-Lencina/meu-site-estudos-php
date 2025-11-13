document.addEventListener('DOMContentLoaded', function() {

    // 1. Encontra os elementos
    var botao = document.getElementById('meu-botao');
    var container = document.getElementById('container-principal');
    var titulo = container.querySelector('h2');

    // 2. Ouve o clique no botão
    botao.addEventListener('click', function() {

        // 3. A MÁGICA! "Liga/Desliga" a classe no container
        container.classList.toggle('modo-noturno');

        // 4. Lógica para trocar o texto (igual à sua!)
        if (container.classList.contains('modo-noturno')) {
            // Se a classe FOI ADICIONADA:
            titulo.innerText = "Modo Noturno Ativado!";
            botao.innerText = "Desativar Modo Noturno";
        } else {
            // Se a classe FOI REMOVIDA:
            titulo.innerText = "Seja Bem-vindo ao meu site!";
            botao.innerText = "Ativar Modo Noturno";
        }
    });
});