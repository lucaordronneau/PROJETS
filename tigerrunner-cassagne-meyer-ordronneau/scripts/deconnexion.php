<?php
     //Ouverture de la session
     session_start();
     //Remise de la variable de session en tableau vide
     $_SESSION = [];
     //Execution de la fonction session_destroy
     session_destroy();
     //Redirection vers l'accueil
     header('Location: ./../index.php');
     exit();

?>
