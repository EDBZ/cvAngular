<?php
  /****** Database Details *********/
// $host = "emmanuel.debuire.sql.free.fr";
// $user = "emmanuel.debuire";
// $pass = "1753vy31JBG067";
// $base = "emmanuel_debuire";
    $host      = "localhost";
    $user      = "root";
    $pass      = "1753vy31";
    $base  = "cvangular";

    // mysql======================================================================================
    // $connect = mysql_connect($host, $user, $pass) or
    // die("Erreur de connexion au serveur : ".mysql_error());
    // mysql_select_db($base, $connect) or die("Erreur de connexion à la base");

    //mysqli======================================================================================
// $mysqli = new mysqli($host, $user, $pass, $base);
// if ($mysqli->connect_error) {
//     die('Erreur de connexion ('.$mysqli->connect_errno.')'. $mysqli->connect_error);
// }

    // PDO======================================================================================
    try
    {
      $bdd = new PDO('mysql:host='.$host.';dbname='.$base.';charset=utf8', $user,$pass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e)
    {
      die('Erreur : '.$e->getMessage());
    }
?>
