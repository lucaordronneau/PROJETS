<?php
 // VERIF INPUT USER WITH output sql
include_once("core.php");//notamment pour connecterBDD et deconnecterBDD.

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

    $query = "INSERT INTO Statut (accepte,refuse,attente) VALUES ('0','0','1') ";

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

function ajouterFormation($nom,$diplome,$prix,$perspective,$description,$domaine,$financement,$epreuves,$prerequis,$dates,$duree,$idLieu,$idStatut,$idOrganisme) {

         $pdo = connecterBDD();


 $query = "INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('".$nom."','".$diplome."','".$prix."','".$perspective."','".$description."','".$domaine."','".$financement."','".$epreuves."','".$prerequis."','".$dates."','".$duree."','".$idLieu."','".$idStatut."','".$idOrganisme."')";

    $prep = $pdo->prepare($query);

    //Compiler et exécuter la requête
       $check_execute = $prep->execute();

       if ($check_execute == false){
         ?>

      <div class="grey lighten-3"><h5 class="resultatF"> Erreur, votre inscription n'a pas été prise en compte, veuillez recommencer. </h5></div> <?php }
         else{ ?> <div class="grey lighten-3"> <h5 class="resultatT"> Votre inscription a bien été enregistrée.</h5> </div><?php }
    $prep->closeCursor();
    $prep = NULL;



}

?>
