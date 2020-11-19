<?php
 // VERIF INPUT USER WITH output sql
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.

function connexionAdmin($formdata) {
    //connexion a la bdd dans core.php
    $pdo = connecterBDD();
    $mail=$_POST['mail'];
    $mdp=$_POST['password'];
    //on "sel" le hashage pour plus de complexité.
    define('PREFIX_SALT', 'mr');
    define('SUFFIX_SALT', 'robot');
    $mdphash =md5(PREFIX_SALT.$mdp.SUFFIX_SALT);
    //On fait la requête pour obtenir l'idAdmin
    $sql = "SELECT idAdmin FROM Util_ACH WHERE mail ='$mail' AND mdp = '$mdphash'";
    $res=$pdo->prepare($sql);
    $res->execute();
    $idAdmin = $res->fetch();
    $_SESSION['idUser']= $idAdmin[0];
}

function changeStatutA() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  echo "id,stat".$_GET['id'].$_GET['statutA'];
  $stat = $_GET['statutA'];
  $id = $_GET['id'];
  if ($stat == 1) {
    $sql = "UPDATE Statut SET accepte = '1' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
    //On remet le statut d'attente à 0
    $sql = "UPDATE Statut SET attente = '0' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
  } else if ($stat == 2) {
    $sql = "UPDATE Statut SET refuse = '1' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
    //On remet le statut d'attente à 0
    $sql = "UPDATE Statut SET attente = '0' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
  } else {
    echo "Erreur statut.";
  }
  //header("adminSite.php");
}

function changeStatutS() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  echo "id,stat".$_GET['id'].$_GET['statutS'];
  $stat = $_GET['statutS'];
  $id = $_GET['id'];
  if ($stat == 2) {
    $sql = "UPDATE Statut SET accepte = '0' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
    //On remet le statut d'attente à 0
    $sql = "UPDATE Statut SET refuse = '1' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
  } else {
    echo "Erreur statut.";
  }
  header("adminSite.php");
}

function changeStatutV() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  echo "id,stat".$_GET['id'].$_GET['statutV'];
  $stat = $_GET['statutV'];
  $id = $_GET['id'];
  if ($stat == 1) {
    $sql = "UPDATE Statut SET refuse = '0' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
    //On remet le statut d'attente à 0
    $sql = "UPDATE Statut SET accepte = '1' WHERE idStatut ='$id' ";
    $res=$pdo->prepare($sql);
    $res->execute();
  } else {
    echo "Erreur statut.";
  }
  header("location:adminSite.php");
}

//Affiche plus d'informations sur la formation.
function affichagePlus($idF) {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  //Affichage de toutes les données d'une formation
  $stmt = $pdo->query("SELECT * FROM Formation WHERE idFormation = '$idF'");
  // accumulateur utilisé pour les id
  $acc = 0;
  while ($row = $stmt->fetch()) {
  // On récupère les id des clés étrangères
  $idOrga = $row['idOrganisme_fk'];
  $idLieu = $row['idLieu_fk'];
  //On récupère le nom de l'organisme
  $infosOrga = $pdo->query("SELECT * FROM Organisme where idOrganisme = '$idOrga'");
  while ($row2 = $infosOrga->fetch()) {
  $nomOrga = $row2['nom'];
   }
  //On récupère l'id de l'adresse à partir du Lieu
  $infosLieu = $pdo->query("SELECT * FROM Lieu where idLieu = '$idLieu'");
  while ($row3 = $infosLieu->fetch()) {
  $idAdresse_cle_etrangere = $row3['idAdresse_fk'];
   }
  $infosAdresse = $pdo->query("SELECT * FROM Adresse where idAdresse ='$idAdresse_cle_etrangere'");
  while ($row4 = $infosAdresse->fetch()) {
  $adresse = $row4['numero'].' '.$row4['rue'].' , '.$row4['postal'].', '.$row4['ville'];
   }
   $idFormation = $row['idFormation'];
    ?>
    <div id="formation" class="row">
    <div class="info col s12"> <i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">account_balance</i><b class="titreRes2">Organisme</b> :    <b class="petitPara"><?php  echo $nomOrga."\n"; ?></b> </div>
    <div class="info col s12"> <i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">location_on</i><b class="titreRes2">Adresse</b> :   <b class="petitPara"><?php  echo $adresse."\n"; ?></b></div>
    <div class="info col s12"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">star_border</i> <b class="titreRes2">Perspective</b> :   <b class="petitPara"><?php  echo $row['perspective']."\n"; ?></b></div>
    <div class="info col s12"> <i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">description</i><b class="titreRes2">Description</b> :   <b class="petitPara"><?php  echo $row['description']."\n"; ?></b></div>
    <div class="info col s12"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">credit_card</i> <b class="titreRes2">Financement</b> :   <b class="petitPara"><?php  echo $row['financement']."\n"; ?></b></div>
    <div class="info col s12"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">accessibility_new</i><b class="titreRes2">Epreuves</b> :   <b class="petitPara"><?php  echo $row['epreuves']."\n"; ?></b></div>
    <div class="info col s12"> <i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">description</i><b class="titreRes2">Description</b> :   <b class="petitPara"><?php  echo $row['description']."\n"; ?></b></div>

    </div>
    <?php
    // incrémentation accumulateur
    $acc = $acc + 1 ;
  }
}

//On affiche les formations en attente
function afficheFormations() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  //On fait la requête pour obtenir le rôle de l'id obtenu
  $stmt = $pdo->query("SELECT * FROM Formation WHERE idStatut_fk IN (SELECT idStatut FROM Statut WHERE attente = 1)");
  // accumulateur utilisé pour les id
  $acc = 0;

  while ($row = $stmt->fetch()) {
    $date = str_replace("00:00:00"," ",$row['dates']);
    ?>
    <div id="formation" class="row">
      <div class=" margerhr">
      <div class="container">
         <hr/>
      </div>
      </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">label</i><b class="titreRes2">Nom Formation</b> :   <b class="petitPara"><?php  echo $row['nom']."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i><b class="titreRes2">Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i><b class="titreRes2">Prix</b> :   <b class="petitPara"><?php  echo $row['prix']."€\n"; ?></b> </div>
      <div class="info col s12 m6"> <i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i><b class="titreRes2">Domaine</b> :    <b class="petitPara"><?php  echo $row['domaine']." \n"; ?></b> </div>
      <div class="info col s12"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">done</i><b class="titreRes2">Prerequis</b> :    <b class="petitPara"><?php  echo $row['prerequis']." \n"; ?></b> </div>
      <div class="info col s12 m4"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i> <b class="titreRes2">Dates</b> :    <b class="petitPara"><?php  echo $date." \n"; ?></b> </div>
      <div class="info col s12 m4"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">schedule</i><b class="titreRes2">Durée</b> :    <b class="petitPara"><?php  echo $row['duree']." \n"; ?></b> </div>
      <div class="info col s12 m4"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">phone</i><b class="titreRes2">Formation numéro</b> :     <b class="petitPara"><?php  echo $row['idFormation']."\n"; ?> </div>
      <input id="<?php echo $acc; ?>" type='hidden' value="<?php echo  $row['idFormation']; ?>">
      <div class="info col s12 m12 l4 center-align"> <a class="buttonR2" onclick="afficherPlus(<?php echo  $row['idFormation']; ?>)" > Plus d'informations </a> </div>
      <div id="<?php echo $row['idFormation'] ?>">
      </div>
      <div class="info col s12 m12 l4 center-align"> <a class="buttonR4" onclick="changeStatutA(<?php echo $row['idStatut_fk']; ?>,1)" > Valider la formation </a> </div>
      <div class="info col s12 m12 l4 center-align"> <a class="buttonR3" onclick="changeStatutA(<?php echo $row['idStatut_fk']; ?>,2)" > Supprimer la formation </a> </div>


    </div>
    <?php
  // incrémentation accumulateur
  $acc = $acc + 1 ;
  }
}

//On affiche les formations acceptées
function afficheFormationsToutes() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  //On fait la requête pour obtenir le rôle de l'id obtenu
  $stmt = $pdo->query("SELECT * FROM Formation WHERE idStatut_fk IN (SELECT idStatut FROM Statut WHERE accepte = 1)");
  // accumulateur utilisé pour les id
  $acc = 0;

  while ($row = $stmt->fetch()) {
    $date = str_replace("00:00:00"," ",$row['dates']);
    ?>
    <div id="formation" class="row">
      <div class=" margerhr">
      <div class="container">
         <hr/>
      </div>
      </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">label</i><b class="titreRes2">Nom Formation</b> :   <b class="petitPara"><?php  echo $row['nom']."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i><b class="titreRes2">Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i><b class="titreRes2">Prix</b> :   <?php  echo $row['prix']."€\n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i><b class="titreRes2">Domaine</b> :   <?php  echo $row['domaine']." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">done</i><b class="titreRes2">Prerequis</b> :   <?php  echo $row['prerequis']." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i><b class="titreRes2">Dates</b> :   <?php  echo $date." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">schedule</i><b class="titreRes2">Durée</b> :   <?php  echo $row['duree']." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">phone</i><b class="titreRes2">Formation numéro</b> :    <?php  echo $row['idFormation']."\n"; ?> </div>
      <input id="<?php echo $acc; ?>" type='hidden' value="<?php echo  $row['idFormation']; ?>">
      <div class="info col s12 m6 center-align"> <a class="buttonR2" onclick="afficherPlus(<?php echo  $row['idFormation']; ?>)" > Plus d'informations </a> </div>
      <div id="<?php echo $row['idFormation'] ?>">
      </div>
    <div class="info col s12 m6 center-align"> <a class="buttonR3" onclick="changeStatutS(<?php echo $row['idStatut_fk']; ?>,2)" > Supprimer la formation </a> </div>
    </div>
    <?php
  // incrémentation accumulateur
  $acc = $acc + 1 ;
  }
}

//On affiche les formations supprimées
function afficheFormationsSup() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  //On fait la requête pour obtenir le rôle de l'id obtenu
  $stmt = $pdo->query("SELECT * FROM Formation WHERE idStatut_fk IN (SELECT idStatut FROM Statut WHERE refuse = 1)");
  // accumulateur utilisé pour les id
  $acc = 0;

  while ($row = $stmt->fetch()) {
    $date = str_replace("00:00:00"," ",$row['dates']);
    ?>
    <div id="formation" class="row">
      <div class=" margerhr">
      <div class="container">
         <hr/>
      </div>
      </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">label</i><b class="titreRes2">Nom Formation</b> :   <b class="petitPara"><?php  echo $row['nom']."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i><b class="titreRes2">Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i><b class="titreRes2">Prix</b> :   <?php  echo $row['prix']."€ \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i><b class="titreRes2">Domaine</b> :   <?php  echo $row['domaine']." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i><b class="titreRes2">Prerequis</b> :   <?php  echo $row['prerequis']." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i><b class="titreRes2">Dates</b> :   <?php  echo $dates." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">schedule</i><b class="titreRes2">Durée</b> :   <?php  echo $row['duree']." \n"; ?> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">phone</i><b class="titreRes2">N°</b> :    <?php  echo $row['idFormation']."\n"; ?> </div>
      <input id="<?php echo $acc; ?>" type='hidden' value="<?php echo  $row['idFormation']; ?>">
      <div class="info col s12 m6 center-align"> <a class="buttonR2" onclick="afficherPlus(<?php echo  $row['idFormation']; ?>)" > Plus d'informations </a> </div>
      <div id="<?php echo $row['idFormation'] ?>">
      </div>
    <div class="info col s12 m6 center-align"> <a class="buttonR4" onclick="changeStatutV(<?php echo $row['idStatut_fk']; ?>,1)" > Afficher la formation </a> </div>
    </div>
    <?php
  // incrémentation accumulateur
  $acc = $acc + 1 ;
  }
}

function afficheInscriptions() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  //On fait la requête pour obtenir le rôle de l'id obtenu
  $stmt = $pdo->query("SELECT * FROM Inscrire WHERE etat = '0'");
  // accumulateur utilisé pour les id
  $acc = 0;

  while ($row = $stmt->fetch()) {
    // On récupère les id des clés étrangères
    $idForm = $row['idFormation_fk'];
    $idInsc = $row['idInscrit_fk'];
    //On récupère le nom de la formation
    $infoForm = $pdo->query("SELECT * FROM Formation where idFormation = '$idForm'");
    while ($row2 = $infoForm->fetch()) {
      $nomForm = $row2['nom'];
      $diplomeForm = $row2['diplome'];
    }
    //On récupère le nom de la personne inscrite
    $infoForm = $pdo->query("SELECT * FROM Inscrit where idInscrit = '$idInsc'");
    while ($row3 = $infoForm->fetch()) {
      $nomInscrit = $row3['nom'];
      $prenomInscrit = $row3['prenom'];
      $mailInscrit = $row3['mail'];
      $naissanceInscrit = str_replace("00:00:00", " " , $row3['naissance']);
      $f1Inscrit = $row3['fichier1'];
      $f2Inscrit = $row3['fichier2'];
    }

    ?>
    <div id="inscription" class="row">
      <div class=" margerhr">
      <div class="container">
         <hr/>
      </div>
      </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">label</i><b class="titreRes2"> Nom de la formation</b> :   <b class="petitPara"><?php  echo $nomForm."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i><b class="titreRes2"> Nom du diplome</b> :   <b class="petitPara"><?php  echo $diplomeForm."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">person</i><b class="titreRes2"> Nom de la personne inscrite</b> :   <b class="petitPara"><?php  echo $nomInscrit."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">person</i><b class="titreRes2"> Prénom de la personne inscrite</b> :   <b class="petitPara"><?php  echo $prenomInscrit."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i><b class="titreRes2"> Date de naissance de la personne inscrite</b> :   <b class="petitPara"><?php  echo $naissanceInscrit."\n"; ?></b> </div>
      <div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">email</i><b class="titreRes2"> Mail de la personne inscrite</b> :   <b class="petitPara"><?php  echo $mailInscrit."\n"; ?></b> </div>
      <div class="col s12 m6 center-align"><a href="http://localhost:8080/fichiers/<?php  echo $f1Inscrit."\n"; ?>" download="CV">Télécharger le CV de l'inscrit</a></div>
      <div class="col s12 m6 center-align"><a href="http://localhost:8080/fichiers/<?php  echo $f2Inscrit."\n"; ?>" download="Lettre de motivation">Télécharger la lettre de motivation de l'inscrit</a></div>
    </div>
    <?php
  // incrémentation accumulateur
  $acc = $acc + 1 ;
  }
}

function afficheInscriptionsA() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  //On fait la requête pour obtenir le rôle de l'id obtenu
  $stmt = $pdo->query("SELECT * FROM Inscrire WHERE etat = '1'");
  // accumulateur utilisé pour les id
  $acc = 0;

  while ($row = $stmt->fetch()) {
    // On récupère les id des clés étrangères
    $idForm = $row['idFormation_fk'];
    $idInsc = $row['idInscrit_fk'];
    //On récupère le nom de la formation
    $infoForm = $pdo->query("SELECT nom FROM Formation where idFormation = '$idForm'");
    while ($row2 = $infoForm->fetch()) {
      $nomForm = $row2['nom'];
    }
    $infoForm = $pdo->query("SELECT diplome FROM Formation where idFormation = '$idForm'");
    while ($row4 = $infoForm->fetch()) {
      $diplomeForm = $row4['diplome'];
    }
    //On récupère le nom de la personne inscrite
    $infoForm = $pdo->query("SELECT * FROM Inscrit where idInscrit = '$idInsc'");
    while ($row3 = $infoForm->fetch()) {
      $nomInscrit = $row3['nom'];
      $prenomInscrit = $row3['prenom'];
      $mailInscrit = $row3['mail'];
    }
    ?>
    <div id="inscription" class="row">
      <div class=" margerhr">
      <div class="container">
         <hr/>
      </div>
      </div>
      <div class="info col s12 m6"><b class="titreRes2"> Nom de la formation</b> :   <b class="petitPara"><?php  echo $nomForm."\n"; ?></b> </div>
      <div class="info col s12 m6"><b class="titreRes2"> Nom du diplome</b> :   <b class="petitPara"><?php  echo $diplomeForm."\n"; ?></b> </div>
      <div class="info col s12 m6"><b class="titreRes2"> Nom de la personne inscrite</b> :   <b class="petitPara"><?php  echo $nomInscrit."\n"; ?></b> </div>
      <div class="info col s12 m6"><b class="titreRes2"> Prénom de la personne inscrite</b> :   <b class="petitPara"><?php  echo $prenomInscrit."\n"; ?></b> </div>
      <div class="info col s12 m6"><b class="titreRes2"> Mail de la personne inscrite</b> :   <b class="petitPara"><?php  echo $mailInscrit."\n"; ?></b> </div>
      <div class="col s12 m6 center-align"><a href="http://localhost:8080/fichiers/<?php  echo $f1Inscrit."\n"; ?>" download="CV">Télécharger le CV de l'inscrit</a></div>
      <div class="col s12 m6 center-align"><a href="http://localhost:8080/fichiers/<?php  echo $f2Inscrit."\n"; ?>" download="Lettre de motivation">Télécharger la lettre de motivation de l'inscrit</a></div>
      <!-- <div class='col s8 center-align'><hr/></div> -->
    </div>

    <?php
  // incrémentation accumulateur
  $acc = $acc + 1 ;
  }
}


if (($_GET['id'] > 0)&&($_GET['statutA'] > 0)) {
  changeStatutA();
}

if (($_GET['id'] > 0)&&($_GET['statutS'] > 0)) {
  changeStatutS();
}

if (($_GET['id'] > 0)&&($_GET['statutV'] > 0)) {
  changeStatutV();
}

if (($_GET['plus'] > 0)&&($_GET['idF'] > 0)) {
  affichagePlus($_GET['idF']);
}

function creerAdmin($formdata) {
    //connexion a la bdd dans core.php
    $pdo = connecterBDD();
    $mail=$_POST['email'];
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $mdp=$_POST['mdp'];
    $val=$_POST['selectRole'];
    $sql = "SELECT MAX(idRole) FROM Role";
    $res=$pdo->prepare($sql);
    $res->execute();
    $idRole = $res->fetch();
    $id = ($idRole[0]+1);
    // echo "Le role choisis est :".$val;
    // echo "L'id max est :".$id;
    switch ($val) {
      case '1':
        $sql = "INSERT INTO Role(idRole,personnel,regulateur,administrateur,king) VALUES ('".$id."','1','0','0','0') ";
        break;
      case '2':
        $sql = "INSERT INTO Role(idRole,personnel,regulateur,administrateur,king) VALUES ('".$id."','1','1','0','0') ";
        break;
      case '3':
        $sql = "INSERT INTO Role(idRole,personnel,regulateur,administrateur,king) VALUES ('".$id."','1','1','1','0') ";
        break;
      default:
        echo "<div class = 'grey lighten-3'>Erreur d'insertion du rôle.</div>";
        break;
    }
    $res=$pdo->prepare($sql);
    $res->execute();
    //on "sel" le hashage pour plus de complexité.
    define('PREFIX_SALT', 'mr');
    define('SUFFIX_SALT', 'robot');
    $mdphash =md5(PREFIX_SALT.$mdp.SUFFIX_SALT);
    $query = "INSERT INTO Util_ACH(mail,nom,prenom,mdp,idRole_fk) VALUES ('".$mail."','".$nom."','".$prenom."','".$mdphash."','".$id."')";
    //$query="select * from Inscrire";
    $prep = $pdo->prepare($query);
    //Compiler et exécuter la requête
    $prep->execute();
    $prep->closeCursor();
    $prep = NULL;
    echo "<div class = 'grey lighten-3'><h5 class='center-align'>L'utilisateur à bien été créé.</h5></div>";
    //on renvoie vers la page de connexion
    // header('Location: adminFormation.php');
    // deconnecterBDD();
}

function verifAdmin() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  $mail= $_POST['email'];
  $user = $_SESSION['idUser'];
  $sql = "SELECT administrateur FROM Role WHERE idRole ='".$user."'";
  $res=$pdo->prepare($sql);
  $res->execute();
  $idRole = $res->fetch();
  return($idRole[0]);
}

function modifAdmin() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  $mail= $_POST['emaile'];
  $val=$_POST['modifRole'];
  $sql = "SELECT idRole_fk FROM Util_ACH WHERE mail ='".$mail."'";
  $res=$pdo->prepare($sql);
  $res->execute();
  $idRole = $res->fetch();
  switch ($val) {
    case '1':
      $sql = "UPDATE Role SET personnel = '1', regulateur = '0', administrateur = '0' WHERE idRole ='$idRole[0]' ";
      break;
    case '2':
      $sql = "UPDATE Role SET personnel = '1', regulateur = '1', administrateur = '0' WHERE idRole ='$idRole[0]' ";
      break;
    case '3':
      $sql = "UPDATE Role SET personnel = '1', regulateur = '1', administrateur = '1' WHERE idRole ='$idRole[0]' ";
      break;
    default:
      echo "<div class = 'grey lighten-3'>Erreur d'insertion du rôle.</div>";
      break;
  }
  $res=$pdo->prepare($sql);
  $res->execute();
  echo "<div class = 'grey lighten-3'><h5 class='center-align'>Le rôle à bien été mis à jour.</h5></div>";
}

function deconnexion() {
  /*On détruit la session*/
  session_destroy();
  /*Au cas où on la met à vide*/
  $_SESSION= [];
    //on renvoie vers la page de connexion
    header('Location: adminSite.php');
}

?>
