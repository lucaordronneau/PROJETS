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
//la fonction retourne 1 si l'email n'est pas dans la bdd et est donc valide pour une nouvelle insciption; 0 sinon.
function decoAjax() {
  var xhr = getXhr();//création d'un objet
  // On définit que l'on va faire à chq changement d'état
  xhr.onreadystatechange = function() {
     // On ne fait quelque chose que si on a tout reç̧u
     // et que le serveur est ok
     if (xhr.readyState == 4 && xhr.status == 200){
        // traitement réalisé avec la réponse...
        reponse = xhr.responseText;
        verif = reponse;//on stock la réponse dans la variable globale
     }
  }
  //document.getElementById("containerS").style.display = "none";
  //document.getElementById("ajout").style.display = "block";
  xhr.open("POST","adminFormation.php",false) ;//false car on attend que le traitement soit finit; nécéssaire pour la suite du traitement.
  xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
  //xhr.send("$fc="+1);
  //document.getElementById("valide").removeAttribute("disabled");
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
function afficheForm() {
  //toutes les conditions sont valides, on fait disparaitre l'étape 1 et apparaitre l'étape 2.
  document.getElementById("containerS").style.display = "none";
  //document.getElementById("ajout").style.display = "block";
}
function supForm() {
  //toutes les conditions sont valides, on fait disparaitre l'étape 1 et apparaitre l'étape 2.
  document.getElementById("containerS").style.display = "block";
  document.getElementById("ajout").style.display = "none";
}
