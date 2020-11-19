 <?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connection à la BDD
     $bdd = connect();
     //Récupération des infos POST idUtilisateur, idCorres et message
     $util = $_POST['util'];
     $corres = $_POST['corres'];
     $message = $_POST['message'];
     //Suppression de la table Messagie la ligne ou l'idEnvoyeur = $util
     //   idReceveur = $corres et message = $message
     $req = "DELETE FROM Messagerie WHERE (idEnvoyeur = $util AND idReceveur =  $corres AND message = '$message'); ";
     //Execution del a requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
 ?>
