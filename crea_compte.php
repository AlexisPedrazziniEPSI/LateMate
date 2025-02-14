<?php
?>
<title>Création de compte</title>
<link rel="stylesheet" href="css/style.css">
<h1>Bienvenue, nous somme ravis de vous acceuillir parmis nous !</h1>
<br>
<form method="post" action="crea_compte_script_bdd.php" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required>
    <br>
    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" required>
    <br>
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>
    <script>
        var email = document.getElementById("email");
        function validateEmail(){
            if(email.value.indexOf("@") == -1) {
                email.setCustomValidity("L'email doit contenir un @");
            } else {
                email.setCustomValidity('');
            }
        }

    </script>
    <br>
    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" id="mdp" required>
    <br>
    <label for="mdp2">Confirmer le mot de passe :</label>
    <input type="password" name="mdp2" id="mdp2" required>
    <script>
        var mdp = document.getElementById("mdp")
        , mdp2 = document.getElementById("mdp2");

        function validatePassword(){
            if(mdp.value != mdp2.value) {
                mdp2.setCustomValidity("Les mots de passes ne correspondent pas");
            } else {
                mdp2.setCustomValidity('');
            }
        }

        mdp.onchange = validatePassword;
        mdp2.onkeyup = validatePassword;
    </script>
    <br>
    <label for="etabl">Etablissement</label>
    <input type="text" name="etabl" id="etabl" required>
    <br>
    <label for="bio">Ta bio :</label>
    <input type="text" name="bio" id="bio" required>
    <br>
    <label for="pdp">pdp :</label>
    <input type="file" name="pdp" id="pdp" accept="image/png, image/jpeg, image/jpg" required>
    <p id="pdpError" style="color: red;"></p>
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
    <button type="submit" name="Submit" id="Submit" >Créer le compte</button>
    <br>
    <a href="login.php">Vous avez déjà un compte ? Se connecter</a>

</form>
