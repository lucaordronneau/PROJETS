<?php
	//Chargement du fichier core.php
	include('../core.php');
	//Connexion à la BDD
	$bdd = connect();
	//Récupération des infos POST idUtilisateur, nom, prénom, email, sexe, infos et role
    	$idUtilisateur = $_POST['util'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
    	$sexe =$_POST['sexe'];
    	$infos = $_POST['info'];
    	$role = $_POST['role'];
	//Mise à jour de la ligne de la table Inscrits où l'idUtilisateur = $idUtilisateur
    	$req = "UPDATE Inscrits SET nom = '$nom', prenom='$prenom', email='$email', sexe='$sexe', infos ='$infos', idRole='$role' WHERE idUtilisateur = $idUtilisateur ";
	//Execution de la requete
    	$res = execReq($req,$bdd);
	//Déconnexion de la BDD
    	deconnect($bdd);
?>
