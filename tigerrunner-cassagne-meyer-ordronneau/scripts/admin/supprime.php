<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connexion à la BDD
     $bdd = connect();
     //Récupération de l'info POST idUtilisateur
     $idUtilisateur = $_POST['util'];
     //Suppression de la table Inscrits la ligne où l'idUtilisateur = $idUtilisateur
     $req = "DELETE from Inscrits WHERE idUtilisateur = $idUtilisateur";
     //Execution de la requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
?>
