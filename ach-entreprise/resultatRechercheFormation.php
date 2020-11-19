<?php
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.
include_once("utilBDD_affichageFormation.php");
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="icon" href="images/favicon.ico" />
<?php
//connexion a la bdd dans core.php
$pdo = connecterBDD();

/* initialisation variable */
$tailleMax = 0;

if (isset($_GET['domaine'])){
$domaine = $_GET['domaine'];
$objDomaine = json_decode($domaine, false);
$taille1 = sizeof($objDomaine);
$tailleMax = $taille1;
}

if(isset($_GET['diplome'])){
$diplome = $_GET['diplome'];
$objDiplome = json_decode($diplome, false);
$taille2 = sizeof($objDiplome);
$tailleMax = $taille2;

}

if(isset($_GET['departement'])){
$departement = $_GET['departement'];
$objDepartement = json_decode($departement, false);
$taille3 = sizeof($objDepartement);
$tailleMax = $taille3;
}

/* On détermine la taille des tableaux la plus grande */
if ( (isset($_GET['domaine']))  && (isset($_GET['diplome']))   &&(!isset($_GET['departement'])) )   {

if ( $taille1 > $taille2){
    $tailleMax = $taille1;
}else{
  $tailleMax = $taille2;
}
}

if ( (isset($_GET['domaine']))  && (!isset($_GET['diplome']))   &&(isset($_GET['departement'])) )   {

if ( $taille1 > $taille3){
    $tailleMax = $taille1;
}else{
  $tailleMax = $taille3;
}
}

if ( (!isset($_GET['domaine']))  && (isset($_GET['diplome']))   &&(isset($_GET['departement'])) )   {

if ( $taille2 > $taille3){
    $tailleMax = $taille2;
}else{
  $tailleMax = $taille3;
}
}



if ( (isset($_GET['domaine']))  && (isset($_GET['diplome']))   &&(isset($_GET['departement'])) )   {

if ( $taille1 > $taille2){
    $tailleMax2 = $taille1;
}else{
  $tailleMax2 = $taille2;
}

if($taille3 > $tailleMax2){
  $tailleMax = $taille3;
} else{
  $tailleMax = $tailleMax2;
}

}



for($i=0;$i<sizeof($tailleMax);$i++){

/* cas où un seul des trois critères de recherche est utilisé */
    if(!empty($objDomaine[$i])){
        $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk where (accepte = 1) and domaine like '". $objDomaine[$i]."%' and (dates > (SELECT NOW()))";

    }

    if(!empty($objDiplome[$i])){
        $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk where (accepte = 1) and diplome  like '". $objDiplome[$i]."%' and (dates > (SELECT NOW()))";

    }

    if(!empty($objDepartement[$i])){

        $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk WHERE (accepte = 1) and postal like '". $objDepartement[$i]."%' and (dates > (SELECT NOW())) ";

    }


    /* cas où deux des trois critères de recherche sont utilisés */

    if ( (!empty($objDomaine[$i])) && (!empty($objDiplome[$i])) ){
      $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk where (accepte = 1) and (domaine like '". $objDomaine[$i]."%' ) and (diplome like '". $objDiplome[$i]."%') and (dates > (SELECT NOW())) ";


    }


    if ( (!empty($objDomaine[$i])) && (!empty($objDepartement[$i])) ){

      $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk WHERE (accepte = 1) and (postal like '". $objDepartement[$i]."%') and (domaine like '". $objDomaine[$i]."%' ) and (dates > (SELECT NOW())) ";

    }

    if ( (!empty($objDiplome[$i])) && (!empty($objDepartement[$i])) ){

      $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk WHERE (accepte = 1) and (postal like '". $objDepartement[$i]."%') and (diplome like '". $objDiplome[$i]."%') and (dates > (SELECT NOW())) ";

    }

    /* cas où les trois critères de recherche sont utilisé*/

    if ( (!empty($objDomaine[$i])) && (!empty($objDiplome[$i])) && (!empty($objDepartement[$i])) ){

          $req = "SELECT * FROM Formation f JOIN Statut s ON f.idStatut_fk = s.idStatut JOIN Lieu l ON l.idLieu = f.idLieu_fk JOIN Adresse a ON a.idAdresse = l.idAdresse_fk WHERE (accepte = 1) and (postal like '". $objDepartement[$i]."%') and (domaine like '". $objDomaine[$i]."%' ) and (diplome like '". $objDiplome[$i]."%') and (dates > (SELECT NOW()))           ";

    }


    if( (!empty($objDomaine[$i])) || (!empty($objDiplome[$i])) || (!empty($objDepartement[$i])) ){

        //Affichage de toutes les données d'une formation
        $stmt = $pdo->query($req);


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

        <div class="container">
        <div class="containerS white">
         <div id="formation" class="row"> <!--id à voir si on peut pas enlever -->
        <div class="info organisme col s12 center-align"><b class="titreRes1">Nom Formation</b> :   <?php  echo $row['nom']."\n"; ?> </div>
        <div class="info  col s12 m6 l4"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">account_balance</i>Organisme</b> : <b class="petitPara"> <?php  echo $nomOrga."\n"; ?></b> </div>
        <div class="info col s12 m6 l4"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">domain</i>Domaine</b> :   <b class="petitPara"><?php  echo $row['domaine']."\n"; ?></b> </div>
        <div class="info col s12 m6 l4"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">location_on</i>Adresse</b> :   <b class="petitPara"><?php  echo $adresse."\n"; ?></b></div>
        <div class="info col s12 m6 l4"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">content_copy</i>Diplôme</b> :   <b class="petitPara"><?php  echo $row['diplome']."\n"; ?></b> </div>
        <div class="info col s12 m6 l4"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">date_range</i>Date de début</b> :   <b class="petitPara"><?php  echo $date."\n"; ?></b> </div>
        <div class="info col s12 m6 l4"> <b class="titreRes"><i class="material-icons left couleurIcon" style="margin-top:4px; margin-right : 4px;">euro_symbol</i>Coût</b> :   <b class="petitPara"><?php  echo $row['prix']." € \n"; ?></b> </div>
        </div>
        <div class="row">
          <div class="info col s12 m6 center-align">
        <input id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idFormation; ?>">
         <a class="buttonR" onclick="detail_formation(<?php echo $acc; ?>)" > Plus d'informations </a>
         </div>

        <form class="col s12 m6 center-align" action="Inscription.php" method="POST">
          <input name ="idFormationPost" id="<?php echo $acc; ?>" type='hidden' value="<?php echo $idFormation; ?>" >
        <input class="buttonR "  type="submit" value="S'inscrire">
        </form>
        </div>

        </div>
        </div>
 }

        <?php

        // incrémentation accumulateur
        $acc = $acc + 1 ;
        /* cas où le résultat de la requete est nul*/



        }

        if ($acc == 0){
          ?>          <div class="container">
            <div class="containerS white">
             <div id="formation" class="row"> <!--id à voir si on peut pas enlever -->
            <div class="info organisme col s12 center-align"><b class="titreRes1"</b> Pas de résultat </div>
            </div>
            </div>
          </div> <?php
        }
      }else {

          affichageFormation();


      }
}
?>
