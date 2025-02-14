<?php
if(isset($_POST['Submit'])) {
    header("Location: crea_compte.php");
}

$nameFile= $_FILES['Image']['name'];
$tmp_name = $_FILES['Image']['tmp_name'];
$typeFile = explode('.', $nameFile)[1];

$correctType = ['png', 'jpg', 'jpeg'];

if(!in_array($typeFile, $correctType)){
    echo "Le fichier doit être une image(png, jpg, jpeg)";
    header("Refresh: 10;url=crea_compte.php");
}

$CreaCompte = filter_input(INPUT_POST, 'Submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
#recup les input de l'index pour le mettre dans un fichier JSON
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date_naiss = filter_input(INPUT_POST, 'DN', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lieu = filter_input(INPUT_POST, 'lieu', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$Pdp = filter_input(INPUT_POST, 'pdp', FILTER_SANITIZE_STRING);

if(!is_dir("pdp")){ //si le dossier n'existe pas
    mkdir("pdp");
}
$extension = pathinfo($_FILES['pdp']['name'], PATHINFO_EXTENSION);
$nome = "img_".bin2hex(random_bytes(16));
move_uploaded_file($_FILES['pdp']['tmp_name'], "pdp/".$nome.".".$extension);
$img_path = "pdp/".$nome.".".$extension;

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mdphash = password_hash($mdp, PASSWORD_DEFAULT);
$etabl = filter_input(INPUT_POST, 'etabl', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date_crea = date("d-m-Y H:i:s");

if(!is_dir("follower")){ //si le dossier n'existe pas
    mkdir("follower");
}
if(!is_dir("suivi")){ //si le dossier n'existe pas
    mkdir("suivi");
}


include 'config.php';
$servername = config::SERVEUR;
$username = config::UTILISATEUR;
$password = config::MOTDEPASSE;
$dbname = config::BASEDEDONNEES;

# Create connection
$conn = new PDO("mysql:host=".Config::SERVEUR.";dbname=".Config::BASEDEDONNEES
    , Config::UTILISATEUR, Config::MOTDEPASSE);
#bind param tout les valeurs pour ajouter une sécurité
#explication : le prepare va avoir comme instruction d'ajouter les valeurs dans les valeurs de la bdd
#et après on spam les bind param pour la sécurité
$stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, date_naissance ,bio ,photo_profil ,email, mot_de_passe, etablissement) VALUES (:nom, :prenom, :date_naissance ,:bio ,:photo_profil ,:email, :mot_de_passe, :etablissement)");
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':date_naissance', $date_naiss);
$stmt->bindParam(':bio', $bio);
$stmt->bindParam(':photo_profil', $img_path);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':mot_de_passe', $mdphash);
$stmt->bindParam(':etablissement', $etabl);
$stmt->execute();

if ($conn->query($stmt) === TRUE) {
    echo "New record created successfully";
    header("Location: login.php");
} else {
    echo "Error: " . $stmt . "<br>" . $conn->error;
}

?>
