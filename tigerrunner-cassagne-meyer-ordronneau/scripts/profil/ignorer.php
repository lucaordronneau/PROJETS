 <?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connection à la BDD
     $bdd = connect();
     //Récupération des infos POST idUtilisateur, idCorres et message
     $util = $_POST['util'];
     $corres = $_POST['corres'];
     $message = $_POST['message'];
     //On supprime de la table Signalement la ligne du signalement en cours de traitement à l'aide de l'idUtilisateur, l'idCorrespondant, et du message
     $req = "DELETE A FROM Signalement A INNER JOIN (SELECT dates FROM Messagerie WHERE (idEnvoyeur = $corres AND idReceveur = $util AND message='$message')) B ON (A.idEnvoyeur=$util AND idReceveur=$corres AND A.dates = B.dates)";
     //Execution del a requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
 ?>
