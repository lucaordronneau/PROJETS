<?php
     //Ouverture de la session
     session_start();
     //Si la varriable SESSION['id'] n'existe pas, i.e. si l'utilsateur n'est pas connecté
     //   alors on le renvoie vers la page index.php?not_autorised
     if (!isset($_SESSION['id']) && !isset($_SESSION['role'])) {
          header('Location: ./index.php?not_autorised');
          exit();
     }
?>
<!DOCTYPE html>
<html lang="fr">
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script src="https://unpkg.com/popper.js"></script>

          <title>Tiger Runner - Chercher profil</title>

          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

     </head>
     <body>
          <?php
          //Si l'action en GET blocked existe, alors on echo l'arlerte "Vous n'avez pas accès à cette parge ! Ce profil vous a bloqué ou vous l'avez bloqué"
           if (isset($_GET['blocked'])) {
                    echo("<script>alert('Vous n avez pas accès à cette page ! Ce profil vous a bloqué ou vous l avez bloqué');</script>");
                    //Si l'action en GET 404 existe, alors on echo l'arlerte "La personne que vous chercher n existe pas. Vérifiez que vous avez écrit correctement son nom et son prénom."
               } else if (isset($_GET['404'])) {
                    echo("<script>alert('La personne que vous chercher n existe pas. Vérifiez que vous avez écrit correctement son nom et son prénom.');</script>");
               }
               ?>
          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-12">
                         <!-- Titre de la page -->
                         <div class="page-header">
                              <h1>
                              		<!-- Logo EISTI -->
                                   Tiger Runner - <small>EistiGame</small>
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
                                   <a class="nav-link active" href="chercheprofil.php">Chercher un profil</a>
                              </li>
                              <li class='nav-item'>
                                   <a class='nav-link' href='profil.php'>Profil</a>
                              </li>
                              <li class='nav-item'>
                                   <a class='nav-link' href='./scripts/deconnexion.php'>Déconnexion</a>
                              </li>
                              <?php
                              //Si l'utilisateur est administrateur, lui affiche le bouton de navigation de la page admin
                                   if (isset($_SESSION['role']) && $_SESSION['role']==2) {
                                        echo ("<li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Admin</a><div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='admin.php#liste'>Liste des Utilisateurs</a><a class='dropdown-item' href='admin.php#suspect'>Liste Messages Suspects</a><a class='dropdown-item' href='admin.php#messagerie'>Liste des messageries Utilisateurs</a></div></li>");
                                   }
                              ?>
            			</ul>
                         <hr>
            			<div class="row">
            				<fieldset class=" fond_cherche2">
                                   <!-- Formulaire qui prend en paramètres le nom et le prénom d'une personne et qui renvoie vers la page de profil par la methode post -->
            				<h2 id="titre_cherche">Chercher un Profil</h2>
                    <form action="profil.php" method="post">

                      <input class="form-control" type="text" id="nom1" name="nom" placeholder="Nom" required>

                   	<br>
                      <input class="form-control" type="text" id="prenom1" name="prenom" placeholder="Prénom" required>

                      <br>
                      <div id="bouton_val">
                      <input class="btn btn-secondary" type="reset" id = "annuler1" value="Annuler">
                      <input class="btn btn-success" type="submit" id = "valider1" class="" value="Valider">
                      </div>
                    </fieldset>

                    </form>
            			</div>
                  </div>
               </div>
          </div>
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
          </div>
          <br>
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/scripts.js"></script>
       </body>
</html>
