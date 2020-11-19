<?php
     //Ouverture de session
     session_start();
     //Chargement du fichier core.php
     include('scripts/core.php');
     //Ouverture de la BDD
     $bdd = connect();
//Vérifie l'existance des variables POST non vides
//   - nom & prénom
//   - email
//   - sexe
//   - numero, rue, postal et ville
//   - passe
     if (((isset($_POST['nom']) && ($_POST['nom'] != "" ))) && ((isset($_POST['prenom']) && ($_POST['prenom'] != "" ))) && ((isset($_POST['email']) && ($_POST['email'] != "" ))) && ((isset($_POST['sexe']) && ($_POST['sexe'] != "" ))) && ((isset($_POST['numero']) && ($_POST['numero'] != "" ))) && ((isset($_POST['rue']) && ($_POST['rue'] != "" ))) && ((isset($_POST['postal']) && ($_POST['postal'] != "" ))) && ((isset($_POST['ville']) && ($_POST['ville'] != "" ))) && ((isset($_POST['passe']) && ($_POST['passe'] != "" )))) {
     //Récupère les variables nom, prénom, email, numero, sexe, infos, rue, postal, ville et passe
          $nom = $_POST['nom'];
          $prenom = $_POST['prenom'];
          $email = $_POST['email'];
          $numero = $_POST['numero'];
          $sexe =$_POST['sexe'];
          $infos = $_POST['infos'];
          $rue = $_POST['rue'];
          $postal = $_POST['postal'];
          $ville = $_POST['ville'];
          $passe = $_POST['passe'];
          //Insère dans la table Adresse le numero, la rue, le code postal et la ville
          $req1 = "INSERT INTO Adresse (numero, rue, postal, ville) VALUES ('$numero', '$rue', $postal, '$ville')";
          //Execute la requete
          $res1 = execReq($req1,$bdd);
          //Récupère l'idAdresse de la requete executé précedemment
          $idAdresse = mysqli_insert_id($bdd);
          //Insère dans la table Inscrits le nom, prénom, email, infos, sexe, idAdresse, passe et définie l'idRole sur 1
          $req3 = "INSERT INTO Inscrits (nom, prenom, email, infos, sexe, idAdresse, passe, idRole) VALUES ('$nom', '$prenom', '$email', '$infos', '$sexe', $idAdresse, '$passe', 1)";
          //Execute la requete
          $res3 = execReq($req3,$bdd);
          //Alerte informant que l'inscription est réussite
          echo "<script>alert('Votre inscription a été réussie !')</script>";
}
?>
<!DOCTYPE html>
<html lang="fr">
     <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">

          <title>Tiger Runner - Inscription</title>

          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     </head>
     <body>
          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-12">
                         <div class="page-header">
                              <!-- Titre de la page -->
                              <h1>
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
                                   <a class="nav-link" href="chercheprofil.php">Chercher un profil</a>
                              </li>
                              <?php
                                   //Vérifie si la variable SESSION['id'] existe et n'est pas vide (i.e l'utilisateur est connecté)
                                   if (isset($_SESSION['id']) && !EMPTY($_SESSION['id'])) {
                                        //Affiche les boutons de profil et de déconnexion
                                        echo ("<li class='nav-item'><a class='nav-link' href='#>Profil</a></li><li class='nav-item'><a class='nav-link' href='./scripts/deconnexion.php'>Déconnexion</a></li>");
                                   } else {
                                        //Sinon, affiche les boutons d'inscriptions et de connexion
                                        echo ("<li class='nav-item'><a class='nav-link active' href='inscription.php'>Inscription</a></li><li class='nav-item'><a class='nav-link' href='connexion.php'>Connexion</a></li>");
                                   }
                              ?>
            			</ul>
                         <hr>
            			<div class="row">
            				<div class="col-md-12">
                                   <!-- Fieldset contenant le formulaire d'inscription -->
                    <fieldset id = "inscriptionform">
                      <h2 id="inscriptiontitre">Inscriptions</h2>

                    <br>
                    <!-- Formulaire d'inscription prenant les champs :
                              - nom, prénom, email, infos, Sexe, passe, numero, rue, code postal et ville
                         et les retournes en POST à la page inscription.php                                -->
                    <form action="inscription.php" method="post">

                      <div class="row">
                      <div class="col">

                      <input class="form-control" type="text" id="nom" name="nom" placeholder="Nom" required tabindex="1">
                      </div>
                      <div class="col">

                      <input class="form-control" type="text" id="prenom" name="prenom" placeholder="Prénom" required tabindex="2">
                      </div>
                      </div>
                      <br>
                      <input class="form-control" type="email" id="email" name="email" placeholder="email@example.com" required tabindex="3">
                      <br>

                      <div class="row">
                      <div class="col">
                      <textarea class="form-control" id="infos" name="infos" placeholder="Biographie" tabindex="4"></textarea>
                      </div>
                      <div class="col-md-3">
                      <div class="row">
                      <label for="sexe">Sexe :</label>
                      <div class="col-sm-10">
                      <div class="form-check">
                      <input  type="radio" id="sexeF" name="sexe" value="F">
                      <label for="sexeF">F</label>
                      </div>
                      <div class="form-check">
                      <input  type="radio" id="sexeM" name="sexe" value="M">
                      <label for="sexeM">M</label>
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>

                      <label for="adresse">Adresse :</label>


                      <input class="form-control" type="text" id="rue" name="rue" placeholder="Rue" required tabindex="5">
                      <div class="row">
                      <div class="col-md-3">
                      <br>
                      <input class="form-control" type="text" id="numero" name="numero" placeholder="Numéro" required tabindex="6">
                      </div>
                      <div class="col-md-3">
                      <br>
                      <input class="form-control" type="int" id="postal" name="postal" placeholder="Code Postal" required tabindex="7">
                      </div>
                      <div class="col-md-6">
                      <br>
                      <input class="form-control" type="int" id="ville" name="ville" placeholder="Ville" required tabindex="8">
                      </div>
                      </div>
                      <br>
                      <input class="form-control" type="password" id="newpasse" name="passe" placeholder="Mot de Passe" required tabindex="9">
                      <br>
                      <div id='bouton_val'>
                           <button type="reset" id = "annuler1" class="btn btn-secondary">Anuller</button>
                           <button type="submit" id = "valider1" class="btn btn-success" tabindex="10">Valider</button>
                      </div>
                    </div>

                    </form>
                    </fieldset>

            			</div>
                  </div>
               </div>
          </div>
          <?php
               //Deconnexion de la BDD
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
          </div>
          <br>
          <!-- Chargement des scripts jquery.min, bootstrap.min et scripts.js -->
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/scripts.js"></script>
       </body>
</html>
