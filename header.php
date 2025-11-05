<?php
     $detalhes_pessoais = [
        "Nome" => "Jean Carlos da Silva Lencina",
        "Idade" => 30,
        "Empresa" => "Bling",
        "Cargo Atual" => "Suporte Técnico",
        "Objetivo" => "Promoção para Desenvolvedor",
        "Cargo pretendido" => "Desenvolvedor"
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
        <h1><?= $detalhes_pessoais["Nome"]; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="sobre-mim.php">Sobre mim</a></li>
                <li><a href="contato.php">Contato</a></li>
            </ul>
        </nav>
    </header>