function prive_field(session_id,profil_id) {
     //Récupère les balises prive_field, messagerie_prive, messagerie, liste_ami, liste_ami_pc
     field = document.getElementById('prive_field');
     messagerie_prive = document.getElementById('messagerie_prive');
     messagerie = document.getElementById('messagerie');
     liste_ami = document.getElementById('liste_ami');
     liste_ami_pv = document.getElementById('liste_ami_pv');
     if (session_id == profil_id) {
          //Si la page de profil à afficher est celle du joueur, alors
          //   rend visible ses balises
          //        - Infos personnelles
          //        - Messagerie "Privée"
          //        - Liste d'amis "Privée"
          //   rend invisible les balises
          //        - Messagerie "Publique"
          //        - Liste d'ami "Publique"
          field.style.visibility = "visible";
          field.style.display = "block";
          messagerie_prive.style.visibility = "visible";
          messagerie_prive.style.display = "block";
          messagerie.style.visibility = "hidden";
          messagerie.style.display = "none";
          liste_ami.style.visibility = "hidden";
          liste_ami.style.display = "none";
          liste_ami_pv.style.visibility = "visible";
          liste_ami_pv.style.display = "block";
     } else {
          //Si la page de profil à afficher est celle d'un autre joueur, alors
          //   rend invisible ses balises
          //        - Infos personnelles
          //        - Messagerie "Privée"
          //        - Liste d'amis "Privée"
          //   rend visible les balises
          //        - Messagerie "Publique"
          //        - Liste d'ami "Publique"
          field.style.visibility = "hidden";
          field.style.display = "none";
          messagerie_prive.style.visibility = "hidden";
          messagerie_prive.style.display = "none";
          messagerie.style.visibility = "visible";
          messagerie.style.display = "block";
          liste_ami.style.visibility = "visible";
          liste_ami.style.display = "block";
          liste_ami_pv.style.visibility = "hidden";
          liste_ami_pv.style.display = "none";
     }
}

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

function signal(b,idUtil,idCorres){
     //récupère le bouton
     btn = b;
     //Récupère le parent du bouton
     filsTD = btn.parentNode
     //Récupère le texte du parent du bouton
     var message = filsTD.textContent
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // Alerte informant que le message a bien été signalé.
             alert('Vous avez bien signalé ce message !');
          }
     }
     // Envoie les informations idUtilisateur, idCorrespondant et message en POST au script signalement.php
     xhr.open('POST','./scripts/profil/signalement.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres+"&message="+message);
     //change la classe du bouton
     btn.className = 'fa fa-refresh';
     //change l'attribut onclick du bouton
     btn.setAttribute("onclick","ignorer(this, "+idUtil+", "+idCorres+")");
}

function ignorer(b,idUtil,idCorres) {
     //récupère le bouton
     btn = b;
     //Récupère le parent du bouton
     filsTD = btn.parentNode
     //Récupère le texte du parent du bouton
     var message = filsTD.textContent
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // Alerte informant que le message n'est plus signalé
             alert('Vous avez bien ignoré le signalement de ce message !');
          }
     }
     // Envoie les informations idUtilisateur, idCorrespondant et message en POST au script ignorer.php
     xhr.open('POST','./scripts/profil/ignorer.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres+"&message="+message);
     //change la classe du bouton
     btn.className= 'fa fa-warning';
     //change l'attribut onclick du bouton
     btn.setAttribute("onclick","signal(this, "+idUtil+", "+idCorres+")");
}

function load_mess(idUtil,idCorres) {
     var xhr = getXHR();
     //Récupère le bouton d'envoie
     var bt_send = document.getElementById('send_pv');
     //Change l'attribue onclick du bouton d'envoie
     bt_send.setAttribute("onclick","send_messagep('"+idCorres+"','"+idUtil+"');")
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // affiche le résultat dans la balise d'id "message"
             var res = xhr.responseText;
             document.getElementById('message').innerHTML = res;
          }
     }
     // Envoie les informations idUtilisateur et idCorrespondant en POST au script message.php
     xhr.open('POST','./scripts/profil/message.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres);
}

function supprimeMsg(b,idUtil,idCorres) {
     //récupère le bouton
     btn = b;
     //Récupère le parent du bouton
     filsTD = btn.parentNode
     //Récupère le texte du parent du bouton
     var message = filsTD.textContent
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
               //Alrte informant que le message a bien été supprimé
               alert('Vous avez bien supprimé ce message !');
               //Rechargement des messages
               load_mess(idUtil,idCorres);
          }
     }
     // Envoie les informations idUtilisateur, idCorrespondant et message en POST au script supprimerMsg.php
     xhr.open('POST','./scripts/profil/supprimerMsg.php',true) ;
     xhr.setRequestHeader('Content-Type',
          'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres+"&message="+message);
}

function send_message(idCorres,idUtil) {
     var xhr = getXHR();
     //récupère la valeur du textarea d'id "mess"
     var mess = document.getElementById('mess').value;
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             //Alerte informant que le message a bien été envoyé
             alert('Votre message a bien été envoyé !');
          }
     }
     // Envoie les informations idUtilisateur, idCorrespondant et message en POST au script send_mess.php
     xhr.open('POST','./scripts/profil/send_mess.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres+"&mess="+mess);
}

function send_messagep(idCorres,idUtil) {
     var xhr = getXHR();
     //Récupère la valeur du textarea d'id "mess_p"
     var mess = document.getElementById('mess_p').value;
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             //alerte informant que le message a bien été envoyé
             alert('Votre message a bien été envoyé !');
             //Rechargement des messages
             load_mess(idUtil,idCorres);

          }
     }
     // Envoie les informations idUtilisateur, idCorrespondant et message en POST au script send_mess.php
     xhr.open('POST','./scripts/profil/send_mess.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&corres="+idCorres+"&mess="+mess);
}

function blocage(idUtil, idProfil) {
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             //Alerte informant que l'utilisateur a bien été bloqué
             alert('Vous avez bien bloqué cet utilisateur !');

          }
     }
     // Envoie les informations idUtilisateur et idCorrespondant en POST au script message.php
     xhr.open('POST','./scripts/profil/blocage.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&profil="+idProfil);
}

function load_ami(idUtil) {
     var xhr = getXHR();
     //Récupère la balise liste de la liste d'ami
     var liste_ami = document.getElementById('liste_ami_ol');
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             //Affiche le résultat dans la balise liste_ami
             var res = xhr.responseText;
             liste_ami.innerHTML = res;
          }
     }
     // Envoie l'information idUtilisateur en POST au script message.php
     xhr.open('POST','./scripts/profil/load_friends.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil);
}

function add_ami(idUtil,idAmi){
     var xhr = getXHR();
     // Récupère le bouton d'id "ami"
     btn = document.getElementById('ami');
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             //Alerte informant que l'utilisateur a bien été ajouté à votre liste d'amis
             alert("Cet utilisateur a bien été ajouté à votre liste d'amis");
             //Change le texte du bouton en "Supprimer l'ami"
             btn.innerHTML = "Supprimer l'ami";
             //Change l'attribut onclick du bouton
             btn.setAttribute("onclick","sup_ami("+idUtil+", "+idAmi+")");
          }
     }
     // Envoie les informations idUtilisateur et idAmi en POST au script message.php
     xhr.open('POST','./scripts/profil/add_friend.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&ami="+idAmi);
}

function sup_ami(idUtil,idAmi){
     var xhr = getXHR();
     // Récupère le bouton d'id "ami"
     btn = document.getElementById('ami');
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
               //Alerte informant que l'utilisateur a bien été supprimé de votre liste d'amis
             alert("Cet utilisateur a bien été supprimé de votre liste d'amis");
             //Change le texte du bouton en "Ajouter l'ami"
             btn.innerHTML = "Ajouter l'ami";
              //Change l'attribut onclick du bouton
             btn.setAttribute("onclick","add_ami("+idUtil+", "+idAmi+")");
             //Recharge la liste d'amis
             load_ami(idUtil);
          }
     }
     // Envoie les informations idUtilisateur et idAmi en POST au script message.php
     xhr.open('POST','./scripts/profil/del_friend.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("util="+idUtil+"&ami="+idAmi);
}
