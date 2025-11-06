<?php
    // 1. Inclui a nova classe "molde"
    include 'Usuario.php';

    // 2. Criamos o OBJETO $usuario, usando o __construct
    $usuario = new Usuario(
        "Jean Carlos da Silva Lencina", // $nome
        30,                               // $idade
        "Bling",                          // $empresa
        "Suporte Técnico",                // $cargoAtual
        "Promoção para Desenvolvedor",    // $objetivo
        "Desenvolvedor"                   // $cargoPretendido
    );

    // OBS: O array $hobbies ainda fica aqui por enquanto.
    $hobbies = [
        "Explorar novas tecnologias",
        "Desenvolver sistemas",
        "Assistir videos no Youtube sobre tecnologia"
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem-vindo</title>
    <link rel="stylesheet" href="principal.css">
</head>
<body>
    <header>
        <h1><?= $usuario->getNome(); ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="sobre-mim.php">Sobre mim</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="admin.php" style="color: #ffcc00;">[Admin]</a></li>
            </ul>
        </nav>
    </header>