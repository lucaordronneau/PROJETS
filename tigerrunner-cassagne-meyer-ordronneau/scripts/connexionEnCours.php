<?php
     session_start();
     $_SESSION = [];
     include('core.php');
     $bdd=connect();
     if (isset($_POST['mail']) && !EMPTY($_POST['mail']) && isset($_POST['motDePasse'])  && !EMPTY($_POST['motDePasse'])) {
      //on récupère les données entrées par l'utilisateur
      $mail = $_POST['mail'];
      $mdp = $_POST['motDePasse'];
      //on définie la requête qui selectionne l'id et le role de l'utilisateur
      $req = "SELECT idUtilisateur, idRole FROM Inscrits WHERE email = '$mail' AND passe = '$mdp'";
      //on exécute la requête grâce à la fonction execReq qui se trouve dans le fichier core.php
      $res = execReq($req,$bdd); //transoforme la requete en un tableau SQL que php ne comprend pas
      //on transforme le tableau SQL en tableau php pour pouvoir effectuer les traitements dessus
      $row = mysqli_fetch_row($res);
      //on vérifie si la première valeur du tableau n'est pas vide
      if (!EMPTY($row[0])) { // si elle ne l'est pas, les données entrées sont bonnes et l'ulisateur peut se connecter
		  $_SESSION['id']=$row[0];
		  $_SESSION['role']=$row[1];
		  header('Location: ./../index.php'); // on l'envoie vers la page d'accueil
  		  }
  		else {
  			header('Location: ./../connexion.php?notcorrect'); }
    }

    deconnect($bdd);
?>
