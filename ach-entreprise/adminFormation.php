<?php
// Inclus les éléments nécessaires
include 'initPage.php';
if ($_SESSION['idUser'] > 0) {
	//print_r($_SESSION['idUser']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Page administrateur </title>
	<!--Import materialize.css-->
		  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="stylesheet" href="css/adminFormation.css" />
      <!-- <link rel="stylesheet" type="text/css" href="css/signupin.css"> -->
      <script src="js/adminFormation.js"></script>
</head>

<header id="header">
	<?php include 'Header.php';?>
</header>

<?php
require("utilBDD_admin_organisme.php");

// si les données sont non vides alors appel de la fonction connexionAdmin.
if ((isset($_POST['mail']) && ($_POST['mail'] != "" )) && (isset($_POST['password']) && ($_POST['password'] != "" )) ) {
    connexionAdmin($_POST);
}
// si les données sont non vides alors appel de la fonction creerAdmin.
if ((isset($_POST['email']) && ($_POST['email'] != "" )) && (isset($_POST['mdp']) && ($_POST['mdp'] != "" )) ) {
    creerAdmin($_POST);
}

// si les données sont non vides alors appel de la fonction creerOrganisme.
if ((isset($_POST['emailO']) && ($_POST['emailO'] != "" )) && (isset($_POST['nomO']) && ($_POST['nomO'] != "" )) && (isset($_POST['telO']) && ($_POST['telO'] != "" ))
&& (isset($_POST['presentationO']) && ($_POST['presentationO'] != "" )) && (isset($_POST['numeroO']) && ($_POST['numeroO'] != "" )) && (isset($_POST['rueO']) && ($_POST['rueO'] != "" ))
&& (isset($_POST['postalO']) && ($_POST['postalO'] != "" )) && (isset($_POST['villeO']) && ($_POST['villeO'] != "" )) && (isset($_POST['longitudeO']) && ($_POST['longitudeO'] != "" ))
&& (isset($_POST['latitudeO']) && ($_POST['latitudeO'] != "" )) && (isset($_POST['nomP']) && ($_POST['nomP'] != "" )) && (isset($_POST['prenomP']) && ($_POST['prenomP'] != "" ))
&& (isset($_POST['photoP']) && ($_POST['photoP'] != "" )) ) {
    creerOrganisme($_POST);
}

if ((isset($_POST['nom'])) && (isset($_POST['diplome'])) && (isset($_POST['prix'])) && (isset($_POST['perspective']))
&&  (isset($_POST['description'])) && (isset($_POST['financement'])) && (isset($_POST['domaine']))  && (isset($_POST['dates']))
&& (isset($_POST['duree'])) && ( isset($_POST['numero']))  && (isset($_POST['rue']))  && (isset($_POST['postal']))
&& (isset($_POST['ville'])) && (isset($_POST['longitude'])) &&  (isset($_POST['latitude']))  ){
	$idAdresse = ajouterAdresse(addslashes($_POST['numero']),addslashes($_POST['rue']),addslashes($_POST['postal']),addslashes($_POST['ville']));
	echo $idAdresse;
	$idLieu = ajouterPosition(addslashes($_POST['latitude']),addslashes($_POST['longitude']),addslashes($idAdresse));
	echo $idLieu;
	$idStatut = statut();
	$id = organisme();
	echo "orga".$id;
	if( (!isset($_POST['epreuves'])) ){
		$_POST['epreuves']=' Aucune information  ';
	}
	if( (!isset($_POST['prerequis'])) ){
		$_POST['prerequis']='  Aucune information ';
	}
	echo $_POST['nom'];
	ajouterFormation(addslashes($_POST['nom']),addslashes($_POST['diplome']),addslashes($_POST['prix']),addslashes($_POST['perspective']),addslashes($_POST['description']),addslashes($_POST['domaine']),addslashes($_POST['financement']),addslashes($_POST['epreuves']),addslashes($_POST['prerequis']),addslashes($_POST['dates']),addslashes($_POST['duree']),addslashes($idLieu),addslashes($idStatut),addslashes($id))  ;
}

/*Appel de creer formation*/
if ($_GET['deco'] == 1) {
	deconnexion();
}
?>
<div class="grey lighten-3">
<div class="col l3 offset-l2 s12">
		<?php
		if (isset($_SESSION['idUser'])) {
			echo '<br><div class="grey lighten-3"><form class="form-horizontal grey lighten-3" role="form" action="adminFormation.php?deco=1" method="POST">
								<input class="buttonR3" name="deco" type="submit" value="Déconnexion"/>
						</form><br></div>';
		}
		?>
	</div>
</div>
<!-- Au chargement de la page, on affiche ou pas le formaulaire en fonction de si l'id existe -->
<?php
	if (isset($_SESSION['idUser']) && !EMPTY($_SESSION['idUser'])) {
		echo('<body onload="afficheForm();">');
	} else {
		echo('<body onload="supForm();">');
	}
?>
<div class="grey lighten-3">
	<div class="containerS centrer" id="containerS">
		<div class="form-containerS sign-up-containerS">
	 		<form method="POST" id="creation" name="creation" action="adminFormation.php" >
				<h4>Créer votre compte</h4>
				<div class="input-field">
				<!-- <div class="input-field"> -->
			          <input id="email" name="email" type="email" class="inputS" required>
								<label for="email">Email</label>
							</div>
				<div class="input-field">
			          <input id="mdp" name="mdp" type="password" class="inputS">
								<label for="mdp">Mot de Passe</label>
				</div>
			    	<!--envoie du formulaire-->
		         	<button id="valide2" class="buttonS1">Créer le compte</button>
			</form>
		</div>
			<div class="form-containerS sign-in-containerS">
			 <form method="POST" id="connexion" name="connexion" action="adminFormation.php">
				<h4>Connectez-vous</h4>
				<div class="input-field">
			          <input id="mail" name="mail" type="email" class="inputS">
								<label for="mail">Email</label>
							</div>
				<div class="input-field">
								<input id="password" name="password" type="password" class="inputS">
								<label for="password">Mot de Passe</label>
					</div>
			    	<!--envoie du formulaire-->
		        	<button id="valide1" class="buttonS1">Connexion</button>
			</form>
		</div>
		<div class="overlay-containerS">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h4>De retour !</h4>
					<p>Pour rester en contact avec nous, veuillez vous connecter avec vos informations personnelles.</p>
					<button class="ghost buttonS2" id="signIn">Se connecter</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h4>Vous êtes un organisme ?</h4>
					<p>Entrez vos informations personnelles et commencez quelque chose avec nous</p>
					<button class="ghost buttonS2" id="signUp">Créer un compte</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="grey lighten-3">
<div  id="Modif">
		<div class="grey lighten-3">
	<?php if (($_SESSION['idUser'] > 0)&&(organisme()==0)):
			?>
<div class="grey lighten-3">
			<form class="grey lighten-3" method='POST' id='creation' name='creation' action='adminFormation.php'>
				<div class="grey lighten-3">
				<div class="container">
				<div class="containerS1 white">
					<div class="row">
			<h3>Vous n'avez pas d'organisme, veuillez en créer un :</h3>
							<div class="input-field col s12 m6"><input id='nomO' name='nomO' type='text' class='inputS' placeholder="Entrez le nom de l'organisme"></div>
							<div class="input-field col s12 m6"><input id='emailO' name='emailO' type='text' class='inputS' placeholder="Entrez le mail de l'organisme"></div>
							<div class="input-field col s12 m6"><input id='telO' name='telO' type='text' class='inputS' placeholder="Entrez le numéro de téléphone de l'organisme"></div>
							<div class="input-field col s12 m6"><input id='presentationO' name='presentationO' type='text' class='inputS' placeholder="Entrez une présentation de l'organisme"></div>
							<div class="col s12">
							<h5>Entrez l'adresse de l'organisme :</h5>
						</div>
							<div class="input-field col s12 m6"><input id='numeroO' name='numeroO' type='text' class='inputS' placeholder="Entrez le numéro"></div>
							<div class="input-field col s12 m6"><input id='rueO' name='rueO' type='text' class='inputS' placeholder="Entrez la rue"></div>
							<div class="input-field col s12 m6"><input id='postalO' name='postalO' type='text' class='inputS' placeholder="Entrez le code postal"></div>
							<div class="input-field col s12 m6"><input id='villeO' name='villeO' type='text' class='inputS' placeholder="Entrez la ville"></div>
							<div class="input-field col s12 m6"><input id='longitudeO' name='longitudeO' type='text' class='inputS' placeholder="Entrez la longitude"></div>
							<div class="input-field col s12 m6"><input id='latitudeO' name='latitudeO' type='text' class='inputS' placeholder="Entrez la latitude"></div>
							<div class="col s12 ">
							<h5>Entrez les informations d'un personnel de l'organisme (vous pourrez en ajouter d'autres après) :</h5>
						</div>
							<div class="input-field col s12 m6 l4"><input id='nomP' name='nomP' type='text' class='inputS' placeholder="Entrez le nom du personnel"></div>
							<div class="input-field col s12 m6 l4"><input id='prenomP' name='prenomP' type='text' class='inputS' placeholder="Entrez le prénom du personnel"></div>
							<div class="input-field col s12 m6 l4"><input id='photoP' name='photoP' type='text' class='inputS' placeholder="Entrez la photo du personnel"></div>
					<!--envoie du formulaire-->
					<br>
					<div class="col s12">
						<button id='valide2' class='buttonR'>Créer l'organisme</button>
					</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
</div>
		<br>
		<br>
	<?php  endif; ?>
</div>
</div>
<div class="grey lighten-3">
	<?php
	// si les données sont non vides alors appel de la fonction creerAdmin.
	if (($_SESSION['idUser'] > 0)&&(organisme()>0)) {
			$id = organisme();
			?>
<div class="grey lighten-3">
			<div class="col s8 offset-s2 grey lighten-3 center-align">
				<form class="grey lighten-3" method="POST" action="adminFormation.php">
					<div class="grey lighten-3">
					<h3 class="center-align">
		    		Ajouter une formation
					</h3>

					<div class="container center-align">
						<div class="containerS1 white">
						<div class="row">
							<div class="col s12 m12 l4 light">
							<div class="input-field col s12">
								<input id="nom"  name="nom" type="text" class="validate" required>
								<label for="nom">Nom Formation</label>
							</div>
							<div class="input-field col s12 m6">
							   <input id="diplome" name="diplome"  type="text"  class="validate">
							   <label for="diplome">Nom du diplôme</label>
							</div>
							<div class="input-field col s12 m6">
							    <input id="domaine"  name="domaine" type="text" class="validate">
							    <label for="domaine">Domaine</label>
							</div>
							<div class="input-field col s12">
				    		<textarea  id="perspective" name="perspective" type="text"  class="materialize-textarea"></textarea>
				    		<label for="perspective">Perspective d'avenir</label>
							</div>
							<div class="input-field col s12 m12">
				    		<textarea id="description"  name="description" type="text" class="materialize-textarea"required ></textarea>
				    		<label for="description">Description</label>
							</div>
							<div class="input-field col s12 m12">
								<textarea id="epreuves"  name="epreuves" type="text" class="materialize-textarea"></textarea>
								<label for="epreuves">Epreuves</label>
							</div>
							<div class="input-field col s12 m12">
								<textarea id="prerequis"  name="prerequis" type="text" class="materialize-textarea"></textarea>
								<label for="prerequis">Pré-requis</label>
							</div>
						</div>
						<div  class="col s12 m12 l4 ">
							<div class="input-field col s12">
				    		<input id="pickdate" name="dates"   type="date" min="2019-12-25" max="2050-12-31" class="datepicker" required>
				    		<label for="pckdate">Début de la formation</label>
							</div>
							<div class="input-field col s12">
				    		<input id="duree"  name="duree" type="text" class="validate" required>
				    		<label for="duree">Durée</label>
							</div>
							<div class="input-field col s12">
				    		<input id="prix"  name="prix" type="text" maxlength="5" pattern=[0-9]{1,10} class="validate" required>
				    		<label for="prix">Prix</label>
							</div>

							<div class="input-field col s12 ">
				    		<input id="financement" name ="financement" type="text" class="validate" required>
				    		<label for="financement">Financement</label>
							</div>
						</div>
					<div  class="col s12 m12 l4">
							<div class="input-field col s12 m6">
					    	<input id="numero" name="numero" type="text" maxlength="5" pattern=[0-9]{1,5} class="validate" required>
					    	<label for="numero">N°</label>
							</div>
							<div class="input-field col s12">
				    		<input id="rue" name="rue" type="text" class="validate" required>
				    		<label for="rue">Rue</label>
							</div>
							<div class="input-field col s12 m6">
				    		<input id="postal" name="postal" type="text" maxlength="5" pattern="[0-9]{5}" class="validate" required>
				    	 	<label for="postal">Code postal</label>
							</div>
							<div class="input-field col s12">
				    		<input id="ville" name ="ville" type="text" class="validate" required>
				    		<label for="ville">Ville</label>
							</div>
	<div class="input-field col s12">
							<a href="https://www.coordonnees-gps.fr/"  target = "_blank" >Calculer les coordonnées GPS de l'adresse</a>
	</div>
							<div class="input-field col s12">
								<input id="longitude" name ="longitude" type="text" maxlength="15" pattern=[0-9.]{1,15} class="validate" required>
								<label for="longitude">Longitude</label>
							</div>
							<div class="input-field col s12">
								<input id="latitude" name ="latitude" type="text" maxlength="15" pattern=[0-9.]{1,15} class="validate" required>
								<label for="latitude">Latitude</label>
							</div>
					</div>
						</div>
					<div class="center-align ">
		    					<!--envoie du formulaire-->
									<!-- <input id="valide3" type="submit" class="buttonR" value="Ajouter la formation" /> -->
		    					<input id="valide3" type="submit" class="buttonR" value="Ajouter la formation" />
	    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
	        async defer>
	    </script>
					</div>
				</div>
				</div>
		</div>

		    </form>
				</div>
		<!-- </div> -->
			<?php
	}
	?>
</div>
	<?php
	// si les données sont non vides alors appel de la fonction creerAdmin.
	if (($_SESSION['idUser'] > 0)&&(organisme()>0)) {
			$id = organisme();
			echo "<div class='grey lighten-3'><h4 class='center-align'>Voici toutes vos formations :</h4></div>";
	    affichageFormation($id);
	}
	?>


</body>
<footer class="indigo lighten-1 page-footer">
	<?php include 'Footer.php';?>
</footer>
	<script type="text/javascript" src="js/signupin.js"></script>

</html>
