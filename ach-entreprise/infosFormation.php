<?php
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.
include_once("utilBDD_affichageFormation.php");

if ($_GET['idForm'] != NULL ){
//récupère l'id de la formation dont on veut afficher les informations
$idFormation = $_GET['idForm'];

// affichage des informations de la formation
afficherPageFormation($idFormation);
}


if ($_GET['idOrga'] != NULL ){

//récupère l'id de l'organisme dont on veut afficher les informations
$idOrga = $_GET['idOrga'];

//affichage des informations de l'organisme
afficherPageOrganisme($idOrga);
}



?>
