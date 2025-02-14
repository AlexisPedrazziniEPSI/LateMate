<?php
session_start();

if(isset($_SESSION['action_taken']) && $_SESSION['action_taken'] === true) {
    unset($_SESSION['action_taken']); // Réinitialiser la variable de session
    header("Location: index.php");
    exit();
}

include 'config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

$user = $conn->prepare("SELECT id FROM posts");
$user->execute();
$check = $user->fetch(PDO::FETCH_ASSOC);

$content = $conn->prepare("SELECT * FROM posts ORDER BY date_creation DESC");
$content->execute();

#ajouter un bouton pour ajouter un like
#ajouter un bouton pour ajouter un dislike

?>
<title>Index</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="style_header.css">
<html lang="fr">
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
</html>
<?php
# faire une boucle pour afficher tout les posts les un en dessous des autres
?>
<form action="index.php" method="post">
    <?php
    while ($check2 = $content->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="carre">
            <div class="texte">
                <p><?php echo $check2["titre"]?></p>
                <div class="image-container">
                    <img style="position: relative; align-items: center" src="<?php echo $check2["document"]?>" alt="photo de profil" width="100" height="100">
                </div>
                <p><?php echo $check2["contenu"]?></p>
                <p><?php echo $check2["raison"]?></p>
                <div style="width: 100%">
                    <div style="width: 50%; float: left">
                        <p><?php echo $check2["author_name"];?>_<?php echo $check2["author_surname"]?></p>
                    </div>
                    <div style="width: 50%; float: left">
                        <p>
                            <?php
                            $user = $conn->prepare("SELECT COUNT(like_id) FROM likes WHERE post_id = :post_id");
                            $user->bindParam(':post_id', $check2['id']);
                            $user->execute();
                            $check = $user->fetch(PDO::FETCH_ASSOC);
                            echo $check['COUNT(like_id)'];
                            ?>
                            Likes !
                        </p>
                    </div>
                    <div style="width: 50%; float: right">
                        <?php
                        if (!isset($_SESSION['token'])) {
                            // Si l'utilisateur n'est pas connecté
                            echo "Connectez-vous pour liker ce post !";
                        }
                        else {
                            $tkn = filter_var($_SESSION['token'], FILTER_SANITIZE_STRING);
                            $pst_id = filter_var($check2['id'], FILTER_SANITIZE_STRING);

                            // Vérifier si l'utilisateur a déjà liké ce post
                            $user = $conn->prepare("SELECT like_id FROM likes WHERE usr_id = :token AND post_id = :post_id");
                            $user->bindParam(':token', $tkn);
                            $user->bindParam(':post_id', $pst_id);
                            $user->execute();
                            $check = $user->fetch(PDO::FETCH_ASSOC);

                            if (empty($check)) {
                                // Si l'utilisateur n'a pas encore liké ce post
                                echo '<button type="submit" name="like_' . $check2['id'] . '">ajouter like</button>';
                            } else {
                                // Si l'utilisateur a déjà liké ce post
                                echo '<button type="submit" name="unlike_' . $check2['id'] . '">supprimer like</button>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <span><?php echo $check2["date_creation"]?></span>
            </div>
        </div>
        <br>
        <?php
    }
    ?>
</form>

<?php
// Traitement du formulaire de like/unlike
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'like_') === 0) {
            // C'est un bouton "add like" qui a été cliqué
            $postId = substr($key, 5);
            $stmt = $conn->prepare("INSERT INTO likes (usr_id, post_id) VALUES (:usr_id, :post_id)");
            $stmt->bindParam(':usr_id', $tkn);
            $stmt->bindParam(':post_id', $postId);
            $stmt->execute();
            $_SESSION['action_taken'] = true;

        } elseif (strpos($key, 'unlike_') === 0) {
            // C'est un bouton "remove like" qui a été cliqué
            $postId = substr($key, 7);
            $stmt = $conn->prepare("DELETE FROM likes WHERE usr_id = :usr_id AND post_id = :post_id");
            $stmt->bindParam(':usr_id', $tkn);
            $stmt->bindParam(':post_id', $postId);
            $stmt->execute();
            $_SESSION['action_taken'] = true;
        }
    }
    header("Location: index.php");
    exit();
}
?>

