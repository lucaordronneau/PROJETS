<?php
include('initPage.php');
include('Header.php');

 // VERIF INPUT USER WITH output sql
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.
include_once("utilBDD_affichageFormation.php");


if(isset($_POST['Diplome'])){
 $diplome = $_POST['Diplome'];
}

if(isset($_POST['Domaine'])){
 $domaine = $_POST['Domaine'];
}

?>


<head>

  <title>Recherche formations</title>

  <link rel="stylesheet" type="text/css" href="css/rechercheFormation.css">
  <link rel="stylesheet" type="text/css" href="css/infosFormation.css">
  <link rel="stylesheet" type="text/css" href="css/shadow.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
      console.log(json);
      var villes = JSON.parse(json);
      console.log(villes);
      // On parcourt l'objet villes
      for (var i = 0; i < villes.length; i++){
        var marker = new google.maps.Marker({
          // parseFloat nous permet de transformer la latitude et la longitude en nombre décimal
          position: {lat: parseFloat(villes[i]["latitude"]), lng: parseFloat(villes[i]["longitude"])},
          title: "Nom formation : "+villes[i]["nom"]+"\nDate : "+villes[i]["dates"]+"\nDuree : "+villes[i]["duree"]+"\nPrix : "+villes[i]["prix"]+" €",
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
<head>

<body >
   <!-- Block Recherche rapide -->
   <div id="map" onmouseover="chercherFormation();">
     <!-- Ici s'affichera la carte -->
   </div>

<div class=" grey lighten-3">
   <!-- Recherche Rapide -->
     <div class="center-align">
       <h2>Recherche de formations</h2>
   </div>

   <div class="container ">
     <div class="white containerS">
     <div class="row">
       <form class="form-inline ml-auto" action ="#">
         <div class="input-field col s12 m12 l4">
         <input class="a" type="text" id='Domaine' value="<?php if (isset($diplome)){ echo $domaine; }?>"  onkeyup="chercherFormation()" name='rechercher'  >
         <label for="Domaine">Domaine</label>
       </div>
       </form>


       <form class="form-inline ml-auto" action ="#">
         <div class="input-field col s12 m12 l4">
         <input class="a" type="text" id='Diplome' value="<?php if (isset($diplome)){ echo $diplome; }?>" onkeyup="chercherFormation()" name='rechercher'  >
         <label for="Diplome">Diplôme</label>
         </div>
       </form>


       <form class="form-inline ml-auto" action ="#">
          <div class="input-field col s12 m12 l4">
         <input class="a" type="text" id='Departement' onkeyup="chercherFormation()" name='rechercher'  >
         <label for="Departement">Département</label>
         </div>
       </form>


     </div>

 </div>


 </div>
 <div class="grey lighten-3 margerhr">
 <div class="container grey lighten-3">
    <hr/>
 </div>
 </div>
   <!-- Un élément HTML pour recueillir la carte
   <div class="container col s12 center-align" id="map_canvas"></div>
 -->


      <div id ="infosDesFormations">

<?php
/* Affichage des différentes formations */
affichageFormation(); ?>
      </div>

</diV>
</div>

<!-- Bloc utilisé pour afficher les détails d'une formation -->
<div class="grey lighten-3" id="infosDetailleesFormation" style="visibility: hidden" ></div>

<!-- Bloc utilisé pour afficher les détails d'un organisme -->
<div id="infosDetailleesOrganisme" style="visibility: hidden" ></div>



</body>



<?include('Footer.php');?>


<!-- Fonction JScript-->
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


//Affichage d'une formation en détail

function detail_formation(id){

    /* Récupère l'id de Formation */
   var var_id = document.getElementById(id).value;

   /* Bloc initial avec bar de recherche + infos des formations */
   var infosDesFormations = document.getElementById('infosDesFormations');

   /* Nouveau bloc avec informations détailles d'une formation*/

   var infosDetailleesFormation = document.getElementById('infosDetailleesFormation');

    //on masque toutes les formations ainsi que la bar de recherche
    infosDesFormations.style.display = 'none';


    // on affiche le bloc avec les informations détaillées d'une formation
      infosDetailleesFormation.style.visibility = 'visible';

    var xhttp = getXHR();

             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);

           //réponse xhr (ajax)
          document.getElementById("infosDetailleesFormation").innerHTML = xhttp.responseText ;
          console.log(xhttp.responseText);

        }
        }
        xhttp.open("GET","infosFormation.php?idForm="+var_id) ;
        xhttp.send(null);

}

//Affichage d'un organisme en détail

function detail_organisme(id){

    /* Récupère l'id de Formation */
   var var_id = document.getElementById(id).value;

   /* Bloc infos détaillées des formations */
   var infosDetailleesFormation = document.getElementById('infosDetailleesFormation');

   /* Nouveau bloc avec informations détailles sur l'organisme d'une formation*/
   var infosDetailleesOrganisme = document.getElementById('infosDetailleesOrganisme');

    //on masque toutes les formations ainsi que la bar de recherche
    infosDetailleesFormation.style.display = 'none';


    // on affiche le bloc avec les informations détaillées d'une formation
      infosDetailleesOrganisme.style.visibility = 'visible';

    var xhttp = getXHR();

             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);

           //réponse xhr (ajax)
          document.getElementById("infosDetailleesOrganisme").innerHTML = xhttp.responseText ;

        }
        }
        xhttp.open("GET","infosFormation.php?idOrga="+var_id) ;
        xhttp.send(null);

}

/*Retour lors de l'affichage des informations d'une information*/
function retour_infosFormation(){


   /* Bloc infos détaillées des formations */
   var infosDetailleesFormation = document.getElementById('infosDetailleesFormation');

   /* Nouveau bloc avec informations détailles sur l'organisme d'une formation*/
   var infosDetailleesOrganisme = document.getElementById('infosDetailleesOrganisme');

    //affiche les informations de la formation
    infosDetailleesFormation.style.display = 'initial';


    // masque le bloc avec les informations détaillées d'une formation
      infosDetailleesOrganisme.style.visibility = 'hidden';

    var xhttp = getXHR();

             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);

           //réponse xhr (ajax)
          document.getElementById("infosDetailleesOrganisme").innerHTML = xhttp.responseText ;

        }
        }
        xhttp.open("GET","infosFormation.php?") ;
        xhttp.send(null);

}


function chercherFormation(){

/* on récupère les valeurs  */
 var domaineRecherche =  document.getElementById("Domaine").value.split(' ');
 var diplomeRecherche =  document.getElementById("Diplome").value.split(' ');
 var departementRecherche =  document.getElementById("Departement").value.split(' ');

/* Envoi des valeurs des différentes barres de recherches  */
 var domaineRechercheResultat = JSON.stringify(domaineRecherche);
 var diplomeRechercheResultat = JSON.stringify(diplomeRecherche);
 var departementRechercheResultat = JSON.stringify(departementRecherche);

 var xhr = getXHR();
xhr.onreadystatechange = function() {
  if (xhr.readyState == 4 && xhr.status == 200){
    document.getElementById("infosDesFormations").innerHTML = xhr.responseText;

  }
}
xhr.open("GET","resultatRechercheFormation.php?domaine="+domaineRechercheResultat+"&diplome="+diplomeRechercheResultat+"&departement="+departementRechercheResultat,true);
xhr.send(null);
}

</script>

<footer class="page-footer  indigo lighten-1">
  <?php include 'Footer.php'; ?>
</footer>
