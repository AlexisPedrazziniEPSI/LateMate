<?php
#page de login en php avec la bdd latemate
?>

<link rel="stylesheet" href="css/style.css">
<header>
    <h1>Connexion</h1>
    <br>
    <form method="post" action="login.php">
        <label for="Email">Email</label>
        <input type="email" name="Email" id="Email" placeholder="Email" required>
        <br>
        <label for="Mdp">Mot de passe</label>
        <input type="password" name="Mdp" id="Mdp" placeholder="Mot de passe" required>
        <br>
        <button type="submit" name="Submit" id="Submit">Se connecter</button>
    </form>
</header>
<?php
$email = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_STRING);
$mdp = filter_input(INPUT_POST, 'Mdp', FILTER_SANITIZE_STRING);

include 'config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;
if (isset($_POST['Submit'])) {
    # Create connection
    $conn = new PDO("mysql:host=" . Config::SERVEUR . ";dbname=" . Config::BASEDEDONNEES
        , Config::UTILISATEUR, Config::MOTDEPASSE);
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute(
        array(
            'email' => $email,
        )
    );
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result == false or $result == null) {
        echo "Erreur aucun compte existe dans la base de donnée car elle est vide je sais pas comment";
        ?>
        <br>
        <?php
        echo "Ducoup je te redirige vers la page de création de compte";
        header("Refresh: 10;url=crea_compte.php");
    }
    else {
        if ($result['email'] == $email
            && password_verify($mdp ,$result['mot_de_passe'])) {
            session_start();
            $token = $conn->prepare("SELECT id FROM utilisateurs WHERE email = :email");
            $token->bindParam(':email', $email);
            $token->execute(array(
                'email' => $email,
            ));
            $check = $token->fetch(PDO::FETCH_ASSOC);
            $_SESSION['token'] = $check['id'];
            header("Location: index.php");
        } else {
            echo "Error";
        }
    }
}
?>