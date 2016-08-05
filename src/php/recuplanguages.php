<?php
include_once('../php/connect.php');
$languages = [];
$rep = $bdd->query('SELECT * FROM languages ');
while($donnees = $rep->fetch()){
array_push($languages, $donnees);

};
// $rep->closeCursor();
header('Content-Type: application/json');
echo json_encode($languages,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
 ?>
