<?php
     //Ouverture de la session
     session_start();
     //Chargement du fichier core.php
     include('core.php');
     //Connexion à la BDD
     $bdd = connect();
     //Définition de la variable résultat
     $res = "";
     //Récupération de l'info POST score
     $score = $_POST['score'];
     //Si la variable SESSION['id'] existe
     if (isset($_SESSION['id'])) {
          //On définit la variable id
          $id = $_SESSION['id'];
          //Insérer dans la table Score l'idUtilisateur et le score
          $req = "INSERT INTO Score(idUtilisateur,score) VALUES ($id, $score)";
          //Execution de la requete
          $res_req = execReq($req,$bdd);
          //Définition de la variable resultat "Votre score a bien été enregistrer"
          $res = "Votre score a bien été enregistré.";
     } else {
          //Si la variable SESSION['id'] n'existe pas,
          //   alors l'utilisateur n'est pas inscrit ou connecté
          //   on définit alors la variable résultat sur
          //   "Si vous souhaitez enregister votre score, merci de vous inscrire ou de vous connecter."
          $res = "Si vous souhaitez enregistrer votre score, merci de vous inscrire ou de vous connecter.";
     }
     //Déconnexion de la BDD
     deconnect($bdd);
     //Envoie du résultat
     echo $res;
?>
