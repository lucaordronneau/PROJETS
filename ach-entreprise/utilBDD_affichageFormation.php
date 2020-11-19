<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php

 // VERIF INPUT USER WITH output sql
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.


function affichageFormation(){

    //connexion a la bdd dans core.php
    $pdo = connecterBDD();

    //Affichage de toutes les données d'une formation qui ne sont pas obsolète (date)
    $stmt = $pdo->query("SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut WHERE (accepte = 1) and (dates > (SELECT NOW()))");

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

    $date = str_replace("00:00:00", " " , $row['dates']);

?>
<div class="grey lighten-3">
<div class="container">
<div class="containerS  white">
 <div id="formation" class="row"> <!--id à voir si on peut pas enlever -->
<div class="info organisme col s12 center-align"><b class="titreRes1">Nom Formation</b> :   <?php  echo $row['nom']."\n"; ?> </div>
<div class="info  col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">account_balance</i>Organisme</b> : <b class="petitPara"> <?php  echo $nomOrga."\n"; ?></b> </div>
<div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i>Domaine</b> :   <b class="petitPara"><?php  echo $row['domaine']."\n"; ?></b> </div>
<div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">location_on</i>Adresse</b> :   <b class="petitPara"><?php  echo $adresse."\n"; ?></b></div>
<div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i>Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
<div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i>Date de début</b> :   <b class="petitPara"><?php  echo $date."\n"; ?></b> </div>
<div class="info col s12 m6"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i>Coût</b> :   <b class="petitPara"><?php  echo $row['prix']." € \n"; ?></b> </div>
</div>
<div class="row">
  <div class="info col s12 m6 center-align">
<input id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idFormation; ?>">
 <a class="buttonR" onclick="detail_formation(<?php echo $acc; ?>)" > Plus d'informations </a>
 </div>

<form class="col s12 m6 center-align" action="Inscription.php" method="POST">
  <input name ="idFormationPost" id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idFormation; ?>" >
<input class="buttonR "  type="submit" value="Postuler">
</form>
</div>
</div>
</div>
</div>
<?php

// incrémentation accumulateur
$acc = $acc + 1 ;
}
}

function afficherPageFormation($idFormation){

    //connexion a la bdd dans core.php
		$pdo = connecterBDD();

    //Affichage de toutes les données d'une formation
    $stmt = $pdo->query("SELECT * FROM Formation where idFormation = '$idFormation' ");

    while ($row = $stmt->fetch()) {

      // accumulateur utilisé pour les id
      $acc = 0;

    // On récupère les id des clés étrangères
    $idOrga = $row['idOrganisme_fk'];
    $idLieu = $row['idLieu_fk'];

    //On récupère le nom de l'organisme
    $infosOrga = $pdo->query("SELECT * FROM Organisme where idOrganisme = '$idOrga'");

    while ($row2 = $infosOrga->fetch()) {
    $nomOrga = $row2['nom'];
    $telephoneOrga = $row2['tel'];
    $emailOrga = $row2['email'];
     }


    //On récupère l'id de l'adresse à partir du Lieu
    $infosLieu = $pdo->query("SELECT * FROM Lieu where idLieu = '$idLieu'");

    while ($row3 = $infosLieu->fetch()) {
    $idAdresse_cle_etrangere = $row3['idAdresse_fk'];
     }


     // On récupère l'adresse
    $infosAdresse = $pdo->query("SELECT * FROM Adresse where idAdresse ='$idAdresse_cle_etrangere'");
    while ($row4 = $infosAdresse->fetch()) {
    $adresse = $row4['numero'].' '.$row4['rue'].' , '.$row4['postal'].', '.$row4['ville'];
     }
         $date = str_replace("00:00:00", " " , $row['dates']);
?>
<div class="container grey lighten-3">
<div class="containerS  white">
<div  class="row">
<input id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idOrga; ?>">
<div class="info  col s12 m6 center-align"><b class="titreRes21"> Organisme</b> :    <?php  echo $nomOrga."\n"; ?> </div>
</div>
<div id="formation2" class="row">
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">phone</i><b class="titreRes2">Telephone organisme</b> :   <b class="petitPara"><?php  echo '0'.$telephoneOrga."\n"; ?></b> </div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">location_on</i><b class="titreRes2">Adresse</b> :   <b class="petitPara"><?php  echo $adresse."\n"; ?></b></div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i><b class="titreRes2">Domaine</b> :   <b class="petitPara"><?php  echo $row['domaine']."\n"; ?></b> </div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">label</i><b class="titreRes2">Nom Formation</b> :   <b class="petitPara"><?php  echo $row['nom']."\n"; ?></b> </div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i><b class="titreRes2">Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i><b class="titreRes2">Date de début</b> :   <b class="petitPara"><?php echo $date."\n"; ?></b> </div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i><b class="titreRes2">Coût</b> :   <b class="petitPara"><?php  echo $row['prix']." € \n"; ?></b> </div>
<div class="info col s12 m12 l3"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">credit_card</i><b class="titreRes2">Financement</b> :   <b class="petitPara"><?php  echo $row['financement']."  \n"; ?></b> </div>
<div class="info col s12"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">description</i><b class="titreRes2">Description</b> :   <b class="petitPara"><?php  echo $row['description']."  \n"; ?></b> </div>
<div class="info col s12"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">star_border</i><b class="titreRes2">Perspectives</b> :   <b class="petitPara"><?php  echo $row['perspective']."  \n"; ?></b> </div>
<form class="info col s12 m12" action="Inscription.php" method="POST">
  <input name ="idFormationPost" id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idFormation; ?>" >
<input class="buttonR "  type="submit" value="Postuler">
</form>
</div>
</div>

<div class="col s3">

<div class="info center-align"> <a href="rechercherFormation.php" style="margin-bottom:2%;"class="buttonR2" style="vertical-align:middle"><span> Retour </span></a> </div>

</div>

</div>


<?php
// incrémentation accumulateur
$acc = $acc + 1 ;  }
}

function afficherPageOrganisme($idOrganisme){

    //connexion a la bdd dans core.php
		$pdo = connecterBDD();


    //Affichage de toutes les données d'une formation
    $stmt = $pdo->query("SELECT * FROM Organisme where idOrganisme = '$idOrganisme' ");

    while ($row = $stmt->fetch()) {

      $nomOrga = $row['nom'];
      $presentationOrga = $row['presentation'];
      $telephoneOrga = $row['tel'];
      $emailOrga = $row['email'];

?>
<div class="container">
<div class="containerS  white">
  <div id="formation" class="row">
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">account_balance</i><b class="titreRes2"> Organisme</b> :    <b class="petitPara"><?php  echo $nomOrga."\n"; ?> </b></div>
<div class="info col s12 m6"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">email</i><b class="titreRes2"> Email organisme</b> :    <b class="petitPara"><?php  echo $emailOrga."\n"; ?> </b></div>
<div class="info col s12 m4"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">phone</i><b class="titreRes2"> Telephone organisme</b> :   <b class="petitPara"><?php  echo $telephoneOrga."\n"; ?> </b></div>
<div class="info col s12 m8"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">description</i><b class="titreRes2">Presentation</b> :   <b class="petitPara"><?php  echo $presentationOrga."\n"; ?> </b></div>
</div>
<!-- Bouton Valider -->
<div class="center-align"><a class="buttonR" onclick = "retour_infosFormation()"><span> Retour infos formation </span></a></div>
</div>

</div>
</div>


<?php


    }
    }
?>
