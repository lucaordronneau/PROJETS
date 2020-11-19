<?php
     //Ouverture de session
     session_start();
     //Chargement du script core.php
     include('scripts/core.php');
?>
<!DOCTYPE html>
<html lang="fr">
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script src="https://unpkg.com/popper.js"></script>

          <title>Tiger Runner - EistiGame</title>

          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

     </head>
     <body>
          <?php
               //Vérifie l'existance de la variable GET['not_atorised']
               if (isset($_GET['not_autorised'])) {
                    //Alerte informant que l'utilisateur n'avait pas accès à la page où il essayait d'accéder
                    echo("<script>alert('Vous n avez pas accès à cette page ! Veuillez vous connecter pour pouvoir y accéder.');</script>");
               }
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
                                   <a class="nav-link active" href="index.php">Accueil</a>
                              </li>
                              <li class="nav-item">
                                   <a class="nav-link" href="chercheprofil.php">Chercher un profil</a>
                              </li>
                              <?php
                                   //Si l'utilisateur est connecté (i.e si SESSION['id'] existe et n'est pas vide)
                                   if (isset($_SESSION['id']) && !EMPTY($_SESSION['id'])) {
                                        //Affiche les boutons de Profil et de déconnexion
                                        echo ("<li class='nav-item'><a class='nav-link' href='profil.php'>Profil</a></li><li class='nav-item'><a class='nav-link' href='./scripts/deconnexion.php'>Déconnexion</a></li>");
                                   } else {
                                        //Sinon, affiche les boutons d'inscriptions et de connexion
                                        echo ("<li class='nav-item'><a class='nav-link' href='inscription.php'>Inscription</a></li><li class='nav-item'><a class='nav-link' href='connexion.php'>Connexion</a></li>");
                                   }
                                   //Si l'utilisateur a le rôle d'administrateur
                                   if (isset($_SESSION['role']) && $_SESSION['role']==2) {
                                        //Affiche le bouton de navigation de la page admin
                                        echo ("<li class='nav-item dropdown'><a class='nav-link dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Admin</a><div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'><a class='dropdown-item' href='admin.php#liste'>Liste des Utilisateurs</a><a class='dropdown-item' href='admin.php#suspect'>Liste Messages Suspects</a><a class='dropdown-item' href='admin.php#messagerie'>Liste des messageries Utilisateurs</a></div></li>");
                                   }
                              ?>
            			</ul>
                         <hr>
            			<div class="row">
            				<div class="col-md-9">
                                   <div id="container">
                                        <!-- Canvas du jeu -->
                                        <canvas id="game" width="800" height="480">
                                             <!-- Texte si le navigateur de l'utilisateur ne supporte pas canvas -->
                                             <p>Votre navigateur ne supporte pas les prérequis minimums nécessaires afin de jouer à ce jeu.</p>
                                             <p>Merci de mettre votre navigateur à jour pour jouer.</p>
                                        </canvas>
                                   </div>
                                   <div id = "imgtigre">
                                        <img src='images/sprite_normal.png'  width='750' alt='tigre2'/>
                                   </div>
                                   <fieldset>
                                        <h3 class="text-center couleur_best">Controls</h3>
                                        <p id="controls"> Pour sauter, appuyez sur <img src="images/touche_z.png" alt="Touche Z du clavier" width="40"/> ou <img src="images/fleche_haut.png" alt="Fleche haut du clavier" width="40"/><br />
                                        Pour glisser, appuyez sur <img src="images/touche_s.png" alt="Touche S du clavier" width="40"/> ou <img src="images/fleche_bas.png" alt="Fleche bas du clavier" width="40"/> </p>
                                   </fieldset>
                              </div>
                              <!-- Fieldset affichant les meilleurs scores du site -->
            				<fieldset class="col-md-2"  id="scores">
            					<h3 class="text-center couleur_best">Meilleurs Scores</h3>
            					<ol class='puces' >
		                      		<?php
                                             //Connexion à la BDD
                                             $bdd = connect();
                                             // Récupère l'idUtilisateur, le nom, le prénom et le score des 10 meilleurs scores du site
			                              $req = "SELECT s.idUtilisateur, nom, prenom, score FROM Score s, Inscrits i WHERE i.idUtilisateur = s.idUtilisateur ORDER BY score DESC LIMIT 10";
                                             //Execution de la requete
			                              $result=execReq($req,$bdd);
                                             //Tant que l'on a pas atteint la fin du tableau résultat,
                                             //   Transforme une ligne du résultat en tableau php
			                              while ($data = mysqli_fetch_row($result)) {
                                                  //Affiche sous forme d'item de liste le nom, le prénom et le score
                                                  echo "<li  id='link_score'>".$data[1]." ".$data[2]." ".$data[3]."</li>";
			                              }
		                      		?>
            					</ol>
            				</fieldset>
            			</div>
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
          <!-- Chargement des scripts game.js, jquery.min,bootstrap.min et scripts.js -->
          <script src="scripts/game.js"></script>
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/scripts.js"></script>
       </body>
</html>
