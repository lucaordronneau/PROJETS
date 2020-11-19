 <?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connexion à la BDD
     $bdd = connect();
     //Récupération des infos POST idUtilisateur, idCorrespondant et message
     $util = $_POST['util'];
     $corres = $_POST['corres'];
     $message = $_POST['message'];
     //Supprime de la Messagerie la ligne où idEnvoyeur = $util,
     //             idReceveur = $corres et message = $message
     $req = "DELETE FROM Messagerie WHERE (idEnvoyeur = $util AND idReceveur =  $corres AND message = '$message'); ";
     //Execution de la requete
     $res = execReq($req,$bdd);
     //Déconnexion de la BDD
     deconnect($bdd);
 ?>
