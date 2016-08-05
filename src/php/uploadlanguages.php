<?php
include_once('../php/connect.php');

// Constantes=========================================================
define('TARGET', '../upload/languages/');    // Repertoire cible
define('MAX_SIZE', 1000);    // Taille max en koctets du fichier
define('WIDTH_MAX', 1500);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 1500);    // Hauteur max de l'image en pixels



// Tableaux de donnees===================================================================
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
// Variables
$poid = '';
$extension = '';
$message = '';
$nomImage = '';

  //Creation du repertoire cible si inexistant=========================================

if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0777) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
if (!empty($_FILES['file'])) {

        $file_name = $_FILES['file']['name'];
        $file_size =$_FILES['file']['size'];
        $file_tmp =$_FILES['file']['tmp_name'];
        $file_type=$_FILES['file']['type'];
        $file_error=$_FILES['file']['error'];

         // Recuperation de l'extension du fichier===================
        $extension  = pathinfo($file_name, PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        // On verifie l'extension du fichier================
        if(in_array(strtolower($extension),$tabExt))
        {
          // On recupere les dimensions du fichier===================
          $infosImg = getimagesize($file_tmp);
          //recuperation poid en kb============
          $poid = filesize($file_tmp)/1000;

          // On verifie le type de l'image=======================
          if($infosImg[2] >= 1 && $infosImg[2] <= 14)
          // On verifie les dimensions et taille de l'image
          {

            if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && ($poid <= MAX_SIZE))
            {
              // Parcours du tableau d'erreurs========================
              if(isset($file_error)
                && UPLOAD_ERR_OK === $file_error)
              {

  // ================================================================================


                  if($extension=='jpg'){
                    header ("Content-type: image/jpeg"); // L'image que l'on va créer est un jpeg
                    $destination = imagecreatefromjpeg($file_tmp); // La photo est la destination
                  }else{
                    header ("Content-type: image/png"); // L'image que l'on va créer est un png
                    $destination = imagecreatefrompng($file_tmp); // La photo est la destination
                  }

                  $largeur_destination = imagesx($destination);
                  $hauteur_destination = imagesy($destination);


                  $resize = imagecreatetruecolor(128, (128*$hauteur_destination)/$largeur_destination);
                  imagealphablending($resize,false);
                  imagesavealpha($resize,true);

                  $largeur_resize=imagesx($resize);
                  $hauteur_resize=imagesy($resize);

                    // On crée la miniature
                  imagecopyresampled($resize, $destination, 0, 0, 0, 0, $largeur_resize, $hauteur_resize, $largeur_destination, $hauteur_destination);
                    if($extension=='jpg'){
                      imagejpeg($resize,$file_tmp);
                    }else{
                      imagepng($resize,$file_tmp);
                    }


// ================================================================================

                // Si c'est OK, on teste l'upload
                if(move_uploaded_file($file_tmp, TARGET.$file_name))
                {
// ================================================================================
$req = $bdd->prepare('INSERT INTO languages (logo,nom,niveau,date_ajout)   VALUES(?,?,?,NOW())');
$req->execute(array(
  TARGET.$file_name,
  $_POST['nom'],
  $_POST['niveau'],
));

$req->closeCursor();
// ================================================================================

                    $message='upload projet réussi !';

                }
                else
                {
                  // Sinon on affiche une erreur systeme
                  $message = 'Problème lors de l\'upload !';
                }
              }
              else
              {
                $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
              }
            }
            else
            {
              // Sinon erreur sur les dimensions et taille de l'image
              $message = 'Erreur dans les dimensions de l\'image !';
            }
          }
          else
          {
            // Sinon erreur sur le type de l'image
            $message = 'Le fichier à uploader n\'est pas une image !';
          }
        }
        else
        {
          // Sinon on affiche une erreur pour l'extension 'L\'extension du fichier est incorrecte !'
          $message = $extension ;
        }
      }
// echo $file_name;
header('Location: /#/admin/admin');
// header('Location: http://emmanuel.debuire.free.fr/#/admin/admin');
exit;
   ?>
