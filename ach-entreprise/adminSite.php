<?php
// Inclus les éléments nécessaires
include 'initPage.php';
if ($_SESSION['idUser'] > 0) {
	//print_r($_SESSION['idUser']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
		<title> Administrateur ACH Intérim</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link rel="stylesheet" type="text/css" href="css/shadow.css">
		<link rel="stylesheet" type="text/css" href="css/adminSite.css">
    <script src="js/adminSite.js"></script>
</head>

<header id="header">
<?php include 'Header.php';?>
</header>

<?php
require("utilBDD_admin_site.php");

// si les données sont non vides alors appel de la fonction connexionAdmin.
if ((isset($_POST['mail']) && ($_POST['mail'] != "" )) && (isset($_POST['password']) && ($_POST['password'] != "" )) ) {
    connexionAdmin($_POST);
}
// si les données sont non vides alors appel de la fonction creerAdmin.
if ((isset($_POST['email']) && ($_POST['email'] != "" )) && (isset($_POST['mdp']) && ($_POST['mdp'] != "" )) && (isset($_POST['selectRole']) && ($_POST['selectRole'] != "" )) ) {
    creerAdmin($_POST);
}
// si les données sont non vides alors appel de la fonction creerAdmin.
if ((isset($_POST['emaile']) && ($_POST['emaile'] != "" )) && (isset($_POST['modifRole']) && ($_POST['modifRole'] != "" )) ) {
    modifAdmin($_POST);
}
if ($_GET['deco'] == 1) {
	deconnexion();
}
?>
<body>


<!-- Au chargement de la page, on affiche ou pas le formaulaire en fonction de si l'id existe -->
<?php
	if (isset($_SESSION['idUser']) && !EMPTY($_SESSION['idUser'])) {
		echo('<body onload="afficheForm();">');
	} else {
		echo('<body onload="supForm();">');
	}
?>
<div class="grey lighten-3">
<div id="containerS">
<div class="container" >
	<div class="containerS1 white">
		<h3 class="center-align">Connectez-vous</h3>
		<div class="row">
			 <form method="POST" id="connexion" name="connexion" action="adminSite.php">
				 <div class="input-field col s12 m6">
			      <input id="mail" name="mail" type="email">
						<label for="mail">Email</label>
				</div>
				<div class="input-field col s12 m6">
 								<input id="password" name="password" type="password">
								<label for="password">Mot de Passe</label>
				</div>
			    	<!--envoie du formulaire-->
		     <div class="center-align"><button id="valide1" class="buttonR2">Connexion</button></div>
			</form>
		</div>
	</div>
</div>
</div>
<div>

<div id="ajout">
	<div class="col center-align">
		<?php
			if (isset($_SESSION['idUser'])) {
				echo '<br><form class="form-horizontal" role="form" action="adminSite.php?deco=1" method="POST">
									<input class="buttonR3" name="deco" type="submit" value="Déconnexion"/>
									</form><br>';
		}
		?>
	</div>
<div class="container">
	<div class="containerS white">
	<!-- On affiche les inscriptions non traitées -->
	<div class="col s12 center-align">
		<?php
			if (isset($_SESSION['idUser'])) {
				echo "<br>";
				echo "<b class='titreRes21'>Voici la liste des inscriptions en attente</b> :";
				echo "</div>";
				afficheInscriptions();
		}
		?>
	</div>
</div>
<div class="container">
	<div class="containerS white">
	<!-- On affiche les inscriptions traitées -->
		<div class="col s12 center-align">
			<?php
				if (isset($_SESSION['idUser'])) {
					echo "<br>";
					echo "<b class='titreRes21'>Voici la liste des inscriptions traitées</b> :";
					echo "</div>";
					afficheInscriptionsA();
					echo "<br><br>";
			}
			?>
		</div>
	</div>
</div>


<!-- On affiche les formations qui sont non traitées -->
<div class="container">
 	<div class="containerS white">
	<div class="titreRes21 center-align ">
		Voici la liste des formations en attente :
	</div>
    <?php if ($_SESSION['idUser'] > 0):
			afficheFormations();
    endif; ?>
	</div>
	<div class="containerS white">
	<div class="titreRes21 center-align">
			Voici la liste des formations acceptées :
	</div>
	     <?php if ($_SESSION['idUser'] > 0):
				afficheFormationsToutes();
	     endif; ?>
	</div>
	<div class="containerS white">
		<div class="titreRes21 center-align">
	 		Voici la liste des formations refusées :
	 	</div>
	 	  <?php if ($_SESSION['idUser'] > 0):
	 			afficheFormationsSup();
	 	  endif; ?>
	</div>
</div>

<div class="container">
	<div class="containerS white">
	<div  id="Formulaire">
		<?php if (($_SESSION['idUser'] > 0)&&(verifAdmin()==1)):
	 			?>
				<form method='POST' id='creation' name='creation' action='adminSite.php'>
 				<div class="titreRes21 center-align">Création d'un administrateur :</div>
				<div class="row">
					<div class="input-field col s12 m6">
								<input id='nom' name='nom' type='text' class='inputS' placeholder="Nom">
					</div>
					<div class="input-field col s12 m6">
								<input id='prenom' name='prenom' type='text' class='inputS' placeholder="Prénom">
					</div>
									<div class="input-field col s12 m6">
				 			          <input id='email' name='email' type='text' class='validate'>
												<label for="email">Email</label>
				          </div>
					<div class="input-field col s12 m6">
								<input id='mdp' name='mdp' type='password' class='inputS' placeholder='Mot de Passe'>
					</div>
					<div class="input-field col s12 m6">
								<select name='selectRole'>
						      <option value='' disabled selected>Choisissez le rôle de l'utilisateur :</option>
						      <option value='1'>Personnel</option>
						      <option value='2'>Régulateur</option>
						      <option value='3'>Administrateur</option>
						    </select>
					</div>
 			    	<!--envoie du formulaire-->
 		        	<div class="center-align"><button id='valide2' class='buttonR2'>Créer le compte</button></div>
					</div>
			</form>
	 	  <?php endif; ?>
	</div>
</div>
<div class="containerS white">
	<div  id="Modif">
		<?php if (($_SESSION['idUser'] > 0)&&(verifAdmin()==1)):
	 			?>
				<form method='POST' id='creation' name='creation' action='adminSite.php'>
 				<div class="titreRes21 center-align">Modifier les droits d'un administrateur</div>
				<div class="row">
					<div class="input-field col s12 m6">
 			          <input id='emaile' name='emaile' type='text' class='inputS' placeholder="Entrez le mail de l'utilisateur à modifier">
					</div>
					<div class="input-field col s12 m6">
								<select name='modifRole'>
						      <option value='' disabled selected>Choisissez le rôle de l'utilisateur :</option>
						      <option value='1'>Personnel</option>
						      <option value='2'>Régulateur</option>
						      <option value='3'>Administrateur</option>
						    </select>
							</div>
				</div>
 			    	<!--envoie du formulaire-->
 		        	<div class="center-align"><button id='valide2' class='buttonR2'>Mettre à jour le compte</button></div>
 			</form>
	 	<?php  endif; ?>
	</div>
</div>
</div>
</div>
	</div>
	<br>
</body>
<footer class="page-footer  indigo lighten-1">
	<?php include 'Footer.php'; ?>
</footer>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="materialize/js/materialize.min.js"></script>
<script type="text/javascript" src="js/signupin.js"></script>
<!-- Initialistation du javascript pour la liste déroulante -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var options = {};
    var instances = M.FormSelect.init(elems, options);
  });
</script>


</html>
