<?php
     //Chargement du fichier core.php
    include('../core.php');
    //Connection à la BDD
    $bdd = connect();
    //Récupération des infos POST idUtilisateur et idAmi
    $util = $_POST['util'];
    $ami = $_POST['ami'];
    //On supprime de la tabler Ami la ligne où l'idJoueur = $util et idAmi = $ami
    $req = "DELETE FROM Ami WHERE idJoueur = $util AND idAmi = $ami;";
    //Execution del a requete
    $res = execReq($req,$bdd);
    //Déconnexion de la BDD
    deconnect($bdd);
?>
