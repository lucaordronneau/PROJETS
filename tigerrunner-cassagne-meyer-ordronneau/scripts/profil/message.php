<?php
     //Chargement du fichier core.php
     include('../core.php');
     //Récupération des infos POST idUtilisateur et idCorres
     $util = $_POST['util'];
     $corres = $_POST['corres'];
     //Connection à la BDD
     $bdd = connect();
     //Séléctionne idEnvoyeur, message de la table messageire où
     //        idEnvoyeur = $util et idReceveur = $corres
     //   ou   idEnvoyeur = $corres et idReceveur = $util
     $req = "SELECT idEnvoyeur,message FROM Messagerie WHERE (idEnvoyeur = $util AND idReceveur = $corres) or (idEnvoyeur = $corres AND idReceveur = $util) ORDER BY dates";
     //Définition de la variable résultat
     $result = "";
     //Execution del a requete
     $res = execReq($req,$bdd);
     //Pour chaque ligne du tableau res de la requete
     while ($row = mysqli_fetch_row($res)) {
          //Si le message a été envoyé par l'utilisateur,
          //   ajoute le message avec la classe "mess_droite" et le bouton supprimeMsg
          if ($row[0] == $util) {
               $result .= "<p class='mess_droite'>$row[1]<i onclick = 'supprimeMsg(this,$util, $corres);' class='fa fa-trash-o'></i></p></br>";
          } else {
          //Si le message a été envoyé par le correspondant,
          //   ajoute le message avec la classe "mess_gauche" et le bouton signal
               $result .= "<p class='mess_gauche'><i onclick = 'signal(this,$util, $corres);' class='fa fa-warning'></i>$row[1]</p></br>";
          }
     }
     //Envoie du résultat
     echo $result;
     //Déconnexion de la BDD
     deconnect($bdd);
?>
