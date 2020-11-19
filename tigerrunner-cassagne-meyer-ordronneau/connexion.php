<?php
     //Ouverture de session
     session_start();
     //Chargement du script core.php
     include('scripts/core.php');
     //Ouverture de la BDD
     $bdd = connect();
?>
<!DOCTYPE html>
<html lang="fr">
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script src="https://unpkg.com/popper.js"></script>

          <title>Tiger Runner - Connexion</title>

          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

     </head>
     <body>
        <?php
          //Vérifie si l'action GET['notcorrect'] existe
          if (isset($_GET['notcorrect'])) {
               //Alerte informant que l'adresse mail ou le mot de passe entré est incorrect.
            echo("<script>alert('Adresse mail ou mot de passe incorrect.');</script>");
          }
        ?>
          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-12">
                         <div class="page-header">
                              <!-- Titre de la page -->
                              <h1>
                                   Tiger Runner - <small>EistiGame</small>
                                   <!-- Logo de l'EISTI -->
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
                              <?php
                                   //Si l'utilisateur est connecté (i.e si la variable SESSION['id'] existe et n'est pas vide)
                                   if (isset($_SESSION['id']) && !EMPTY($_SESSION['id'])) {
                                        //Affiche les boutons Profil et Déconnexion
                                        echo ("<li class='nav-item'><a class='nav-link' href='#'>Profil</a></li><li class='nav-item'><a class='nav-link' href='./scripts/deconnexion.php'>Déconnexion</a></li>");
                                   } else {
                                        //Sinon, affiche les boutons inscription et connexion
                                        echo ("<li class='nav-item'><a class='nav-link' href='inscription.php'>Inscription</a></li><li class='nav-item'><a class='nav-link active' href='connexion.php'>Connexion</a></li>");
                                   }
                                   //Si l'utilisateur a le role d'administrateur,
                                   //   affiche le bouton de navigation de la page admin
                                   if (isset($_SESSION['role']) && $_SESSION['role']==2) {
                                        echo ("<li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Admin</a><div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='admin.php#liste'>Liste des Utilisateurs</a><a class='dropdown-item' href='admin.php#suspect'>Liste Messages Suspects</a><a class='dropdown-item' href='admin.php#messagerie'>Liste des messageries Utilisateurs</a></div></li>");
                                   }
                              ?>
            			</ul>
                         <hr>
            			<div class="row">
                              <!-- Fieldset de connexion -->
            				<fieldset class="fond_cherche2">
            				<h2 id="titre_cherche">Connexion</h2>
                              <!-- Formulaire prenant les informations email et mot de passe et les envoie en POST au script connexionEnCours.php -->
                      	<form id="formConnexion" name="formConnexion" method="POST" action="./scripts/connexionEnCours.php">

                       		<input class="form-control" id="mail" type="text" name="mail" value="" placeholder="email@example.com" tabindex="1">
                       		<br>
                        	<input class="form-control" id="motDePasse" type="password" name="motDePasse" placeholder="Password" tabindex="2">
                       		<br>
                              <div id='connect1'>
                       		          <input type="submit" name="Connexion" class="btn btn-success" value="Se Connecter" tabindex="3">
                              </div>
                      </form>

                    	</fieldset>
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
          <hr>
          </div>
          <!-- Chargement des scripts jquery, bootstrap et scripts.js -->
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/scripts.js"></script>
          <?php
          //Déconnexion de la BDD
            deconnect($bdd);
          ?>
       </body>
</html>
