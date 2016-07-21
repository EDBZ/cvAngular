<?php

// Renommer les dossiers=====================================================
$categorie = strtolower(str_replace(' ','_',$_POST[categorie]));
$s_categorie = strtolower(str_replace(' ','_',$_POST[s_categorie]));
$galerie = strtolower(str_replace(' ','_',$_POST[galerie]));

// Constantes=========================================================
define('TARGET', '../upload/'.$categorie.'/'.$s_categorie.'/'.$galerie.'/');    // Repertoire cible
define('MAX_SIZE', 2000);    // Taille max en koctets du fichier
define('WIDTH_MAX', 2200);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 2200);    // Hauteur max de l'image en pixels

// Reorganisation de $_FILE==========================================================
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

// parcour tableau multidimentionnel==================================================================================
function in_array_r($needle, $haystack, $strict = false){
foreach($haystack as $item){
   if(is_array($item)){
     if(in_array_r($needle, $item, $strict)){
       return true;
     }
   }else{
     if(($strict ? $needle === $item : $needle == $item)){
       return true;
     }
   }
}
return false;
}


// Tableaux de donnees===================================================================
$array_name_file = array();
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
// Variables
$poid = '';
$extension = '';
$message = '';
$nomImage = '';

  //Creation du repertoire cible si inexistant=========================================
  if( !is_dir('../upload/'.$categorie.'/') ) {
    if( !mkdir('../upload/'.$categorie.'/', 0777) ) {
      exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
    }
  }
  if( !is_dir('../upload/'.$categorie.'/'.$s_categorie.'/') ) {
    if( !mkdir('../upload/'.$categorie.'/'.$s_categorie.'/', 0777) ) {
      exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
    }
  }

if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0777) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
if (!empty($_FILES['file'])) {
    $file_ary = reArrayFiles($_FILES['file']);

    foreach ($file_ary as $file) {

        // Recuperation de l'extension du fichier===================
        $extension  = pathinfo($file['name'], PATHINFO_EXTENSION);
        $extension = strtolower($extension);

        // On verifie l'extension du fichier================
        if(in_array(strtolower($extension),$tabExt))
        {
          // On recupere les dimensions du fichier===================
          $infosImg = getimagesize($file['tmp_name']);
          //recuperation poid en kb============
          $poid = filesize($file['tmp_name'])/1000;

          // On verifie le type de l'image=======================
          if($infosImg[2] >= 1 && $infosImg[2] <= 14)
          // On verifie les dimensions et taille de l'image
          {

            if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && ($poid <= MAX_SIZE))
            {
              // Parcours du tableau d'erreurs========================
              if(isset($file['error'])
                && UPLOAD_ERR_OK === $file['error'])
              {
                // On renomme le fichier==================
                $nomImage = md5(uniqid()) .'.'. $extension;
                $codeNomImage = substr($nomImage,0,5);
                array_push($array_name_file,$codeNomImage);

// ajout logo ============================================================================
                    if($extension=='jpg'){
                        header ("Content-type: image/jpeg"); // L'image que l'on va créer est un jpeg
                        $destination = imagecreatefromjpeg($file['tmp_name']); // La photo est la destination
                      }else{
                        header ("Content-type: image/png"); // L'image que l'on va créer est un png
                        $destination = imagecreatefrompng($file['tmp_name']); // La photo est la destination
                    }
                    $source = imagecreatefromjpeg("../img/logo-Th.jpg"); // Le logo est la source

                    // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
                    $largeur_source = imagesx($source);
                    $hauteur_source = imagesy($source);
                    $largeur_destination = imagesx($file['tmp_name']);
                    $hauteur_destination = imagesy($file['tmp_name']);

                    // On veut placer le logo en bas à droite, on calcule les coordonnées où on doit placer le logo sur la photo
                    $destination_x = 800 - $largeur_source;
                      $destination_y =  ((800*$hauteur_destination)/$largeur_destination) - $hauteur_source;

                    // On met le logo (source) dans l'image de destination (la photo)
                    imagecopymerge($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 60);

                    if($extension=='jpg'){
                        imagejpeg($destination,$file['tmp_name']);
                    }else{
                        imagepng($destination,$file['tmp_name']);
                    }

//  ===========================================================================

                // Si c'est OK, on teste l'upload
                if(move_uploaded_file($file['tmp_name'], TARGET.$nomImage))
                {

// JSON encode ===========================================================================

                  // ecriture données photo
                  $json_photo_arr = array('nom'=>$file['name'],
                                    'photographe'=>$_POST[user],
                                    'categorie'=>$_POST[categorie],
                                    'sous-categorie'=>$_POST[s_categorie],
                                    'galerie'=>$_POST[galerie],
                                    'actual_path'=>TARGET.$nomImage,
                                    // 'marque'=>$marque,
                                    // 'modele'=>$modele,
                                    // 'focale'=>$focale,
                                    // 'vit_obt'=>$vit_obt,
                                    // 'iso'=>$iso,
                                    // 'datePDV'=>$datePDV
                                  );

                  // écriture données galerie
                  $json_galerie_arr = array('id'=>$codeNomImage,
                                      'date_ajout'=> date('j/m/Y'),
                                      'info_photo'=>$json_photo_arr);

                  // ecriture données categorie
                  $json_cat_arr = array('sous-categorie'=>$_POST[s_categorie],
                    'nom_galerie'=>$_POST[galerie],
                  'path'=>'../data/'.$categorie.'/'.$galerie.'.json');

                  // données galerie format JSON
                  $galerieJSON = json_encode($json_galerie_arr,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES,2 );

                  // données categorie format JSON
                  $catJSON = json_encode($json_cat_arr,JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES );

                  // création dossier catégorie
                  if( !is_dir('../data/'.$categorie.'/') ) {
                    if( !mkdir('../data/'.$categorie.'/', 0777) ) {
                      exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
                    }
                  }

                   // création et écriture répertoire données categorie
                  if(!file_exists('../data/'.$categorie.'.json')){
                    $fichier_cat_JSON = fopen('../data/'.$categorie.'.json','w+');
                    fputs($fichier_cat_JSON,'[');
                    fputs($fichier_cat_JSON,$catJSON);
                    fputs($fichier_cat_JSON,']');
                    fclose($fichier_cat_JSON);
                  }
                  else {
                    $readjson = json_decode(file_get_contents('../data/'.$categorie.'.json'),true);

                      if(!in_array_r('../data/'.$categorie.'/'.$galerie.'.json', $readjson)){
                        $fichier_cat_JSON = fopen('../data/'.$categorie.'.json','r+');                    fseek($fichier_cat_JSON,-1,SEEK_END);
                        fputs($fichier_cat_JSON,','.$catJSON);
                        fputs($fichier_cat_JSON,']');
                        fclose($fichier_cat_JSON);
                      }
                  };

                  // création et écriture répertoire données galerie
                  if(!file_exists('../data/'.$categorie.'/'.$galerie.'.json')){
                    $fichier_galerie_JSON = fopen('../data/'.$categorie.'/'.$galerie.'.json','w+');
                    fputs($fichier_galerie_JSON,'[');
                    fputs($fichier_galerie_JSON,$galerieJSON);
                    fputs($fichier_galerie_JSON,']');
                    fclose($fichier_galerie_JSON);
                  }
                  else {
                    $fichier_galerie_JSON=fopen('../data/'.$categorie.'/'.$galerie.'.json','r+');
                    fseek($fichier_galerie_JSON,-1,SEEK_END);
                    fputs($fichier_galerie_JSON,','.$galerieJSON);
                    fputs($fichier_galerie_JSON,']');
                    fclose($fichier_galerie_JSON);
                  };

                  // ================================================================================
                    $message='upload réussi !';
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
          // Sinon on affiche une erreur pour l'extension
          $message = 'L\'extension du fichier est incorrecte !';
        }
      }
    }

        echo $message;
        echo print_r($array_name_file);

   ?>
