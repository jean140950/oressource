<?
session_start();
//martin vert
// Connexion à la base de données

try
{
    include('dbconfig.php');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
 


// extraction du nom de la structure




$req = $bdd->prepare('SELECT nom FROM description_structure');
$req->execute();
    
$resultat = $req->fetch();
 



$_SESSION['structure'] = $resultat['nom'];
  

$req->closeCursor();




 
// Vérification des identifiants
$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE mail = :mail AND pass = :pass');
$req->execute(array(
    'mail' => $_POST['mail'],
    'pass' => md5($_POST['pass'])));
    
$resultat = $req->fetch();
 
if (!$resultat)
{
    header ('location:../ifaces/login.php?err=Mauvais identifiant ou mot de passe !');
}
else
{

$_SESSION['id'] =$resultat['id'];
$_SESSION['niveau'] = $resultat['niveau'];
$_SESSION['nom'] = $resultat['nom'];
$_SESSION['mail'] = $resultat['mail'];
$_SESSION['systeme'] = "oressource";
$_SESSION['structure'] = "";
$req->closeCursor();
    header ('location:../index.php');
}

 


?>
