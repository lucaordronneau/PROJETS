<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connection à la BDD
     $bdd = connect();
     //Récupération des infos POST idUtilisateur, et idBloque
     $idUtilisateur = $_POST['util'];
     $idBloque = $_POST['profil'];
     //On insert dans la table Blocage l'idUtilisateur et l'idBloque
     $req = "INSERT INTO Blocage VALUES ($idUtilisateur,$idBloque)";
     //Execution del a requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
?>
