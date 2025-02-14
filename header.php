<?php
session_start();

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style_header.css">
    <title>LateMate</title>
    <script src="https://kit.fontawesome.com/edc8d5fc95.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <img src="image/logo.png" alt="LogoLateMate" width="30" height="30">
    <h1>LateMate</h1>
    <nav>
        <div id="burger"><i class="far fa-bars"></i></div>
        <ul>
            <li><a href="login.php">Se connecter</a></li>
            <li><a href="crea_compte.php">S'enregistrer</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<script>
    function activerDesactiver() {
        document.querySelector("nav ul").classList.toggle("actif");
    }

    document.querySelector("#burger").addEventListener("click", activerDesactiver);
</script>