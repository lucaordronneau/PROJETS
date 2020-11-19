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
    $sql = "SELECT idAdmin_organisme FROM Admin_organisme WHERE email ='$mail' AND mdp = '$mdphash'";
    //$result = $conn->query($sql);
    $res=$pdo->prepare($sql);
    $res->execute();
    $idAdmin_organisme = $res->fetch();
    $_SESSION['idUser']= $idAdmin_organisme[0];
    //header('Location: adminFormation.php');
    //deconnecterBDD();
}

function creerAdmin($formdata) {
    //connexion a la bdd dans core.php
    $pdo = connecterBDD();
    $mail=$_POST['email'];
    $mdp=$_POST['mdp'];
    $sql = "SELECT MAX(idAdmin_organisme) FROM Admin_organisme";
    //$result = $conn->query($sql);
    $res=$pdo->prepare($sql);
    $res->execute();
    $monMax = $res->fetch();
    /*On ajoute +1 pour créer le nouvel idAdmin_organisme*/
    $id = ($monMax[0]+1);
    //on "sel" le hashage pour plus de complexité.
    define('PREFIX_SALT', 'mr');
    define('SUFFIX_SALT', 'robot');
    $mdphash =md5(PREFIX_SALT.$mdp.SUFFIX_SALT);
    $query = "INSERT INTO Admin_organisme(idAdmin_organisme,email,mdp) VALUES ('".$id."', '".$mail."','".$mdphash."')";
    //$query="select * from Inscrire";
    $prep = $pdo->prepare($query);
    //Compiler et exécuter la requête
    $prep->execute();
    $prep->closeCursor();
    $prep = NULL;
    //on renvoie vers la page de connexion
    // header('Location: adminFormation.php');
    // deconnecterBDD();
}

function creerOrganisme($formdata) {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  $user = ($_SESSION['idUser']);
  $numO = $_POST['numeroO'];
  $rueO = $_POST['rueO'];
  $postalO = $_POST['postalO'];
  $villeO = $_POST['villeO'];
  //----------------On insère l'adresse de l'organisme----------------//
  $query = "INSERT INTO Adresse(numero,rue,postal,ville) VALUES ('".$numO."', '".$rueO."','".$postalO."','".$villeO."')";
  $prep = $pdo->prepare($query);
  //Compiler et exécuter la requête
  $prep->execute();
  //----------------On récupère l'id de l'adresse----------------//
  $query2 = "SELECT MAX(idAdresse) FROM Adresse";
  //$result = $conn->query($sql);
  $res=$pdo->prepare($query2);
  $res->execute();
  $monMax = $res->fetch();
  $idO = ($monMax[0]);
  //----------------On insère latitude et longitude----------------//
  $longO = $_POST['longitudeO'];
  $latO = $_POST['latitudeO'];
  $query3 = "INSERT INTO Lieu(longitude,latitude,idAdresse_fk) VALUES ('".$longO."', '".$latO."','".$idO."')";
  $prep = $pdo->prepare($query3);
  //Compiler et exécuter la requête
  $prep->execute();
  //----------------On récupère l'id de lieu----------------//
  $query4 = "SELECT MAX(idLieu) FROM Lieu";
  //$result = $conn->query($sql);
  $res=$pdo->prepare($query4);
  $res->execute();
  $monMax = $res->fetch();
  $idL = ($monMax[0]);
  //----------------On insère le personnel----------------//
  $nomP = $_POST['nomP'];
  $prenomP = $_POST['prenomP'];
  $photoP = $_POST['photoP'];
  $query5 = "INSERT INTO Personnel(nom,prenom,photo) VALUES ('".$nomP."', '".$prenomP."','".$photoP."')";
  $prep = $pdo->prepare($query5);
  //Compiler et exécuter la requête
  $prep->execute();
  //----------------On récupère l'id du personnel----------------//
  $query6 = "SELECT MAX(idPersonnel) FROM Personnel";
  //$result = $conn->query($sql);
  $res=$pdo->prepare($query6);
  $res->execute();
  $monMax = $res->fetch();
  $idP = ($monMax[0]);
  //----------------On insère l'organisme----------------//
  $nomO = $_POST['nomO'];
  $presO = $_POST['presentationO'];
  $mailO = $_POST['emailO'];
  $telO = $_POST['telO'];
  $query7 = "INSERT INTO Organisme(nom,presentation,email,tel,idAdmin_organisme_fk,idLieu_fk,idPersonnel_fk) VALUES ('".$nomO."', '".$presO."','".$mailO."','".$telO."','".$user."','".$idL."','".$idP."')";
  $prep = $pdo->prepare($query7);
  //Compiler et exécuter la requête
  $prep->execute();
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
  header("adminFormation.php");
}

function affichageFormation($id) {
      //connexion a la bdd dans core.php
      $pdo = connecterBDD();
      //Affichage de toutes les données d'une formation qui appartiennent à l'organisme
      $stmt = $pdo->query("SELECT * FROM Formation  WHERE idOrganisme_fk = '$id'");
      // accumulateur utilisé pour les id
      $acc = 0;
      while ($row = $stmt->fetch()) {
      // On récupère les id des clés étrangères
      $idOrga = $row['idOrganisme_fk'];
      $idLieu = $row['idLieu_fk'];
      $idStatut_cle_etrangere = $row['idStatut_fk'];
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
       //On récupère le statut de la formation
       $infosStatut = $pdo->query("SELECT * FROM Statut where idStatut ='$idStatut_cle_etrangere'");
       while ($row5 = $infosStatut->fetch()) {
         $statut = '<br>Accepté : '.$row5['accepte'].'<br> En attente : '.$row5['attente'].'<br> Refusé : '.$row5['refuse'];
      }

      $infosAdresse = $pdo->query("SELECT * FROM Adresse where idAdresse ='$idAdresse_cle_etrangere'");
      while ($row4 = $infosAdresse->fetch()) {
      $adresse = $row4['numero'].' '.$row4['rue'].' , '.$row4['postal'].', '.$row4['ville'];
       }

       $idFormation = $row['idFormation'];

      $date = str_replace("00:00:00", " " , $row['dates']);

  ?>
  <div class="grey lighten-3">
  <div class="container">
  <div class="containerS1 white">
  <div id="formation" class="row"> <!--id à voir si on peut pas enlever -->
    
  <div class="info organisme col s12 center-align"><b class="titreRes1">Nom Formation</b> :   <?php  echo $row['nom']."\n"; ?> </div>
  <div class="info  col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">account_balance</i>Organisme</b> : <b class="petitPara"> <?php  echo $nomOrga."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i>Domaine</b> :   <b class="petitPara"><?php  echo $row['domaine']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">location_on</i>Adresse</b> :   <b class="petitPara"><?php  echo $adresse."\n"; ?></b></div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i>Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i>Date de début</b> :   <b class="petitPara"><?php  echo $date."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i>Coût</b> :   <b class="petitPara"><?php  echo $row['prix']." € \n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">star_border</i>Perspective</b> :   <b class="petitPara"><?php  echo $row['perspective']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">pool</i>Épreuves</b> :   <b class="petitPara"><?php  echo $row['epreuves']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">pan_tool</i>Prérequis</b> :   <b class="petitPara"><?php  echo $row['prerequis']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">description</i>Description</b> :   <b class="petitPara"><?php  echo $row['description']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">attach_money</i>Financement</b> :   <b class="petitPara"><?php  echo $row['financement']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">timer</i>Durée</b> :   <b class="petitPara"><?php  echo $row['duree']."\n"; ?></b> </div>
  <div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">account_circle</i>Statut</b> :   <b class="petitPara"><?php  echo $statut."\n"; ?></b> </div>
  </div>
  <div class="row">
    <div class="info col s12 m6 center-align">
  <input id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idFormation; ?>">
   </div>
  </div>
  <br>
  <div class="info col s12 m12 l4 center-align"> <a class="buttonR3" onclick="changeStatutS(<?php echo $row['idStatut_fk']; ?>,2)" > Supprimer la formation </a> </div>
  <br>
  </div>
  </div>
  </div>
  <?php

  // incrémentation accumulateur
  $acc = $acc + 1 ;
  }
  }


  if (($_GET['id'] > 0)&&($_GET['statutS'] > 0)) {
    changeStatutS();
  }

function organisme() {
  //connexion a la bdd dans core.php
  $pdo = connecterBDD();
  $user = ($_SESSION['idUser']);
  $sql = "SELECT idOrganisme FROM Organisme WHERE idAdmin_organisme_fk ='".$user."'";
  $res=$pdo->prepare($sql);
  $res->execute();
  $idOrganisme = $res->fetch();
  return($idOrganisme[0]);
}

function ajouterFormation($nom,$diplome,$prix,$perspective,$description,$domaine,$financement,$epreuves,$prerequis,$dates,$duree,$idLieu,$idStatut,$idOrganisme) {
         $pdo = connecterBDD();
 $query = "INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('".$nom."','".$diplome."','".$prix."','".$perspective."','".$description."','".$domaine."','".$financement."','".$epreuves."','".$prerequis."','".$dates."','".$duree."','".$idLieu."','".$idStatut."','".$idOrganisme."')";
  echo $query;
    $prep = $pdo->prepare($query);
    //Compiler et exécuter la requête
       $check_execute = $prep->execute();
       if ($check_execute == false){
         ?>
         <div class="grey lighten-3">
      <h5 class="resultatF"> Erreur, votre inscription n'a pas été prise en compte, veuillez recommencer. </h5> </div><?php }
         else{ ?> <div class="grey lighten-3"> <h5 class="resultatT"> Votre inscription a bien été enregistrée.</h5> </div><?php }
    $prep->closeCursor();
    $prep = NULL;
}

function ajouterAdresse($numero,$rue,$postal,$ville){
        //connexion a la bdd dans core.php

    $pdo = connecterBDD();
    /*  Insertion adresse */
    $query = "INSERT INTO Adresse (numero,rue,postal,ville) VALUES ('".$numero."','".$rue."', '".$postal."', '".$ville."')";
    /* execution de la requête */

    $prep = $pdo->prepare($query);
    $prep->execute();
    $prep->closeCursor();
    $prep = NULL;

    /* on récupère l'id de l'adresse inserée précedemment */
    $idAdresse = $pdo -> lastInsertId();
/*on retourne l'id de l'adresse qui vient d'être insérer*/
return($idAdresse);


}

function ajouterPosition($longitude,$latitude,$idAdresse){

     $pdo = connecterBDD();
    /* insertion position de l'adresse */



    $query = "INSERT INTO Lieu (longitude,latitude,idAdresse_fk) VALUES ('".$longitude."','".$latitude."','".$idAdresse."')";

     /* execution de la requête */
    $prep = $pdo->prepare($query);
    $prep->execute();
    $prep->closeCursor();
    $prep = NULL;

    /* on récupère l'id de l'adresse inserée précedemment */
    $idPosition = $pdo -> lastInsertId();
/*on retourne l'id de la position qui vient d'être insérer*/
return($idPosition);
}

function statut(){
    $pdo = connecterBDD();
    /* insertion statut */
    $query = "INSERT INTO Statut (accepte,refuse,attente) VALUES ('1','0','0') ";
    /* execution de la requête */
     $prep = $pdo->prepare($query);
    $prep->execute();
    $prep->closeCursor();
    $prep = NULL;
    /* on récupère l'id du statut  inserée précedemment */
    $idStatut = $pdo -> lastInsertId();
    /*on retourne l'id du statut qui vient d'être insérer*/
    return($idStatut);
}

function deconnexion() {
  /*On détruit la session*/
  session_destroy();
  /*Au cas où on la met à vide*/
  $_SESSION= [];
    //on renvoie vers la page de connexion
    header('Location: adminFormation.php');
}

?>
