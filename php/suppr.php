<?php

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

// suppr s_categorie===============================================
if(!empty($_POST['choix_s_cat1']))
{
  $route = $_POST['choix1'].'/'.$_POST['choix_s_cat1'];
  $datajson = '../data/'.$route.'.json';
  $datadir =  '../data/'.$route.'/';
  $realfiledir = '../upload/'.$route.'/';

  unlink($datajson);//suppr le json
  rrmdir($datadir);//suppr le dossier contenant les galerie json
  rrmdir($realfiledir);//suppr les dossiers s_categorie, galeries et les photos

  //nettoyage du fichier json Parent
  $json_parent = '../data/'.$_POST['choix1'].'.json';
  $json_parent_inarr = json_decode((file_get_contents($json_parent )));
  foreach ($json_parent_inarr as $key1 => $value1) {
      foreach ($value1 as $key2 => $value2) {
        if ($value2 ===$_POST['choix_s_cat1'] ) {
          array_splice($json_parent_inarr, $key1 , 1);
        }
      }
    }
  $new_json_parent = json_encode($json_parent_inarr,JSON_UNESCAPED_SLASHES,2);
  file_put_contents($json_parent, $new_json_parent);

};
// supprime categorie si la catégorie est vide
if (EtatDuRepertoire('../upload/'.$_POST['choix1'].'/')){
  unlink($json_parent);
  rmdir('../data/'.$_POST['choix1'].'/');
  rmdir('../upload/'.$_POST['choix1'].'/');
};


// suppr galerie===============================================
if(!empty($_POST['choix_gal2']))
  {
    $route = $_POST['choix2'].'/'.$_POST['choix_s_cat2'].'/'.$_POST['choix_gal2'];
    $datajson = '../data/'.$route.'.json';
    $realfiledir = '../upload/'.$route.'/';
    $json_parent_parent= '../data/'.$_POST['choix2'].'.json';
    $dataparentdir = '../data/'.$_POST['choix2'].'/'.$_POST['choix_s_cat2'].'/';
    $realparentdir = '../upload/'.$_POST['choix2'].'/'.$_POST['choix_s_cat2'].'/';

    unlink($datajson);//suppr le json
    rrmdir($realfiledir);//suppr le dossier galerie et les photos

    //nettoyage du fichier json Parent
    $json_parent = '../data/'.$_POST['choix2'].'/'.$_POST['choix_s_cat2'].'.json';
    $json_parent_inarr = json_decode((file_get_contents($json_parent)));
    foreach ($json_parent_inarr as $key1 => $value1) {
        foreach ($value1 as $key2 => $value2) {
          if ($value2 ===$_POST['choix_gal2'] ) {
            echo $value2;
            array_splice($json_parent_inarr, $key1 , 1);
          }
        }
      }
    $new_json_parent = json_encode($json_parent_inarr,JSON_UNESCAPED_SLASHES,2);
    file_put_contents($json_parent, $new_json_parent);

    // supprime les dossier parent et nettoie les fichiers json si la galerie était la dernière
    if (EtatDuRepertoire($dataparentdir)) {
      rmdir($dataparentdir);
      rmdir($realparentdir);
      unlink($json_parent);
      $json_parent_parent_inarr = json_decode((file_get_contents($json_parent_parent)));
      foreach ($json_parent_parent_inarr as $key1 => $value1) {
          foreach ($value1 as $key2 => $value2) {
            if ($value2 ===$_POST['choix_s_cat2'] ) {
              array_splice($json_parent_parent_inarr, $key1 , 1);
            }
          }
        }
        $new_json_parent_parent = json_encode($json_parent_parent_inarr,JSON_UNESCAPED_SLASHES,2);
        file_put_contents($json_parent_parent, $new_json_parent_parent);
      }

    // supprime categorie si la catégorie est vide
    if (EtatDuRepertoire('../upload/'.$_POST['choix2'].'/')){
      unlink($json_parent_parent);
      rmdir('../data/'.$_POST['choix2'].'/');
      rmdir('../upload/'.$_POST['choix2'].'/');

    };

};

// suppr photos===============================================
if(!empty($_POST['check_photo']))
{
  foreach($_POST['check_photo'] as $photo)
  {
    $photoroute = $_POST['choix3'].'/'.$_POST['choix_s_cat3'].'/'.$_POST['choix_gal3'].'/'.$photo;
    $realPhoto = '../upload/'.$photoroute;
    $datajson = '../data/'.$_POST['choix3'].'/'.$_POST['choix_s_cat3'].'/'.$_POST['choix_gal3'].'.json';
    $real_parent_dir = '../upload/'.$_POST['choix3'].'/'.$_POST['choix_s_cat3'].'/'.$_POST['choix_gal3'].'/';
    $json_parent = '../data/'.$_POST['choix3'].'/'.$_POST['choix_s_cat3'].'.json';
    $real_parent_parent_dir = '../upload/'.$_POST['choix3'].'/'.$_POST['choix_s_cat3'].'/';
    $json_parent_parent = '../data/'.$_POST['choix3'].'.json';
    unlink($realPhoto);//supprime la photo

    //supprime du json galerie
    $datajsonArr = json_decode((file_get_contents($datajson)));
    foreach ($datajsonArr as $key1 => $value1) {
        foreach ($value1 as $key2 => $value2) {
          if ($value2 ===$photo) {
            array_splice($datajsonArr, $key1 , 1);
          }
        }
      };
    $newdatajson = json_encode($datajsonArr,JSON_UNESCAPED_SLASHES,4);
    file_put_contents($datajson, $newdatajson);

    // supprime galerie si dernière photo galerie
    if(EtatDuRepertoire($real_parent_dir)){
      rmdir($real_parent_dir);
      unlink($datajson);
      $json_parent_Arr = json_decode((file_get_contents($json_parent)));
      foreach ($json_parent_Arr as $key1 => $value1) {
          foreach ($value1 as $key2 => $value2) {
            if ($value2 ===$_POST['choix_gal3']) {
              array_splice($json_parent_Arr, $key1 , 1);
            }
          }
        }
      $new_parent_json = json_encode($json_parent_Arr,JSON_UNESCAPED_SLASHES,4);
      file_put_contents($json_parent, $new_parent_json);
    };

    // supprime s_categorie si dernière photo
    if(EtatDuRepertoire($real_parent_parent_dir)){
      rmdir($real_parent_parent_dir);
      rmdir('../data/'.$_POST['choix3'].'/'.$_POST['choix_s_cat3'].'/');
      unlink($json_parent);
      $json_parent_parent_Arr = json_decode((file_get_contents($json_parent_parent)));
      foreach ($json_parent_parent_Arr as $key1 => $value1) {
          foreach ($value1 as $key2 => $value2) {
            if ($value2 ===$_POST['choix_s_cat3']) {
              array_splice($json_parent_parent_Arr, $key1 , 1);
            }
          }
        }
      $new_parent_parent_json = json_encode($json_parent_parent_Arr,JSON_UNESCAPED_SLASHES,4);
      file_put_contents($json_parent_parent, $new_parent_parent_json);
    };

    // supprime categorie si la catégorie est vide
    if (EtatDuRepertoire('../upload/'.$_POST['choix3'].'/')){
      unlink('../data/'.$_POST['choix3'].'.json');
      rmdir('../data/'.$_POST['choix3'].'/');
      rmdir('../upload/'.$_POST['choix3'].'/');

    };

    $photoroute = "";
  }
};
header('Location: ../#/admin/admin');
 ?>
