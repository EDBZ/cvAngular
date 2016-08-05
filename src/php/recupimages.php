<?php
include_once('../php/connect.php');
$images = array();


$images = [];
$rep = $bdd->query('SELECT * FROM images ');
while($donnees = $rep->fetch()){
array_push($images, $donnees);
};
header('Content-Type: application/json');
echo json_encode($images,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

// $rep = mysql_query("SELECT * FROM images ");
// if (!$rep) {
//     die('Requête invalide : ' . mysql_error());
// }
// while($donnees = $rep->fetch_array(MYSQLI_ASSOC))
// {
// array_push($images, $donnees);
// };
// header('Content-Type: application/json');
// echo json_encode($images,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
// $rep->close();
 ?>
