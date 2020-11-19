function getXHR() {
  var xhr = null;
  if (window.XMLHttpRequest) // FF & autres
     xhr = new XMLHttpRequest();
  else if (window.ActiveXObject) { // IE < 7
       try {
         xhr = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
         xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
  } else { // Objet non supporté par le navigateur
     alert("Votre navigateur ne supporte pas AJAX");
     xhr = false;
  }
  return xhr;
}

function load_corres(idUtil) {
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // affichage du resultat dans le div d'id "corres"
             var res = xhr.responseText;
             document.getElementById('corres').innerHTML = res;
          }
     }
     // Envoie en POST l'idUtilisateur au script message.php
     xhr.open('POST','./scripts/admin/load_corres.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil);
}

function load_mess_adm(idUtil,idCorres) {
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
            // affichage du resultat dans le div d'id "message"
             var res = xhr.responseText;
             document.getElementById('message').innerHTML = res;

          }
     }
     // Envoie en POST l'idUtilisateur et l'idCorrespondant au script message.php
     xhr.open('POST','./scripts/admin/message.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres);
}

function supprimeMsgadmin(b,idUtil,idCorres) {
   btn = b;
   filsTD = btn.parentNode.parentNode.childNodes;
     var message = filsTD[2].firstChild.nodeValue
   var xhr = getXHR();
   // On définit que l'on va faire à chq changement d'état
   xhr.onreadystatechange = function() {
        // On ne fait quelque chose que si on a tout reçu
        // et que le serveur est ok
        if (xhr.readyState == 4 && xhr.status == 200){
           // Alerte informant que le message a bien été supprimé
           alert('Vous avez bien supprimé ce message !');
        }
   }
   // Envoie en POST l'idUtilisateur, l'idCorrespondant et le message au script supprimerMsg.php
   xhr.open('POST','./scripts/admin/supprimerMsg.php',true) ;
   xhr.setRequestHeader('Content-Type',
       'application/x-www-form-urlencoded;charset=utf-8');
   xhr.send("util="+idUtil+"&corres="+idCorres+"&message="+message);
}

function ignoreradmin(b,idUtil,idCorres) {
     btn = b;
     filsTD = btn.parentNode.parentNode.childNodes;
     var message = filsTD[2].firstChild.nodeValue
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // Alerte informant que le signalement a bien été ignoré
             alert('Vous avez bien ignoré le signalement de ce message !');

          }
     }
     // Envoie en POST l'idUtilisateur, l'idCorrespondant et le message au script ignorer.php
     xhr.open('POST','./scripts/admin/ignorer.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres+"&message="+message);
}

function affiche_modif(b, idUtil) {
  filsTD = b.parentNode.parentNode.childNodes;
  btn = b;
  for (var i = 1 ; i < 5 ; i++) {

  ancienneVal = filsTD[i].innerHTML
  filsTD[i].innerHTML = "<input type='text' size='15' value='"+ancienneVal+"'>"

  }
  ancienneVal1 = filsTD[5].innerHTML
  filsTD[5].innerHTML = "<input type='text' size='2' value='"+ancienneVal1+"'>"

  ancienneVal = filsTD[7].innerHTML
  filsTD[7].innerHTML = "<input type='text' size='2' value='"+ancienneVal+"'>"

  	btn.className = 'btn btn-success btn-sm'
    btn.innerHTML = "Valider <i class='fa fa-check'>";
    btn.setAttribute("onclick","valideinfos(this, "+idUtil+")");

}

function valideinfos(b,idUtil) {
      pere = b.parentNode.parentNode;
      filsTD = b.parentNode.parentNode.childNodes;
      btn = b;

      btn.className = 'btn btn-primary btn-sm';
      btn.innerHTML = "Modifier <i class='fa fa-edit'>";
      btn.setAttribute("onclick","affiche_modif(this, "+idUtil+")");

      for (var i = 1 ; i < 6 ; i++) {

           newVal = filsTD[i].firstChild.value
           filsTD[i].innerHTML = newVal
     }

     newVal = filsTD[7].firstChild.value
     filsTD[7].innerHTML = newVal

     var xhr = getXHR();
     //Récupères les valeurs de nom, prénom, email, info, sexe et role
     var nom=pere.getElementsByClassName('infos')[1].firstChild.nodeValue;
     var prenom=pere.getElementsByClassName('infos')[2].firstChild.nodeValue;
     var email=pere.getElementsByClassName('infos')[3].firstChild.nodeValue;
     var info=pere.getElementsByClassName('infos')[4].firstChild.nodeValue;
     var sexe=pere.getElementsByClassName('infos')[5].firstChild.nodeValue;
     var role=pere.getElementsByClassName('infos')[7].firstChild.nodeValue;

     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
      // On ne fait quelque chose que si on a tout reçu
      // et que le serveur est ok
      if (xhr.readyState == 4 && xhr.status == 200){
         // Alerte informant que les informations ont bien été modifiées
         //alert('Informations modifiées !');

      }
    }

     // Envoie en POST l'idUtilisateur,le nom, le prénom, l'email, les informations, le sexe et le role au script modifier.php
     xhr.open('POST','./scripts/admin/modifier.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&nom="+nom+"&prenom="+prenom+"&email="+email+"&info="+info+"&sexe="+sexe+"&role="+role);
}

function supprinfos(idUtil) {
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // Alerte informant que l'utilisateur a bien été supprimé.
             alert('Vous avez bien supprimé cet utilisateur !');

          }
     }
     // Envoie en POST l'idUtilisateur au script Supprime.php
     xhr.open('POST','./scripts/admin/supprime.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil);
}
