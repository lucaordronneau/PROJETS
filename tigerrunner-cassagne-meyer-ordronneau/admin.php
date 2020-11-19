<?php
     //Ouverture de session
     session_start();
     //Chargement du script core.php
     include('scripts/core.php');
     //Ouverture de la BDD
     $bdd = connect();
     //Fonction qui retourne la liste de tous les utilisateurs inscrit
     function getListeInscrits() {
          $listeInscrits = [];     //Initialisation de la liste des inscrits
          $bdd = connect();   //Connexion à la BDD
          $req = "SELECT * FROM Inscrits";   //Selections toute la table Inscrits
          $res = execReq($req,$bdd);    //Execution de la requete
          //Tant que l'on a pas atteint la fin du tableau résultat,
          //   Transforme une ligne du résultat en tableau php
          while ($data = mysqli_fetch_assoc($res)){
               //Récupère l'idUtilisateur
               $idUtilisateur = $data['idUtilisateur'];
               //Ajoute à la liste des inscrits toutes les informations sous forme de tableau
               $listeInscrits[] = array('IdUtilisateur'=>$data['idUtilisateur'], 'Nom'=>$data['nom'], 'Prenom'=>$data['prenom'], 'Email'=>$data['email'], 'Informations personnelles'=>$data['infos'], 'Sexe'=>$data['sexe'], 'Password'=>$data['passe'], 'Id Role'=>$data['idRole'], 'Modifier'=>"<button class='btn btn-primary btn-sm' onclick='affiche_modif(this,$idUtilisateur);'>Modifier <i class='fa fa-edit'></i></button>", 'Supprimer'=>"<button class='btn btn-danger btn-sm' onclick='supprinfos($idUtilisateur)'>Supprimer <i class='fa fa-trash-o'></i></button>"); }
          //Retourne la liste finale
          return $listeInscrits;
          //Déconnexion de la BDD
          deconnect($bdd);
     }
     //Définie la variable $tab et lui affecte la liste des inscrits
     $tab = getListeInscrits();
     //Fonction qui affiche un tableau
     function tableauToHTML($tab) {
               //Si le tableau est vide
             if ( count($tab) <=0 ) {
                  //Retourne NULL
                 return NULL;
             }
             //Définie le résultat
             $res = "";
             //Ajoute la balise table avec ses classes
             $res .= "<table class='table table-striped color_admin'>";
             //Définis le tableau colonnes
             $colonnes = [];
             //ajoute les balises thead et tr au résultat
             $res .= "<thead><tr>";
             //Pour chaque colonne du tableau, ajoute le titre de la colonne au résultat
             foreach($tab[0] as $col=>$valeur) {
                 $res .= "<th>";
                 $res .= $col;
                 $res .= "</th>";
                 //Ajoute le titre de la colonne au tableau $colonnes
                 array_push($colonnes, $col);
             }
             //Fermes les balises thead et tr dans le résultat
             $res .= "</tr></thead>";
             //Pour chaque element du tableau
             foreach($tab as $element) {
                  //Ouvre une balise tr dans le résultat
                 $res .= "<tr>";
                 //Pour chaque colonne du tableau
                 foreach ($colonnes as $col) {
                      //Ajoute "$element[$col]" au résultat dans une balise td de class infos
                     $res .= "<td class='infos'>";
                     $res .= $element[$col];
                     $res .= "</td>";
                 }
                 //ferme la balise tr
                 $res .= "</tr>";
             }
             //Ferme le tableau
             $res .= "</table>";
             //Retourne le résultat
             return $res;
         }
     //Fonction de signalement de message
     function signamessage() {
       //Définie la variable de signalement de message
       $signamessages = [];
       //Connexion à la BDD
       $bdd = connect();
       //Sélectionne l'idEnvoyeur, l'idReceveur et le message signalé
       $req = "SELECT s.idEnvoyeur as envoyeur, s.idReceveur as receveur, message FROM Signalement s, Messagerie m WHERE (s.idEnvoyeur = m.idReceveur) AND (s.idReceveur = m.idEnvoyeur) AND (s.dates = m.dates)";
       //Execution de la requete
       $res = execReq($req,$bdd);
       //Tant que l'on a pas atteint la fin du tableau résultat,
       //   Transforme une ligne du résultat en tableau php
       while ($data = mysqli_fetch_assoc($res)){
          //Récupère dans les variables $envoyeur et $receveur les idEnvoyeur et idReceveur
         $envoyeur = $data['envoyeur'];
         $receveur = $data['receveur'];
         //Ajoute au tableau signamessages les données de la ligne
         $signamessages[] = array('Personne Signalant'=>$data['envoyeur'], 'Personne Signalé'=>$data['receveur'], 'Messages'=>$data['message'],'Ignorer'=>"<button class='btn btn-primary btn-sm' onclick='ignoreradmin(this,$envoyeur,$receveur)'>Ignorer <i class='fa fa-refresh'></i>", 'Supprimer'=>"<button class='btn btn-danger btn-sm' onclick='supprimeMsgadmin(this,$receveur,$envoyeur)'>Supprimer <i class='fa fa-trash-o'></i>");
       }
       //Retourne le tableau signamessages
       return $signamessages;
       //Déconnexion de la BDD
       deconnect($bdd);
     }
     //Définie la variable $tab2 et lui affecte le tableau retourné par la fonction signamessage
     $tab2 = signamessage();
     //Si l'utilisateu n'a pas le droit d'accès à la page (i.e. il n'est pas connecté ou n'a pas le role admin)
     //       le renvoie vers la page index.php?not_autorised
     if ((isset($_SESSION['role']) && $_SESSION['role']!=2) || !isset($_SESSION['role'])) {
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

          <title>Tiger Runner - Administration</title>

          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link href="css/style.css" rel="stylesheet">
          <script src="./scripts/admin/admin.js"></script>
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     </head>
     <body>
          <div class="container-fluid">
               <div class="row">
                    <div class="col-md-12">
                         <div class="page-header">
                              <h1>
                                   <!-- Titre de la page -->
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
                                   <a class='nav-link' href='profil.php'>Profil</a>
                              </li>
                              <li class='nav-item'>
                                   <a class='nav-link' href='./scripts/deconnexion.php'>Déconnexion</a>
                              </li>
                              <li class='nav-item dropdown'>
                                   <a class='nav-link active dropdown-toggle' href='#' id='navbarDropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Admin</a>
                                   <div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>
                                        <a class='dropdown-item' href='admin.php#liste'>Liste des Utilisateurs</a>
                                        <a class='dropdown-item' href='admin.php#suspect'>Liste Messages Suspects</a>
                                        <a class='dropdown-item' href='admin.php#messagerie'>Liste des messageries Utilisateurs</a>
                                   </div>
                              </li>
            			</ul>
                         <hr>
            			<div class="row">
                              <!-- Div contenant la liste des inscrits -->
                              
            				<fieldset class="col-md-11" id="liste">
                                   <h2 id = "info_perso">Liste des Inscrits</h2>
                                   <?php
                                        //Affiche le résultat de la fonction tableauToHTML($tab)
                                        echo tableauToHTML($tab);
                                   ?>
            				</fieldset>
                              <!-- Div contenant la liste des messages signalés -->
                              <fieldset class="col-md-11" id="suspect">
                                   <h2 id = "info_perso">Liste des messages suspects</h2>
                                   <?php
                                        //Affiche le résultat de la fonction tableauToHTML($tab2)
                                        echo tableauToHTML($tab2);
                                   ?>
                              </fieldset>
                              <!-- Div contenant la messagerie des utilisateurs -->
                              <fieldset  class="col-md-11" id="messagerie">
                                   <h2 id = "info_perso">Liste des messageries Utilisateurs</h2>
                                   <div class="row">
                                   <fieldset id = "mess_admin">
                                        <div class="col-md-2">
                                             <!-- Liste de tous les utilisateurs ayant au moins une conversation d'ouverte -->
                                             <SELECT size=7 id="util">
                                             <?php
                                                  //Sélectionne les idUtilisateur, nom et prénom des personnes sont l'idUtilisateur apparait au moins une fois dans la table de messagerie
                                                  $req = "SELECT DISTINCT idUtilisateur,nom,prenom FROM Inscrits i, Messagerie m WHERE idReceveur = idUtilisateur OR idEnvoyeur = idUtilisateur";
                                                  //Execution de la requete
                                                  $res = execReq($req,$bdd);
                                                  //Tant que l'on a pas atteint la fin du tableau résultat,
                                                  //   Transforme une ligne du résultat en tableau php
                                                  while ($row = mysqli_fetch_row($res)) {
                                                       //Affiche les variables $row[1] $row[2] sous forme d'option avec l'attribut onclick load_corres($row[0])
                                                       echo "<option onclick='load_corres($row[0]);'>$row[1] $row[2]</option>";
                                                  }
                                             ?>
                                             </SELECT>
                                        </div>
                                        <div class="col-md-2">
                                             <!-- Liste de tous les utilisateurs ayant au moins une conversation d'ouverte avec la personne selectionné dans la première liste -->
                                             <SELECT size=7 id="corres">
                                             </SELECT>
                                        </div>
                                        </fieldset>
                                        <fieldset class="col-md-9" id = "message">
                                             <!-- Div contenant l'ensemble de la conversation entre les deux personnes séléctionnés -->
                                             <div id="message">
                                             </div>
                                        </fieldset>
                                   </div>
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
          </div>
          <br>
          <script src="js/jquery.min.js"></script>
          <script src="js/bootstrap.min.js"></script>
          <script src="js/scripts.js"></script>
          <?php
               //Déconnexion de la BDD
               deconnect($bdd);
          ?>
       </body>
</html>
