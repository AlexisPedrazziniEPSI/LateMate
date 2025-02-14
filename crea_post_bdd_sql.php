<?php
session_start();

include 'config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

$user = $conn->prepare("SELECT prenom, nom, id FROM utilisateurs WHERE id = :token");
$user->bindParam(':token', $_SESSION['token']);
$user->execute(array(
    'token' => $_SESSION['token'],
));
$check = $user->fetch(PDO::FETCH_ASSOC);
$id = $check['id'];
$prenom = $check['prenom'];
$unom = $check['nom'];


if(!isset($_POST['Submit'])) {
    header("Location: formulaire_crea_post.php");
}

$CreaPost = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_STRING);
#recup les input de l'index pour le mettre dans un fichier JSON
$Title = filter_input(INPUT_POST, 'Title', FILTER_SANITIZE_STRING);
$Content = filter_input(INPUT_POST, 'Content', FILTER_SANITIZE_STRING);
$raison = filter_input(INPUT_POST, 'raison', FILTER_SANITIZE_STRING);
$date = date("d-m-Y");
$heure = date("H:i:s");
$image = filter_input(INPUT_POST, 'Image', FILTER_SANITIZE_STRING);
if(!is_dir("posts_img")){ //si le dossier n'existe pas
    mkdir("posts_img");
}


//on récupère la photo et on la met dans le dossier posts_img en lui donnant un nom unique composé de lettre et de chiffre aléatoire un peu comme un sha256 sans que sa termine par image mais que ça commence par img_
$extension = pathinfo($_FILES['Image']['name'], PATHINFO_EXTENSION);
$nom = "img_".bin2hex(random_bytes(16));
move_uploaded_file($_FILES['Image']['tmp_name'], "posts_img/".$nom.".".$extension);
$img_path = "posts_img/".$nom.".".$extension;


$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);

$stmt = $conn->prepare("INSERT INTO posts (utilisateur_id, author_name, author_surname, titre, contenu, document, raison)"." VALUES (:utilisateur_id, :author_name,  :author_surname, :titre, :contenu, :document, :raison)");
$stmt->bindParam(':utilisateur_id', $id);
$stmt->bindParam(':author_name', $prenom);
$stmt->bindParam(':author_surname', $unom);
$stmt->bindParam(':titre', $Title);
$stmt->bindParam(':contenu', $Content);
$stmt->bindParam(':document', $img_path);
$stmt->bindParam(':raison', $raison);
$stmt->execute();

#vérifier que la requête s'est bien effectuée
if($stmt->rowCount() == 1) {
    header("Location: index.php");
} else {
    echo "Erreur lors de la création du post";
    header("Refresh: 4;url=index.php");
}
?>