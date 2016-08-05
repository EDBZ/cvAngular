<?php

include_once('../php/connect.php');

if (!empty($_POST['nom']) AND !empty($_POST['mdp'])) //si les champs du login sont remplis
  {
      $user = htmlspecialchars($_POST['nom']);
      $mdp = htmlspecialchars($_POST['mdp']);

      $rep = $bdd->prepare('SELECT * FROM user WHERE nom=?');
      $rep->execute(array($user));
      $donnees = $rep->fetch();

        if(is_null($donnees['id'])) // si le nom n'existe pas dans la bdd
          {
            $message_user=$user.' n\'est pas enregistré';
            header('Location: /#/');
            // header('Location: http://emmanuel.debuire.free.fr/#/');
          }
        else
          {
            if ($mdp != $donnees['mdp']) //si le mot de passe est différent de la bdd
            {
              $message_user = 'Mot de passe éronné ';
              header('Location: /#/');
              // header('Location: http://emmanuel.debuire.free.fr/#/');
            }
            else
            {

              $message_user='connexion réussie';
              header('Location: /#/admin/admin');
              // header('Location: http://emmanuel.debuire.free.fr/#/admin/admin');


            }
          }
        echo $message_user;
        $rep->closeCursor();
}
