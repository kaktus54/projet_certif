<?php

include_once('model/model.php');

if(isset($_FILES['imageCharge']['name']  )){

    if (!file_exists($_FILES['imageCharge']['tmp_name']) || !is_uploaded_file($_FILES['imageCharge']['tmp_name']))
    {
        $_SESSION['infoFlash']="Votre image n'a pas été mis à jour.";
    }
    else
    {
        $filename = "src/img/imgUsers/image".$_SESSION['pseudoID'].".png";

        if (file_exists($filename)) {
            updateImage($_SESSION['pseudoID'], "image".$_SESSION['pseudoID'], $_FILES['imageCharge']['size'], "png", "", 0);
        
        } else {
            registerImage($_SESSION['pseudoID'], "image".$_SESSION['pseudoID'], $_FILES['imageCharge']['size'], "png", "", 0);
        }

        $img_size = getimagesize($_FILES['imageCharge']['tmp_name']);
        $W_Src = $img_size[0]; // largeur
        $H_Src = $img_size[1]; // hauteur
        if($W_Src<=512||$H_Src<=512){
            move_uploaded_file($_FILES['imageCharge']['tmp_name'],"src/img/imgUsers/image".$_SESSION['pseudoID'].".png");

            $_SESSION['infoFlash']='Votre image a bien été mis à jour.';
        }else{
            $_SESSION['infoFlash']="Votre image est trop grand.";

        }
    }
}

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Array(array(
    'index' => 'Hello {{ name }}!',
));
$loader = new Twig_Loader_Filesystem('templates');


$twig = new Twig_Environment($loader);

if(!isset($_POST['routage'])) {
    if(isset($_GET['idPage'])) {
        $_POST['routage'] = 'retourgalerie';
    } else {
        $_POST['routage'] = 'index';
    }
    
}

switch ($_POST['routage']) {
    case 'index':
        echo $twig->render('acceuil.html.twig', array('name' => 'Fabien'));
    break;
    case 'connection':
        echo $twig->render('connection.html.twig', array('name' => 'Fabien'));
    break;
    case 'formulaire':
        echo $twig->render('formulaire.html.twig', array('name' => 'Fabien'));
    break;
    case 'addUser':
        addUser($_POST['sex'], $_POST['lastName'], $_POST['firstName'], $_POST['login'], $_POST['mail'], $_POST['pwd1']);
        $req = getUser($_POST['login']);
        $data = null;
        while($row = $req->fetch()) {
            $data = $row;
        }
        getSession($data);
        header('Location: index.php?idPage=1');
    break;
    case 'changUser':
        changUser($_POST['sex'], $_POST['lastName'], $_POST['firstName'], $_POST['login'], $_POST['mail'], $_POST['pwd1']);
        $req = getUser($_POST['login']);
        $data = null;
        while($row = $req->fetch()) {
            $data = $row;
        }
        getSession($data);
        header('Location: index.php?idPage=1');
    break;


    case 'valideConnection':
        login();
        if(isset($_SESSION['pseudoID'])){
        header('Location: index.php?idPage=1');

        }
        else{
            echo $twig->render('connection.html.twig', array('name' => 'Fabien')); 
        }
    break;
    case 'envoiphoto':
        if(isset($_FILES['imgEnvoie']['name']  )){
            $img_size = getimagesize($_FILES['imgEnvoie']['tmp_name']);
            $W_Src = $img_size[0]; // largeur
            $H_Src = $img_size[1]; // hauteur
            if($W_Src<=512||$H_Src<=512){
                move_uploaded_file($_FILES['imgEnvoie']['tmp_name'],"src/img/imgUsers/".$_POST['titreOeuvre'].".png");

                registerImage($_SESSION['pseudoID'], $_POST['titreOeuvre'], $_FILES['imgEnvoie']['size'], "png", $_POST['textarea']);
            }else{
                echo"<div class='erreurphoto' >votre image ne doit pas depasser 512 sur 512</div>";
            }
        }
        echo $twig->render('envoi.html.twig', array('name' => 'Fabien'));
    break;
    case 'modification':
        $dataUser = getUserById($_SESSION['pseudoID']);


        echo $twig->render('modification.html.twig', array( 
        'dataUser' => $dataUser[0],
        ));

    break;
    case 'retourgalerie':
        $nbImages = getCountImage();
        $nbImage = $nbImages[0][0];
        $pageprec = -99;
        $pagesuiv = -99;
        if(isset($_GET['idPage'])) {
            $_SESSION['currentPage'] = intval($_GET['idPage']);
            $pagesuiv =  $_SESSION['currentPage']+1;
            $pageprec = $_SESSION['currentPage']-1; 
            if($pageprec <= 0) {
                $pageprec = 1;
            } 
            if($pagesuiv >= floor($nbImage / 4)) {
                if( floor($nbImage % 4) !=0) {

                $pagesuiv = floor($nbImage / 4)+1;
                }
            }
        }
        $reponse = getImage($_SESSION['currentPage'] * 4 - 4);
        $reponse = $reponse->fetchAll();
        echo $twig->render('galerie/galerie.html.twig', array(
            'images' => $reponse,
            'nbImage' => $nbImage,
            'pagesuiv' => $pagesuiv,
            'pageprec' => $pageprec,
        ));
        break;

    case 'renvoieMdp':
        $req = getMdp($_POST['mail']);
        while($mdp = $req->fetch()) {
            mail($_POST['mail'], 'Votre mot de passe', $mdp);
        }
        echo $twig->render('acceuil.html.twig', array('name' => 'Fabien'));

    break;

    case 'quit':
        quit();
        echo $twig->render('connection.html.twig', array('name' => 'Fabien'));
    break;


}

function getSession($userData) {
    $data = null;
    $_SESSION['id'] = $userData['id'];
    $_SESSION['nom'] = $userData['nom'];
    $_SESSION['prenom'] = $userData['prenom'];
    $_SESSION['pseudo'] = $userData['pseudo'];
}

