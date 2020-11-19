  <!DOCTYPE html>
  <html>
    <head>

      <title> Page d'accueil </title>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <link rel="stylesheet" type="text/css" href="css/index.css">
      <link rel="stylesheet" type="text/css" href="css/shadow.css">
      </head>
    <body>
      <!-- Header -->
      <header>
       <?php include 'Header.php'; ?>
      </header>

      <!-- Block Recherche rapide -->
      <div class="center-align grey lighten-3">
        <!-- Recherche Rapide -->
        <div class="taille ">

            <h3>Recherche rapide de formations</h3>

          <form method="POST" action="rechercherFormation.php">
          <div class="container ">
            <div class="white margeRecherche containerS">
            <div class="row">
              <div class="input-field col s12 m6">
                <input id="Domaine" name="Domaine" type="text" class="validate" >
                <label for="Domaine">Domaine</label>
              </div>
              <div class="input-field col s12 m6">
                <input id="Diplome" name="Diplome" type="text" class="validate" >
                <label for="diplome">Diplôme</label>
              </div>
            </div>
            <div class="col s3">
                    <input id="valide3" type="submit" class="buttonR" style="vertical-align:middle" value="Rechercher" />
            </div>
          </div>
          </div>
        </div>
      </form>
        </div>

      <div class="grey lighten-3">
      <div class="container grey lighten-3">
         <hr/>
      </div>
      </div>

<div class="center-align grey lighten-3">
    <div class="taille">
       <div class="center-align">
      <h3>Qui sommes-nous ?</h3>
    </div>
    <!-- <div class="grey lighten-3 center-align"> -->
    <div class="container ">
      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m12 l4">
          <div class="containerS white">
          <div class="icon-block">
            <h2 class="center icon-couleur"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Facile à prendre en main</h5>
            <p class="light">Les développeurs d'ACH Intérim ont créé un site web qui permet de rechercher une formation selon plusieurs critères tels que le prix et la localisation par exemple. Vous pouvez également envoyer vos demandes d'inscriptions à ces formations. </p>
          </div>
        </div>
        </div>

        <div class="col s12 m12 l4">
          <div class="containerS white">
          <div class="icon-block">
            <h2 class="center icon-couleur"><i class="material-icons">group</i></h2>
            <h5 class="center">Expérience d'utilisateur</h5>

            <p class="light">En utilisant notre plateforme de recherche de formations, vous gagnez du temps dans vos requêtes. Les outils sont simplifiés afin de permettre à n'importe qui de chercher tout ce dont il a besoin</p>
            </div>
          </div>
        </div>

        <div class="col s12 m12 l4">
          <div class="containerS white">
          <div class="icon-block">
            <h2 class="center icon-couleur"><i class="material-icons" >settings</i></h2>
            <h5 class="center">Sécurité en continue</h5>

            <p class="light">L'équipe de cyber-sécurité engagée par le groupe ACH s'assure de manière continue que toutes les données stockées sont protégées. <br> L'administration veille à ce que les organismes reconnus puissent proposer leurs formations.</p>
          </div>
        </div>
        </div>
      </div>
  </div>
</div>
</div>
      <!-- Footer -->
      <footer class="page-footer  indigo lighten-1">
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


//Affichage d'une formation en détail

function recherchRedirection(){

  /* on récupère les valeurs  */
   var domaineRecherche =  document.getElementById("Domaine").value.split(' ');
   var diplomeRecherche =  document.getElementById("Diplome").value.split(' ');

  /* Envoi des valeurs des différentes barres de recherches  */
   var domaineRechercheResultat = JSON.stringify(domaineRecherche);
   var diplomeRechercheResultat = JSON.stringify(diplomeRecherche);

    var xhttp = getXHR();

             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);

           //réponse xhr (ajax)
          document.getElementById("infosDetailleesFormation").innerHTML = xhttp.responseText ;
          console.log(xhttp.responseText);
document.location.href='testRechercherFormation.php';
        }
        }
        xhttp.open("GET","testRechercherFormation.php.php?domaine="+domaineRechercheResultat+"&diplome="+diplomeRechercheResultat) ;
        xhttp.send(null);

}


</script>


    </body>
  </html>
