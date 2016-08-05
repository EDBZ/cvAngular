<?php
include_once('../php/connect.php');
$images = [];
$rep = $bdd->query('SELECT * FROM projetweb ');
while($donnees = $rep->fetch()){
array_push($images, $donnees);

};
// $rep->closeCursor();
header('Content-Type: application/json');
echo json_encode($images,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
 ?>
