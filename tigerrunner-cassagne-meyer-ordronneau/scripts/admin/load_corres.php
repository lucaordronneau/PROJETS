<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Récupération de l'info POST idUtilisateur
     $util = $_POST['util'];
     //Connexion à la BDD
     $bdd = connect();
     //Selectionnes les différents idReceveurs, noms et prenoms de la table Inscrits où l'idEnvoyeur = $util et l'idUtilisateur = idReceveur
     $req = "SELECT DISTINCT idReceveur,nom,prenom FROM Inscrits i, Messagerie m WHERE (idEnvoyeur = $util) AND (idUtilisateur = idReceveur) ";
     //Création de la variable de résultat
     $result = "";
     //Execution de la requete
     $res = execReq($req,$bdd);
     //Pour chaque ligne du tableau résultat de la requete
     while ($row = mysqli_fetch_row($res)) {
          //Ajout d'une ligne du tableau résultat de la requete sous forme d'option
          $result .= "<option onclick='load_mess_adm($util,$row[0]);'>$row[1] $row[2]</option>";
     }
     //Envoie du résultat
     echo $result;
     //Déconnexion de la BDD
     deconnect($bdd);
?>
