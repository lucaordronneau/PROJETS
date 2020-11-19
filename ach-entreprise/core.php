<?php
// contient la fonction de connexion et de déconnexion à la BDD ainsi que les infos BDD
$user='admin';
$pass='admin';

function connecterBDD() {
  /*Connexion à Mysql*/
  try {
    $base = new PDO('mysql:host=localhost;dbname=projettransverse', 'admin', 'admin');
  }
  /*Attraper l'exception s'il y a des erreurs de connexion*/
  catch(exception $e) {
     die('Erreur '.$e->getMessage());
  }
  return $base;
}

function deconnecterBDD() {
  $dbh = new PDO('mysql:host=localhost;dbname=projettransverse', $user, $pass);
  // utiliser la connexion ici
  //$sth = $dbh->query('SELECT * FROM foo');
  // Fermeture de la connexion
  //$sth = null;
  $dbh = null;
}
?>
