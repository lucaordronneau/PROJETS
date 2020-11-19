<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connection à la BDD
     $bdd = connect();
     //Récupération des infos POST idUtilisateur, idCorres et message
     $util = $_POST['util'];
     $corres = $_POST['corres'];
     $message = $_POST['message'];
     //Insertion dans la table Signalement l'idEnvoyeur, l'idReceveur et le datetime du message
     $req = "INSERT INTO Signalement(idEnvoyeur,idreceveur,dates) VALUES ($util,$corres,(SELECT dates FROM Messagerie WHERE (idEnvoyeur = $corres AND idReceveur = $util AND message='$message')))";
     //Execution del a requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
 ?>
