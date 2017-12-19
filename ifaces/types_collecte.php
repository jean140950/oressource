<?php
/*
  Oressource
  Copyright (C) 2014-2017  Martin Vert and Oressource devellopers

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Affero General Public License as
  published by the Free Software Foundation, either version 3 of the
  License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

session_start();
require_once '../core/composants.php';

if (isset($_SESSION['id']) && $_SESSION['systeme'] === 'oressource' && (strpos($_SESSION['niveau'], 'k') !== false)) {
  require_once '../moteur/dbconfig.php';
  require_once 'tete.php';
  ?>
  <div class="container">
    <?= config_types3([
      'h1' => 'Gestion de la typologie des collectes',
      'heading' => "Gérez ici les différents types de collectes",
      'text' => "Permet de différencier les collectes en fonction de leur origine (apport volontaire, collecte à domicile, collecte en pied d'immeuble...).",
      'url' => '../moteur/types_collecte_post.php']) ?>

    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Date de création</th>
          <th>Nom</th>
          <th>Description</th>
          <th>Couleur</th>
          <th>Visible</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $reponse = $bdd->query('SELECT * FROM type_collecte');
        while ($donnees = $reponse->fetch()) { ?>
          <tr>
            <td><?= $donnees['id']; ?></td>
            <td><?= $donnees['timestamp']; ?></td>
            <td><?= $donnees['nom']; ?></td>
            <td><?= $donnees['description']; ?></td>
            <td><span class="badge" style="background-color:<?= $donnees['couleur']; ?>"><?= $donnees['couleur']; ?></span></td>
            <td>
              <form action="../moteur/types_collecte_visible.php" method="post">

                <input type="hidden" name ="id" id="id" value="<?= $donnees['id']; ?>">
                <input type="hidden" name="visible" id="visible" value="<?php
                if ($donnees['visible'] === 'oui') {
                  echo 'non';
                } else {
                  echo 'oui';
                }
                ?>">
                       <?php
                       if ($donnees['visible'] === 'oui') { // SI on a pas de message d'erreur
                         ?>
                  <button  class="btn btn-info btn-sm " >
                    <?php
                  } else { // SINON
                    ?>
                    <button  class="btn btn-danger btn-sm " >
                      <?php
                    }
                    echo $donnees['visible'];
                    ?>
                  </button>
              </form>
            </td>
            <td>
              <form action="modification_types_collecte.php" method="post">
                <input type="hidden" name ="id" id="id" value="<?= $donnees['id']; ?>">
                <input type="hidden" name ="nom" id="nom" value="<?= $donnees['nom']; ?>">
                <input type="hidden" name ="description" id="description" value="<?= $donnees['description']; ?>">
                <input type="hidden" name ="couleur" id="couleur" value="<?= substr($_POST['couleur'], 1); ?>">
                <button  class="btn btn-warning btn-sm" >Modifier</button>
              </form>
            </td>
          </tr>
          <?php
        }
        $reponse->closeCursor();
        ?>
      </tbody>
    </table>
  </div><!-- /.container -->

  <?php
  require_once 'pied.php';
} else {
  header('Location: ../moteur/destroy.php');
}
?>
