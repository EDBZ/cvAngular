<?php


include_once('../php/connect.php');

// fonction pour supprimer dossier et son contenu
function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") {
          rrmdir($dir."/".$object);
          rmdir($dir."/".$object);
        }else {
          unlink($dir."/".$object);
        }
      }
    }
    reset($objects);
    rmdir($dir);
  }
};

//fonction pour verifier qu'un dossier est vide et le vider si c'est le cas
function EtatDuRepertoire($MonRepertoire){
  $fichierTrouve=0;
  if (is_dir($MonRepertoire))
  {
    if ($dh = opendir($MonRepertoire))
     {
      while (($file = readdir($dh)) !== false && $fichierTrouve==0)
      {
       if ($file!="." && $file!=".." ) $fichierTrouve=1;
       }
      closedir($dh);
     }
  }else {
    return false;
  }
  if( $fichierTrouve==0) {
    return true;
  }else {
    return false;
  }
}


// suppr photos===============================================
if(!empty($_POST['check_photo']))
{
  foreach($_POST['check_photo'] as $photo)
  {
    $real_parent_dir = '../upload/photos/'.$_POST['choix_gal'].'/';
    unlink($photo);//supprime la photo
    // ================================================================================
    $req = $bdd->prepare("DELETE FROM images WHERE chemin = :photo");
    $req->execute(array(
      'photo' => $photo
    ));

    $req->closeCursor();
    // ================================================================================

    // supprime galerie si dernière photo galerie
    if(EtatDuRepertoire($real_parent_dir)){
      rmdir($real_parent_dir);



    $photo = "";
  }
};
// header('Location: http://emmanuel.debuire.free.fr/#/admin/admin');
header('Location: ../#/admin/admin');
};

// suppr projet===============================================
if(!empty($_POST['check_projet']))
{
  foreach($_POST['check_projet'] as $preview)
  {
    unlink($preview);
    // ================================================================================
    $req = $bdd->prepare("DELETE FROM projetweb WHERE preview = :preview");
    $req->execute(array(
      'preview' => $preview
    ));

    $req->closeCursor();
    // ================================================================================
    $preview = "";

};
// header('Location: http://emmanuel.debuire.free.fr/#/admin/admin');
header('Location: ../#/admin/admin');
};

// suppr language===============================================
if(!empty($_POST['check_language']))
{
  foreach($_POST['check_language'] as $language)
  {
    unlink($language);
    // ================================================================================
    $req = $bdd->prepare("DELETE FROM languages WHERE logo = :language");
    $req->execute(array(
      'language' => $language
    ));

    $req->closeCursor();
    // ================================================================================
    $language = "";

};
header('Location: http://emmanuel.debuire.free.fr/#/admin/admin');

// header('Location: ../#/admin/admin');
};

 ?>
