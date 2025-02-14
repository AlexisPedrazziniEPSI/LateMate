<?php
session_start();
if ($_SESSION != null) {
    ?>
    <title>Création de Post</title>
    <link rel="stylesheet" href="css/style.css">
    <header>
        <h1>Création de Post</h1>
        <br>
        <?php
        include 'config.php';
        $servername = config::SERVEUR;
        $username = config::UTILISATEUR;
        $password = config::MOTDEPASSE;
        $dbname = config::BASEDEDONNEES;

        $conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
            , Config::UTILISATEUR, Config::MOTDEPASSE);

        $user = $conn->prepare("SELECT nom, photo_profil FROM utilisateurs WHERE id = :token");
        $user->bindParam(':token', $_SESSION['token']);
        $user->execute(array(
            'token' => $_SESSION['token'],
        ));
        $check = $user->fetch(PDO::FETCH_ASSOC);
        echo "Bienvenue ".$check['nom'];
        ?>
        <img src="<?php echo $check['photo_profil']; ?>" alt="photo de profil" width="100" height="100">
        <form method="post" action="crea_post_bdd_sql.php" enctype="multipart/form-data">
            <label for="Title">Titre du post(40 caractère max)</label>
            <input type="text" name="Title" id="Title" placeholder="Titre du post (Pas de NSFW ou contenue choquant" maxlength="40" required>
            <br>
            <label for="Content">Contenue du post(1200 caractères max)</label>
            <textarea type="text" name="Content" id="Content" placeholder="Met le contenue du post" maxlength="1200" required></textarea>
            <br>
            <label for="raison">Raison du retard : </label>
            <input type="text" name="raison" id="raison" maxlength="255" required>
            <br>
            <label for="Date">Ajoutez une image</label>
            <input type="file" name="Image" id="Image" accept="image/png, image/jpeg, image/jpg" required>
            <script>
                var pdpInput = document.getElementById("pdp");
                var pdpError = document.getElementById("pdpError");

                pdpInput.addEventListener("change", function () {
                    var allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
                    var file = pdpInput.files[0];

                    if (!allowedExtensions.test(file.name)) {
                        pdpError.textContent = 'Veuillez sélectionner un fichier PNG, JPG ou JPEG.';
                        pdpInput.value = ''; // Effacer le fichier sélectionné
                    } else {
                        pdpError.textContent = '';
                    }
                });
            </script>
            <br>
            <button type="submit" name="Submit" id="Submit">Créer le post</button>
        </form>
    </header>
    <?php
} else {
    ?>
    <title>Index</title>
    <html lang="fr">
    <h1>Vous devez crée un compte en cliquant <a href="crea_compte.php">ici</a> ou vous connecter <a href="login.php">ici</a> </h1>
    </html>
    <?php

}
?>
