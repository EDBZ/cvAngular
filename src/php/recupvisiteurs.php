<?php
include_once('../php/connect.php');
$visiteurs = [];
$rep = $bdd->query('SELECT * FROM visiteurs ');
while($donnees = $rep->fetch()){
array_push($visiteurs, $donnees);
// echo print_r($visiteurs);
};
// $rep->closeCursor();
header('Content-Type: application/json');
echo json_encode($visiteurs,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
 ?>
