<?php
     //Chargement du fichier core.php
    include('../core.php');
    //Connection à la BDD
    $bdd = connect();
    //Récupération des infos POST idUtilisateur et idAmi
    $util = $_POST['util'];
    $ami = $_POST['ami'];
    //On insert dans la table Ami l'idUtilisateur et l'idAmi
    $req = "INSERT INTO Ami VALUES ($util,$ami);";
    //Execution del a requete
    $res = execReq($req,$bdd);
    //Déconnexion de la BDD
    deconnect($bdd);
?>
