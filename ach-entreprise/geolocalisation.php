<!DOCTYPE html>
<?php
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.
?>
<html>
	<head>
		<meta charset="utf-8">
		<script src="https://maps.google.com/maps/api/js?key=AIzaSyCTIn22N0OJ6j4PjvTkqi8ROqN_XhKZUyQ" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script async type="text/javascript">
			var map = null;

      function initMap() {
    	  map = new google.maps.Map(document.getElementById("map"), {
    		center: new google.maps.LatLng(46.628933, 2.446417),
    		zoom: 5,
    		mapTypeId: google.maps.MapTypeId.ROADMAP,
    		mapTypeControl: true,
    		mapTypeControlOptions: {
    			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
    		},
    			navigationControl: true,
    			navigationControlOptions: {
    			style: google.maps.NavigationControlStyle.ZOOM_PAN
    		}
    	});
    	// Nous appelons la fonction ajax de jQuery
    	$.ajax({

    		// On pointe vers le fichier selectData.php
    		url : "selectData.php",
    	}).done(function(json){ // Si on obtient une réponse, elle est stockée dans la variable json
    		// On construit l'objet villes à partir de la variable json
    		var villes = JSON.parse(json);
        console.log(villes);
    		// On parcourt l'objet villes
        for (var i = 0; i < villes.length; i++){
          var marker = new google.maps.Marker({
            // parseFloat nous permet de transformer la latitude et la longitude en nombre décimal
            position: {lat: parseFloat(villes[i]["latitude"]), lng: parseFloat(villes[i]["longitude"])},
            title: villes[i]["idLieu"],
            map: map
          });
        }
    	});
    }
			window.onload = function(){
				// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
				initMap();
			};
		</script>
		<style type="text/css">
			#map{ /* la carte DOIT avoir une hauteur sinon elle n'apparaît pas */
				height:400px;
			}
		</style>
		<title>Carte</title>
	</head>
	<body>
		<div id="map">
			<!-- Ici s'affichera la carte -->
		</div>
	</body>
</html>
