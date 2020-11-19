<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connection à la BDD
     $bdd = connect();
     //Récupération des infos POST idUtilisateur, idCorres et message
     $idEnvoyeur = $_POST['util'];
     $idReceveur = $_POST['corres'];
     $mess = $_POST['mess'];
     //Insertion dans la table messagerie de la ligne contenant les valeurs
     //   $idEnvoyeur, $idReceveur, DateTime actuelle et le message
     $req = "INSERT INTO Messagerie VALUES ($idEnvoyeur,$idReceveur,NOW(),'$mess')";
     //Execution del a requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
?>
