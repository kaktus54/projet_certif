<?php

session_start();

function co(){
    try
    {
        // On se connecte à MySQL
        $bdd = new PDO('mysql:host=localhost;dbname=galerie;charset=utf8', 'root', '');
        return $bdd;
    }
    catch(Exception $e)
    {
        // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
    }
}

function getUser($pseudo) {
	$bdd = co();
	$req = $bdd->prepare("SELECT * FROM user WHERE pseudo = :pseudo");
    $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $req->execute();
    return $req;
}
function getUserById($id) {
	$bdd = co();
	$req = $bdd->prepare("SELECT * FROM user WHERE id = :id");
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();
    $req = $req->fetchAll();
    return $req;
}


function addUser($sexe, $nom, $prenom, $pseudo, $mail, $mdp) {
    $bdd = co();
	$req = $bdd->prepare("INSERT INTO user (sexe, nom, prenom, mail, mdp, pseudo) VALUES (:sexe, :nom, :prenom, :mail, :mdp, :pseudo)");
	$req->bindParam(':sexe', $sexe, PDO::PARAM_INT);
	$req->bindParam(':nom', $nom, PDO::PARAM_STR);
    $req->bindParam(':prenom', $prenom, PDO::PARAM_STR);
	$req->bindParam(':mail', $mail, PDO::PARAM_STR);
    $req->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $req->execute();
}

function changUser($sexe, $nom, $prenom, $pseudo, $mail, $mdp) {
    $bdd = co();
    $req = $bdd->prepare("UPDATE user SET sexe=:sexe, nom=:nom, prenom=:prenom, mail=:mail, mdp=:mdp, pseudo=:pseudo");
    $req->bindParam(':sexe', $sexe, PDO::PARAM_INT);
    $req->bindParam(':nom', $nom, PDO::PARAM_STR);
    $req->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $req->bindParam(':mail', $mail, PDO::PARAM_STR);
    $req->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $req->execute();
}
function quit(){
    session_destroy();
    header('Location: index.php');

}

function registerImage($img_userid, $img_nom, $img_taille, $img_type, $img_desc) {
    $bdd = co();

$req = $bdd->prepare('INSERT INTO images (img_userid, img_nom, img_taille, img_type, img_desc) VALUES(:img_userid, :img_nom, :img_taille, :img_type, :img_desc)');
$req->bindParam(":img_userid", $img_userid);
$req->bindParam(":img_nom", $img_nom);
$req->bindParam(":img_taille", $img_taille);
$req->bindParam(":img_type", $img_type);
$req->bindParam(":img_desc", $img_desc);
$req->execute();
}

function login(){
    $bdd = co();
    $reponse = $bdd->query('SELECT id, mail, mdp FROM user ORDER BY ID ');

    while ($donnees = $reponse->fetch())
    {
        if($donnees['mail'] == $_POST['lmail'] && $donnees['mdp'] == $_POST['pwd1']){
            $_SESSION['pseudoID']=$donnees['id'];
            $_SESSION['currentPage']=1;
        }
    }
}

function getCountImage() {
    $bdd = co();
    $reponse = $bdd->prepare("
        SELECT count(*) 
        FROM images 
    ");
    $reponse->execute();
    $reponse = $reponse->fetchAll();
    return $reponse;
}

function getImage($entre) {
    $bdd = co();
    $reponse = $bdd->prepare("
        SELECT  img_userid, img_nom, img_taille, img_type, img_desc
        FROM images 
        LIMIT ".$entre." ,4
    ");

    $reponse->execute();
    return $reponse;
}
function getMdp($id) {
    $bdd = co();
    $reponse = $bdd->prepare("
        SELECT  mdp
        FROM user 
        WHERE  mail =".$id
    );

    $reponse->execute();
    return $reponse;
}