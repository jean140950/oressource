<?php
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
 
// Insertion du post à l'aide d'une requête préparée
// mot de passe crypté md5 

// Insertion du post à l'aide d'une requête préparée
$req = $bdd->prepare('UPDATE filieres_sortie SET nom = :nom, id_type_dechet = :id_type_dechet, description = :description, couleur = :couleur  WHERE id = :id');
$req->execute(array('nom' => $_POST['nom'],'id_type_dechet' => $_POST['id_dechet'],
      'description' => $_POST['description'],'couleur' => $_POST['couleur'],'id' => $_POST['id']));

  $req->closeCursor();


















// Redirection du visiteur vers la page de gestion des points de collecte
header('Location:../ifaces/edition_filieres_sortie.php');
?>