<?php
    include('Header.php');
    include('core.php');
    include_once("utilBDD_affichageFormation.php");


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
?>




<?php
function inscriptionFormation($formdata){

    if (!empty($_FILES)){
        $file_name1 = $_FILES['file1']['name'];
        $file_nameRand1 = md5(session_id().microtime());
        $file_name2 = $_FILES['file2']['name'];
        $file_nameRand2 = md5(session_id().microtime());

        $file_extension1 = strrchr($file_name1, ".");
        $file_extension2 = strrchr($file_name2, ".");
        $file_tmp_name1 = $_FILES['file1']['tmp_name'];
        $file_tmp_name2 = $_FILES['file2']['tmp_name'];

        $file_dest1 ='fichiers/'.$file_nameRand1.$file_extension1;
        $file_dest2 ='fichiers/'.$file_nameRand2.$file_extension2;


        $extensions_autorisees = array('.pdf', '.PDF', '.odt', '.ODT', '.docx', '.DOCX');

        if ( (!in_array($file_extension1, $extensions_autorisees)) || (!in_array($file_extension2, $extensions_autorisees)) || (!move_uploaded_file($file_tmp_name1, $file_dest1)) || (!move_uploaded_file($file_tmp_name2, $file_dest2))  ) {
            echo "L'extension d'un des fichiers n'est pas accepté, veuillez entrer un fichier pdf, odt ou docx.";
        }
      }


    $pdo = connecterBDD();
    $prenom = addslashes($_POST['prenom']);
    $nom = addslashes($_POST['nom']);
    $date = $_POST['date'];
    $mail = $_POST['email'];

    $rue = addslashes($_POST['rue']);
    $numero = $_POST['numero'];
    $postal = $_POST['postal'];
    $ville = addslashes($_POST['ville']);
    $idForm = $_POST['idFormation'];


    // vérification si une personne est déjà inscrite à une formation
    $query = "SELECT * from Inscrire i JOIN Inscrit it ON  it.idInscrit = i.idInscrit_fk WHERE (mail = '$mail') AND (idFormation_fk = '$idForm')";

    $prep = $pdo->query($query);
    $acc = 0 ;
    while ($colonne = $prep -> fetch() ) {
      $acc = $acc+1;
    }



    if ($acc != 0){


      echo "<div class='grey lighten-3'><h5 class='resultatF'> Vous avez déjà effectué une canditature à cette formation avec cette adresse mail. </h5></div>" ;
    } else {






    // insertion dans table adresse
    $idAdresse = ajouterAdresse($numero,$rue, $postal, $ville);

    $fichier1 = $file_nameRand1.$file_extension1;
    $fichier2 = $file_nameRand2.$file_extension2;


    // insertion dans table Inscrit
    $query = "INSERT INTO Inscrit(nom, prenom, naissance, mail, fichier1, fichier2, idAdresse_fk) VALUES ('".$nom."', '".$prenom."', '".$date."', '".$mail."', '".$fichier1."', '".$fichier2."','".$idAdresse."')";


    $prep = $pdo->prepare($query);
    //Compiler et exécuter la requête
    $prep->execute();
    $prep->closeCursor();
    $prep = NULL;

    $idInscrit = $pdo -> lastInsertId();





    // insertion dans table inscrire
    $query2 = "INSERT INTO Inscrire (idFormation_fk, idInscrit_fk) VALUES ('".$idForm."', '".$idInscrit."')";


    $prep2 = $pdo->prepare($query2);
    //Compiler et exécuter la requête


    $check_execute =  $prep2->execute();

    if ($check_execute == false){
      ?>
<div class="grey lighten-3">
   <h5 class="resultatF"> Erreur, votre canditature n'a pas été prise en compte, veuillez recommencer. </h5></div> <?php }
      else{ ?> <div class="grey lighten-3"> <h5 class="resultatT"> Votre canditature a bien été enregistrée. <form class="col s12 m6 center-align" action="payement.php" method="POST">
        <input name ="idFormationPaiement" id="<?php echo $idForm; ?>" type='hidden' value="<?php echo $idForm; ?>" >
        <input style="margin:3%;" class="buttonR1 "  type="submit" value="Payer">
      </form> </h5></div> <?php
        sleep(1);
     }

    $prep2->closeCursor();
    $prep2 = NULL;








}
}
?>






<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="css/shadow.css">
    <link rel="stylesheet" type="text/css" href="css/inscription.css">


    <title>Postuler </title>

  </head>

      <?php


    if ((isset($_POST['prenom']) && ($_POST['nom'] != "" )) && (isset($_POST['date']) && ($_POST['email'] != "" )) ) {
    inscriptionFormation($_POST);
}
    ?>

  <body>
    <div class="grey lighten-3">
    <div class="container">
      <div class="containerS white">
      <div class="row">

        <form class="col s12" method ="POST" enctype="multipart/form-data" action="Inscription.php">
            <div class="row">

            <input type="hidden" id= "idFormation" name="idFormation" value="<?php echo $_POST['idFormationPost'] ?>" >

              <div class="input-field col s12 m6 ">
              <input id="nom" type="text" name='nom' class="validate" required>
              <label for="nom">Nom</label>
              </div>

                <div class="input-field col s12 m6 ">
                    <input id="prenom" type="text"  name='prenom' class="validate" required>
                    <label for="prenom">Prénom</label>
                </div>


                    <div class="input-field col s12 m6">
                        <input id="email" type="email" name='email' class="validate" required>
                        <label for="email">Adresse email</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="date"  type="date" name='date' class="validate" min="1900-01-01" max="2019-12-31" required>
                        <label for="Date de naissance">Date de naissance</label>
                    </div>

            </div>
          </div>
        </div>
<div class="containerS white">
            <div class="row">
                <div class="input-field col s12 m4">
                    <input id="numero" type="text" maxlength="5" pattern=[0-9]{1,5} name='numero' class="validate" required>
                    <label for="numero">N°</label>
                </div>



                <div class="input-field col s12 m8">
                    <input id="rue" type="text" name='rue' class="validate" required>
                    <label for="rue">Rue</label>
                </div>





                <div class="input-field col s12 m4">
                    <input id="postal" maxlength="5" pattern="[0-9]{5}" type="text" name='postal' class="validate" required>
                    <label for="postal">Code Postal</label>
                </div>



                <div class="input-field col s12 m6">
                    <input id="ville" type="text"  name='ville' class="validate" required>
                    <label for="ville">Ville</label>
                </div>
            </div>
          </div>


<div class="containerS white">
            <div class = "row">
               <div class = "file-field input-field col s12 m6">
                  <div class="buttonR">
                     <span>Parcourir</span>
                     <input type = "file" name ='file1' required/>
                  </div>

                  <div class = "file-path-wrapper">
                     <input id="cv" class = "file-path validate" name ='file1' type = "text"/>
                      <label for="cv">Uploader un CV</label>
                  </div>
               </div>

               <div class = "file-field input-field col s12 m6">
                  <div class="buttonR">
                     <span>Parcourir</span>
                     <input type = "file" name ='file2' required/>
                  </div>

                  <div class = "file-path-wrapper">
                     <input id="lm" class = "file-path validate" name ='file2' type = "text"/>
                        <label for="lm">Uploader une lettre de motivation</label>
                  </div>
               </div>
            </div>
    </div>
    <div class="center-align">
     <button   data-target="modal1"  class="buttonR1" type="submit">Postuler cette formation</button>
   </div>
          </form>
  </div>
</div>
    <footer class="page-footer  indigo lighten-1">
      <?php include 'Footer.php'; ?>
    </footer>

    <script>
    $(document).ready(function(){
  $('.modal').modal();
});

      </script>
  </body>
</html>
