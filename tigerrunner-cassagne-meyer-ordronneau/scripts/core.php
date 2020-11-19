<?php
//Définition des variables HOTE, USER, PASS et BASE qui sont les infos de la BDD
$HOTE = 'localhost';
$USER = 'ordronneau';
$PASS = 'F3810yE';
$BASE = '2018_p0_cpi02_ordronneau';

//connexion à la bdd
function connect(){
	global $HOTE, $USER, $PASS, $BASE;

	$maCnx = mysqli_connect($HOTE, $USER, $PASS) or die('Erreur Connexion MySQL: '.mysqli_error());
	//on choisi la base sur laquelle on se connecte (le nom de leur bdd phpmyadmin)
	mysqli_select_db($maCnx,$BASE) or die('Erreur sélection de base: '.$BASE.' - '.mysqli_error());
	return $maCnx;
}

//deconnexion de la bdd
function deconnect($cnx){
	mysqli_close($cnx) or die('Erreur Déconnexion: '.mysqli_error($cnx));
}

//requete à la bdd
function execReq($req,$bdd){
	$res = mysqli_query($bdd,$req);
	if(!$res){
		echo 'Erreur requête: '.$req.' - '.mysqli_error($bdd);
	 	die('Erreur requête: '.$req.' - '.mysqli_error($bdd));
	}
	return $res;
}
?>
