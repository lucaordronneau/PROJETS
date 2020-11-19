<!DOCTYPE html>
<html>
<head>
	<title> Ajout Formation </title>
	<!--Import materialize.css-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

      <link rel="stylesheet" type="text/css" href="css/ajoutFormation.css">
      <!--Import Google Icon Font-->
			<script>
			var onSubmit = function(token) {
          console.log('success!');
        };

        var onloadCallback = function() {
          grecaptcha.render('submit', {
            'sitekey' : '6LeXl8gUAAAAAKNUwiV7xAyaI_xtKo7v82HJyy_M',
            'callback' : onSubmit
          });
        };
    	</script>

</head>
<header>
	 <?php include 'Header.php'; ?>
</header>

<body>
	<!-- Header -->


<?php
include_once('core.php');

require('utilBDD_ajouteFormation.php');
?>

<?php



if (   (isset($_POST['nom'])) && (isset($_POST['diplome'])) && (isset($_POST['prix'])) && (isset($_POST['perspective'])) &&  (isset($_POST['description'])) && (isset($_POST['financement'])) && (isset($_POST['domaine']))  && (isset($_POST['dates'])) && (isset($_POST['duree'])) && ( isset($_POST['numero']))  && (isset($_POST['rue']))  && (isset($_POST['postal']))  && (isset($_POST['ville'])) && (isset($_POST['longitude'])) &&  (isset($_POST['latitude']))  ){



$idAdresse = ajouterAdresse(addslashes($_POST['numero']),addslashes($_POST['rue']),addslashes($_POST['postal']),addslashes($_POST['ville']));
$idLieu = ajouterPosition(addslashes($_POST['latitude']),addslashes($_POST['longitude']),addslashes($idAdresse));
$idStatut = statut();


    /* récuperer l'organisme de l'utilisateur connectée*/
    $idOrganisme =1;


if( (!isset($_POST['epreuves'])) ){
	$_POST['epreuves']=' Aucune information  ';
}
if( (!isset($_POST['prerequis'])) ){
	$_POST['prerequis']='  Aucune information ';
}



ajouterFormation(addslashes($_POST['nom']),addslashes($_POST['diplome']),addslashes($_POST['prix']),addslashes($_POST['perspective']),addslashes($_POST['description']),addslashes($_POST['domaine']),addslashes($_POST['financement']),addslashes($_POST['epreuves']),addslashes($_POST['prerequis']),addslashes($_POST['dates']),addslashes($_POST['duree']),addslashes($idLieu),addslashes($idStatut),addslashes($idOrganisme))  ;


}

?>

		<div class="col s8 offset-s2 grey lighten-3">
			<form method="POST" action="ajoutFormation.php">
				<div class="taille">
				<h3 class="center-align">
	    		Ajouter une formation
				</h3>
				<div class="container">
					<div class="containerS white">
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
						<div class="input-field col s11 m5">
			    		<input id="prix"  name="prix" type="text" maxlength="5" pattern=[0-9]{1,10} class="validate" required>
			    		<label for="prix">Prix</label>
						</div>
						<div class="input-field col s1 m1">
			    		<label>€</label>
						</div>
						<div class="input-field col s12 m6">
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
							<input id="latitude" name ="latitude" type="text" maxlength="15" pattern=[0-9.-]{1,15} class="validate" required>
							<label for="latitude">Latitude</label>
						</div>
						<div class="input-field col s12">
							<input id="longitude" name ="longitude" type="text" maxlength="15" pattern=[0-9.-]{1,15} class="validate" required>
							<label for="longitude">Longitude</label>
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
	</div>
	    </form>
	</div>
	<!-- Footer -->
	<footer class="page-footer indigo lighten-1">
		<?php include 'Footer.php'; ?>
	</footer>




<script>


//Fonction Ajax
    function getXHR() {
        var xhr = null;
        if (window.XMLHttpRequest) // FF & autres
            xhr = new XMLHttpRequest();
        else if (window.ActiveXObject) { // IE < 7
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
       }        catch (e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
        } else { // Objet non supporté par le navigateur
            alert("Votre navigateur ne supporte pas AJAX");
            xhr = false;
        }
  return xhr;
}


</script>





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
	<script type="text/javascript" src="js/top.js"></script>
	<script type="text/javascript" src="js/dropdown.js"></script>
	<script type="text/javascript" src="js/index.js"></script>

	</body>
</html>
