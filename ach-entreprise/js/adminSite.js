//fonction permettant à l'AJAX de fonctionnner
function getXhr() {
  var xhr = null;
  if (window.XMLHttpRequest) // FF & autres
     xhr = new XMLHttpRequest();
  else if (window.ActiveXObject) { // IE < 7
       try {
         xhr = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
         xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
  } else {
    // Objet non supporté par le navigateur
     alert("Votre navigateur ne supporte pas AJAX");
     xhr = false;
  }
  return xhr;
}

//On affiche plus d'informations sur la formation
function afficherPlus(id) {
  var xhr = getXhr();//création d'un objet
  xhr.onreadystatechange = function() {
     // On ne fait quelque chose que si on a tout reç̧u
     // et que le serveur est ok
     if (xhr.readyState == 4 && xhr.status == 200){
        // traitement ré́alisé avec la réponse...
        reponse = xhr.responseText;
        document.getElementById(id).innerHTML = reponse;
     }
  }
  var plus = 1;
  console.log(id);
  xhr.open("GET","utilBDD_admin_site.php?plus="+plus+"&idF="+id) ;//false car on attend que le traitement soit finit; nécéssaire pour la suite du traitement.
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(null);
}

//La formation est en attente, on la rend visible ou non
//la fonction retourne 1 si l'email n'est pas dans la bdd et est donc valide pour une nouvelle insciption; 0 sinon.
function changeStatutA(id,statut) {
  var xhttp = getXhr();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && xhttp.status == 200){
        console.log(this);
        //réponse xhr (ajax)
        console.log(xhttp.responseText);
        window.scroll(1,2);
    }
  }
  console.log(id);
  console.log(statut);
  xhttp.open("GET","utilBDD_admin_site.php?id="+id+"&statutA="+statut) ;//false car on attend que le traitement soit finit; nécéssaire pour la suite du traitement.
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(this);
}

//La formation est visible, on la supprime
//la fonction retourne 1 si l'email n'est pas dans la bdd et est donc valide pour une nouvelle insciption; 0 sinon.
function changeStatutS(id,statut) {
  var xhttp = getXhr();
           xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && xhttp.status == 200){
          console.log(this);
         //réponse xhr (ajax)
        console.log(xhttp.responseText);
        window.scroll(1,2);
      }
      }
  console.log(id);
  console.log(statut);
  console.log("hello");
  xhttp.open("GET","utilBDD_admin_site.php?id="+id+"&statutS="+statut) ;//false car on attend que le traitement soit finit; nécéssaire pour la suite du traitement.
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(null);
}

//La formation est supprimée, on la rend visible
//la fonction retourne 1 si l'email n'est pas dans la bdd et est donc valide pour une nouvelle insciption; 0 sinon.
function changeStatutV(id,statut) {
  var xhttp = getXhr();
           xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && xhttp.status == 200){
          console.log(this);
         //réponse xhr (ajax)
        console.log(xhttp.responseText);
        window.scroll(1,2);
      }
      }
  console.log(id);
  console.log(statut);
  xhttp.open("GET","utilBDD_admin_site.php?id="+id+"&statutV="+statut) ;//false car on attend que le traitement soit finit; nécéssaire pour la suite du traitement.
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(null);
}

function afficheForm() {
  //toutes les conditions sont valides, on fait disparaitre l'étape 1 et apparaitre l'étape 2.
  document.getElementById("containerS").style.display = "none";
  document.getElementById("ajout").style.display = "block";
}
function supForm() {
  //toutes les conditions sont valides, on fait disparaitre l'étape 1 et apparaitre l'étape 2.
  document.getElementById("containerS").style.display = "block";
  document.getElementById("ajout").style.display = "none";
}
