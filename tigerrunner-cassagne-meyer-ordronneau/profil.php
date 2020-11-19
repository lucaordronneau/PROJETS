<?php
     //Ouverture de session
     session_start();
     //Chargement du script core.php
     include('scripts/core.php');
     //Ouverture de la BDD
     $bdd = connect();
     //Vérification de l'existance des variables SESSION['id'] et SESSION['role']
     if (!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
          //Si les variables n'existe pas(i.e l'utilisateur n'est pas connecté)
          //   on renvoie l'utilisateur vers la page index.php?not_autorised
          header('Location: ./index.php?not_autorised');
          exit();
     }
     //Vérivation de l'existances des informations POST nom et prenom
     if (isset($_POST['nom']) && !EMPTY($_POST['nom']) && isset($_POST['prenom']) && !EMPTY($_POST['prenom'])) {
          //Attribution des informations POST aux variables nom et prenom
          $nom = $_POST['nom'];
          $prenom = $_POST['prenom'];
          //On récupère l'idUtilisateur dont le nom est égal à $nom et le prénom est égal à $prenom
          $req = "SELECT idUtilisateur FROM Inscrits WHERE nom = '$nom' AND prenom = '$prenom'";
          //Execution de la requete
          $res = execReq($req,$bdd);
          //Transformation du résultat
          $row = mysqli_fetch_row($res);
          //Si le résultat n'est pas vide
          if (!EMPTY($row[0])){
               //Récupération de lu résultat dans la variable $id
               $id = $row[0];
               //Récupération de l'information Session['id'] dans la variable $myid
               $myid = $_SESSION['id'];
               //On récupère les idUtilisateur et idBloquer où l'idUtilisateur est égal à $myid et l'idBloquer = $id
               //                                           ou l'idUtilisateur = $id et l'idBloquer = $myid
               $req = "SELECT idUtilisateur, idBloquer FROM Blocage WHERE (idUtilisateur = $myid AND idBloquer = $id) OR (idUtilisateur = $id AND idBloquer = $myid)";
               //Execution de la requete
               $res = execReq($req,$bdd);
               //Transfomation du resultat
               $row = mysqli_fetch_row($res);
               //Si le résultat n'est pas vide
               if (!EMPTY($row[0])) {
                    //Renvoie vers la page chercheprofil.php?blocked
                    header('Location: ./chercheprofil.php?blocked');
               }
          } else {
               //Renvoie vers la page chercheprofil.php?404
               header('Location: ./chercheprofil.php?404');
          }
     } else {
          //Récupération de l'information Session['id'] dans la variable $id
          $id = $_SESSION['id'];
     }
?>
<!DOCTYPE html>
<html lang="fr">
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script src="https://unpkg.com/popper.js"></script>

          <title>Tiger Runner - Profil</title>

          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">
          <script src="scripts/profil/profil.js"></script>
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     </head>
     <?php
          //Vérifie l'existance des info POSTS oldpass, newpass1 et newpass2
          //Vérifie que newpass1 = newpass2
          if (isset($_POST['oldpass']) && isset($_POST['newpass1']) && isset($_POST['newpass2']) && ($_POST['newpass1'] == $_POST['newpass2'])) {
               //On récupère le mot de passe de l'utilisateur dont l'idUtilisateur = $id
               $req = "SELECT passe FROM Inscrits WHERE idUtilisateur = $id";
               //Execution de la requete
               $res = execReq($req,$bdd);
               //Définition de la variable $newpass
               $newpass = $_POST['newpass1'];
               //Transformation du resultat de la requete
               $row = mysqli_fetch_row($res);
               //Si le resultat de la requete est egal à la variable POST['oldpass']
               if ($row[0] == $_POST['oldpass']) {
                    //On modifie le mot de passe de l'utilisateur dont l'idUtilisateur = $id pour le mettre à la valeur $newpass
                    $req = "UPDATE Inscrits SET passe = '$newpass' WHERE idUtilisateur = $id";
                    //Execution de la requete
                    $res = execReq($req,$bdd);
                    //Alerte informant que le mot de passe a bien été changé
                    echo "<script>alert('Votre mot de passe a bien été changé !')</script>";
               } else {
                    //Alerte informant que l'ancien mot de passe rentré n'est pas le bon
                    echo "<script>alert('Votre ancien mot de passe entré n'est pas le bon !')</script>";
               }
          //Si newpass1 différent de newpass2
          } else if (isset($_POST['oldpass']) && isset($_POST['newpass1']) && isset($_POST['newpass2']) && ($_POST['newpass1'] != $_POST['newpass2'])) {
               //Alerte informant que les mots de passes entrés sont différents
               echo "<script>alert('Les mots de passes entrés ne sont pas identiques !')</script>";
          }
          //Récupération de la variable SESSION['id'] dans la variable $ses_id
          $ses_id = $_SESSION['id'];
          //Echo de la balise body avec l'attribut onload contenant les fonctions prive_field($ses_id,$id) et load_ami($ses_id)
          echo "<body onload='prive_field($ses_id,$id);load_ami($ses_id)'>";
     ?>
          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-12">
                         <!-- Titre de la page -->
                         <div class="page-header">
                              <h1>
                                   Tiger Runner - <small>EistiGame</small>
                                   <!-- Logo EISTI -->
                                   <img src='images/LogoEisti.png' id = "imgeisti" width='30' alt='Logo de l EISTI'/>
                              </h1>
                         </div>
                         <hr>
                         <!-- Barre de navigation -->
                         <ul class="nav nav-pills">
                              <li class="nav-item">
                                   <a class="nav-link" href="index.php">Accueil</a>
                              </li>
                              <li class="nav-item">
                                   <a class="nav-link" href="chercheprofil.php">Chercher un profil</a>
                              </li>
                              <li class='nav-item'>
                                   <a class='nav-link active' href='profil.php'>Profil</a>
                              </li>
                              <li class='nav-item'>
                                   <a class='nav-link' href='./scripts/deconnexion.php'>Déconnexion</a>
                              </li>
                              <?php
                                   //Vérifie si la variable SESSION['role'] existe et est égale à 2
                                   if (isset($_SESSION['role']) && $_SESSION['role']==2) {
                                        //Affiche le bouton de navigation de la page admin
                                        echo ("<li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Admin</a><div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='admin.php#liste'>Liste des Utilisateurs</a><a class='dropdown-item' href='admin.php#suspect'>Liste Messages Suspects</a><a class='dropdown-item' href='admin.php#messagerie'>Liste des messageries Utilisateurs</a></div></li>");
                                   }
                              ?>
            			</ul>
                         <hr>
            			<div class="row">
            				<div class="col-md-9">
                                   <!-- Fieldset contenant les informations publiques de l'utilisateur : nom, prenom, sexe, email -->
                                   <fieldset id="public_field">
                                        <h2 id="info_perso">Informations Personnelles</h2>
                                        <?php
                                             //Récupère le nom, prenom, sexe, mail, informations et idAdresse de l'utilisateur dont l'idUtilisateur = $id
                                             $req = "SELECT nom, prenom,sexe,email,infos,idAdresse FROM Inscrits WHERE idUtilisateur = $id ";
                                             //Execution de la requete
                                             $res = execReq($req,$bdd);
                                             //Transformation du résultat de la requete
                                             $row = mysqli_fetch_row($res);
                                             //Affiche un fieldset d'id 'gauche' contenant le nom, prénom, sexe et l'email
                                             echo "<fieldset id = 'gauche'>";
                                             echo "<p id='nom_prenom'> <strong>Nom Prénom : </strong>".$row[0]."&nbsp;&nbsp;&nbsp;".$row[1]."</p>";
                                             echo "<p id='sexe'><strong>Sexe : </strong>".$row[2]."</p>";
                                             echo "<p id='email'><strong>Email : </strong> ".$row[3]."</p>";
                                             echo "</fieldset>";
                                             //Affiche un fieldset d'id 'profil_droit' contenant les informations
                                             echo "<fieldset id = 'profil_droit'><p id='info_profil'>".$row[4]."</p></fieldset>";
                                             //Récupère dans la variable $id_ad l'idAdresse de l'utilisateur
                                             $id_ad = $row[5];
                                        ?>
                                   </fieldset>
                                   <!-- Fieldset contenant les informations privées de l'utilisateur : Adresse complete et changement de mot de passe -->
                                   <fieldset id='prive_field'>
                                        <h2 id="info_prive">Informations Privées</h2>
                                        <!-- Fieldset de l'adresse de l'utilisateur -->
                                        <fieldset id="adresse_field">
                                             <h3 id="adresse">Adresse</h3>
                                             <?php
                                                  //Récupère le numero, la rue, le code postal et la ville où l'idAdresse = $id_ad
                                                  $req = "SELECT numero, rue, postal, ville FROM Adresse WHERE idAdresse = $id_ad ";
                                                  //Execute la requete
                                                  $res = execReq($req,$bdd);
                                                  //Transforme le résultat
                                                  $row = mysqli_fetch_row($res);
                                                  //Affiche l'adresse complète
                                                  echo $row[0].', '.$row[1].'<br />'.$row[2].' '.$row[3];
                                             ?>
                                        </fieldset>
                                        <!-- Fieldset du changement de mot de passe -->
                                        <fieldset id="passe_field">
                                             <h3 id="passe">Changer de mot de passe</h3>
                                             <!-- Formulaire prenant l'ancien mot de passe, le nouveau mot de passe et sa confirmation
                                                       et retourne les informations en methode POST à la page profil.php               -->
                                             <form role="form" action="profil.php" method="POST">
                                                  <div class="form-group">
                              					<label for="oldpass">
                              						Ancien mot de passe
                              					</label>
                              					<input type="password" class="form-control" name="oldpass" id="oldpass" required/>
                              				</div>
                              				<div class="form-group">

                              					<label for="newpass1">
                              						Nouveau mot de passe
                              					</label>
                              					<input type="password" class="form-control" name="newpass1" id="newpass1" required/>
                              				</div>
                                                  <div class="form-group">

                              					<label for="newpass2">
                              						Confirmer le nouveau mot de passe
                              					</label>
                              					<input type="password" class="form-control" name="newpass2" id="newpass2" required/>
                              				</div>
                                                  <div id="conf_bt">
                                   				<button type="submit" class="btn btn-success">
                                   					Confirmer
                                   				</button>
                                                       <button type="reset" class="btn btn-secondary">
                                   					Annuler
                                   				</button>
                                                  </div>
                              			</form>
                                        </fieldset>
                                   </fieldset>
                              </div>
            				<div class="col-md-3">
                                   <!-- Fieldset affichange les 10 meilleurs scores de l'utilisateur -->
                                   <fieldset>
                                        <h2 id="score">Meilleurs Scores</h2>
                                        <ol class='puces' >
                                        <?php
                                             //Récupère les 10 meilleurs scores où l'idUtilisteur est égal à $id
                                             $req = "SELECT score FROM Score WHERE idUtilisateur = $id ORDER BY score DESC LIMIT 10";
                                             //Execute la requete
                                             $res = execReq($req,$bdd);
                                             //Tant que l'on a pas atteint la fin du tableau résultat,
                                             //   Transforme une ligne du résultat en tableau php
                                             while ($row = mysqli_fetch_row($res)) {
                                                  //Affiche sous forme d'item de liste la variable $row['0']
                                                  echo "<li>$row[0]</li>";
                                             }
                                        ?>
                                        </ol>
                                   </fieldset>
                                   <!-- Fieldset de la liste d'amis privée qui se charge au chargement de la page -->
                                   <fieldset id="liste_ami_pv">
                                        <h2 id = "amis">Liste d'amis</h2>
                                        <ol id="liste_ami_ol">
                                        </ol>
                                   </fieldset>
                                   <!-- Fieldset des actions sur le profil d'un autre utilisateur -->
                                   <fieldset id="liste_ami">
                                        <h2 id = "action">Actions</h2>
                                        <!-- Boutons d'ajout/suppression de la liste d'ami et de bloquage de l'utilisateur -->
                                        <div id="bt_ami">
                                             <button type="button" class="btn btn-primary" id="ami" onclick="add_ami(<?php $myid = $_SESSION['id'];echo("'$myid','$id'")?>);">Ajouter un ami</button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger" id="block" onclick="blocage(<?php $myid = $_SESSION['id'];echo("'$myid','$id'")?>);">Bloquer</button>
                                        </div>
                                   </fieldset>
            				</div>
            			</div>
                         <!-- Fieldset de la messagerie privée -->
                         <fieldset id="messagerie_prive">
                              <h2 id="mess_pri_lab">Messagerie</h2>
                              <div id="contact">
                                   <!-- Liste contenant l'ensemble des utilisateurs avec lesquelles nous avons entammés une discussion -->
                                   <SELECT size=7>
                                   <?php
                                        //Récupère l'ensemble des idUtilisateur, nom et prénom des utilisateurs avec lesquelles nous avons entammés une discussion
                                        //   (i.e idEnvoyeur = $id et idReceveur = idUtilisateur ou idReceveur = $id et idEnvoyeur = idUtilisateur)
                                        $req = "SELECT DISTINCT idUtilisateur,nom,prenom FROM Inscrits i, Messagerie m WHERE (m.idEnvoyeur = $id AND m.idReceveur = i.idUtilisateur) OR (m.idReceveur = $id AND m.idEnvoyeur = i.idUtilisateur)";
                                        //Execution de la requete
                                        $res = execReq($req,$bdd);
                                        //Tant que l'on a pas atteint la fin du tableau résultat,
                                        //   Transforme une ligne du résultat en tableau php
                                        while ($row = mysqli_fetch_row($res)) {
                                             //Affiche sous forme d'item de liste la variable $row[1] $row[2] avec l'attribut onclick 'load_mess($id,$row[0])'
                                             echo "<option onclick='load_mess($id,$row[0]);'>$row[1] $row[2]</option>";
                                        }
                                   ?>
                                   </SELECT>
                              </div>
                              <!-- Div contenant les messages échangés avec l'utilisateur sélectionné -->
                              <div id = "place_message">
                                   <fieldset id="message">
                                   </fieldset>
                                   <!-- Textarea où l'on entre notre message à envoyer -->
                                   <input type="textarea" class="form-control" name="message" id="mess_p" maxlength="280" required/>
                                   <!-- Bouton d'envoie du message -->
                                   <button type="button" id="send_pv" class="btn btn-success" onclick="">
                                        Envoyer
                                   </button>
                              </div>
                         </fieldset>
                         <!-- Fieldset de la messagerie publique  -->
                         <fieldset id="messagerie">
                              <h2 id="mess_lab">Messagerie</h2>
                                   <!-- Textarea où l'on entre notre message à envoyer -->
                                   <input type="textarea" class="form-control" name="message" id="mess" required/>
                                   <!-- Bouton d'envoie du message -->
                                   <button type="button" class="btn btn-success" id="send" onclick="send_message(<?php $myid = $_SESSION['id'];echo("'$id','$myid'")?>);">
                                        Envoyer
                                   </button>
                              </form>
                         </fieldset>
                  </div>
               </div>
          </div>
          <?php
               //Déconnexion de la BDD
               deconnect($bdd);
          ?>
          <br>
           <!-- Footer -->
          <div id="couleur_footer">
          <hr>
          <div id='a_propos'>
               <h4>À propos</h4>
               <i class="fa fa-user fa-fw w3-xxlarge margin-right"></i>Etudiants EISTI :&nbsp;&nbsp;<b>Cassagne</b> Manon | <b>Ordronneau</b> Luca | <b>Meyer</b> Charlie
               <br/>
               <v class ="w3-xxlarge copyr">&copy;</v>&nbsp;&nbsp;Manon Luca Charlie - <i>Tous droits réservés</i>
          </div>
          <hr>
          </div>
          <br>
          <!-- Chargement des scripts jquery.min, bootstrap.min et scripts.js-->
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/scripts.js"></script>
       </body>
</html>
