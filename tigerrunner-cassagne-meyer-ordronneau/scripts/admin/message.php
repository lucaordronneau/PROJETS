<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Récupération des infos POST idUtilisateur, idCorrespondant
     $util = $_POST['util'];
     $corres = $_POST['corres'];
     //Connexion à la BDD
     $bdd = connect();
     //Sélectionne l'idEnvoyeur et le message de la table Messagerie où
     //        idEnvoyeur = $util et idReceveur = $corres
     //   ou   idEnvoyeur = $corres et idReceveur = $util
     // ordonné par dates
     $req = "SELECT idEnvoyeur,message FROM Messagerie WHERE (idEnvoyeur = $util AND idReceveur = $corres) or (idEnvoyeur = $corres AND idReceveur = $util) ORDER BY dates";
     //Définition de la variable resultat
     $result = "";
     //Execution de la requete
     $res = execReq($req,$bdd);
     //Pour chaque ligne du tableau résultat de la requete
     while ($row = mysqli_fetch_row($res)) {
          //si le message a été envoyé par l'utilisateur, on ajoute le message au résultat avec la classe mess_droite
          if ($row[0] == $util) {
               $result .= "<p class='mess_droite'>$row[1]</p></br>";
          //si le message a été envoyé par le correspondant, on ajoute le message au résultat avec la classe mess_gauche
          } else {
               $result .= "<p class='mess_gauche'>$row[1]</p></br>";
          }
     }
     //Envoie du résultat
     echo $result;
     //Déconnexion de la BDD
     deconnect($bdd);
?>
