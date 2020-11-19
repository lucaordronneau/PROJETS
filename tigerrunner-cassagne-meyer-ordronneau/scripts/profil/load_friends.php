<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Connection à la BDD
     $bdd = connect();
     //Récupération de l'info POST idUtilisateur
     $util = $_POST['util'];
     //Définition de la variable résultat
     $result = "";
     //On séléctionnes les différents idUtilisateur, nom et prénom où idJoueur = $util et idAmi = idUtilisateur
     $req = "SELECT DISTINCT idUtilisateur,nom,prenom FROM Inscrits, Ami WHERE idJoueur = $util AND idAmi = idUtilisateur";
     //Execution del a requete
     $res = execReq($req,$bdd);
     while ($row = mysqli_fetch_row($res)) {
          //Pour chaque ligne du tableau res de la requete, ajoute au résultat la ligne sous forme d'item d'une liste
          // et un bouton de suppression de l'ami
          $ami = $row[0];
          $result .= "<li>$row[1] $row[2] &nbsp;&nbsp;&nbsp;<button type='button' class='btn btn-danger' id='block' onclick='sup_ami($util,$ami);'>Supprimer l'ami</button></li>";
     }
     //Envoie du résultat
     echo $result;
     //Déconnexion de la BDD
     deconnect($bdd);
?>
