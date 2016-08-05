<?php
include_once('../php/connect.php');

$nom = htmlspecialchars($_POST['nom']);
$mail = htmlspecialchars($_POST['mail']);
$tel = htmlspecialchars($_POST['tel']) ;
$message = htmlspecialchars($_POST['message']);

$mymail = 'emmanueldebuire@gmail.com';
$sujet = 'Message de '.$nom.' depuis le site CV';
$messageMail.= $nom.' / '.$mail.' / '.$tel.' / '.$message;

$reponse = '';

if (!empty($nom) AND !empty($mail) AND !empty($tel) AND !empty($message)) {
  $req = $bdd->prepare('INSERT INTO visiteurs (nom,mail,tel,message,date_ajout)   VALUES(?,?,?,?,NOW())');
  $req->execute(array(
    $nom,
    $mail,
    $tel,
    $message
  ));
  $req->closeCursor();
  $reponse = 'réussi !';
}else{
  $reponse = 'raté';
}

if(mail($mymail,$sujet,$messageMail)){
  echo 'done';
}
else
{
  echo $sujet;
}
// setcookie(reponse, $reponse);
header('Location: /#/contact');

 ?>
