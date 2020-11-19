<!doctype html>
<html lang="fr">
  <head>


    <!-- Pour les icônes -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- encodage en utf-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- mon css -->
    <link rel="stylesheet" type="text/css" href="css/payement.css">
    <link rel="stylesheet" type="text/css" href="css/shadow.css">

    <title>Paiement en ligne</title>

  </head>
  <body>
    <!-- Header -->
    <header>
      <?php include 'Header.php'; ?>
    </header>

    <?php
    include('core.php');

    if(isset($_POST['idFormationPaiement'])){

    $idFormation= $_POST['idFormationPaiement'];

    $pdo = connecterBDD();
    //On récupère l'id de l'adresse à partir du Lieu
    $requete = $pdo->query("SELECT * FROM Formation where idFormation = '$idFormation'");

    while ($row = $requete->fetch()) {

    $nomFormation = $row['nom'];
    $prixFormation = $row['prix'];
     }

   }else{
     $nomFormation = 'Nom de Formation';
   $prixFormation = '0';
   }
     ?>

<div class="grey lighten-3">
    <div class="center-align">
      <!-- <div>
        <img  class="card-panel hoverable" src="images/ACH.png" alt="" wnameth="150" height="150">
      </div> -->
      <div class="container col s12 center-align"><h2>Paiement en ligne</h2></div>
    </div>
  <div class="container">
    <h3>
      Votre panier<i class="couleurIcon material-icons left medium">add_shopping_cart</i>
    </h3>
    <div class="containerS white">
    <table>
      <thead>
        <tr>
          <th>Nom de la formation</th>
          <th>Prix</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $nomFormation; ?>  </td>
          <td><?php echo $prixFormation; ?> € </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
    <form method="post" action="payement.php">

      <div class="container">

        <h3>Détails de facturation<i class="couleurIcon material-icons left medium">person</i></h3>
        <div class="containerS white">
        <div class="row">
          <div class="input-field col s12 m6 l4">
            <input id="firstname" class="validate" type="text" name="firstName" required>
            <label for="firstname">Prénom</label>
          </div>
          <div class="input-field col s12 m6 l4">
            <input id="lastname" class="validate" type="text" name="lastName"  required>
            <label for="lastname">Nom</label>
          </div>
          <div class="input-field col s12 m6 l4">
            <input id="email" class="validate" type="email" name="email" required>
            <label for="email">Email</label>
          </div>
        </div>
        </div>
        <h3>Paiement <i class="couleurIcon material-icons left medium">credit_card</i></h3>
        <div class="row">
          <div class="col s8">
        <div class="containerS white">
        <!-- <i class="couleurIcon material-icons left small">credit_card</i> -->
        <div class="row">
          <div class="input-field col s12 m6">
            <input id="ccname" class="validate" type="text" name="ccname" required>
            <label for="ccname">Titulaire de la carte</label>
          </div>
          <div class="input-field col s12 m5">
            <input id="ccnumber" class="validate" type="text" maxlength="16" pattern="[0-9]{16}" name="ccnumber" required>
            <label for="ccnumber">Numéro de carte</label>
          </div>
          <div class="input-field col s12 m6">
            <input id="ccexpiration" class="validate" type="month" name="ccexpiration" class="datepicker" required>
            <!-- <label for="ccexpiration">Date d'expiration</label> -->
          </div>
          <div class="input-field col s12 m3">
            <input id="cccvc" type="text" class="validate" maxlength="3" pattern="[0-9]{3}"required>
            <label for="cccvc">CVC</label>
          </div>
          <div class="input-field col s12 center-align">
            <button class="buttonR" type="submit">Procéder au paiement</button>
        </div>
        </div>
      </div>
    </form>
  </div>
  <div class="col s4">

  </div>
  <div class="col s4 center-align">

      <?php
        if (!empty($_POST[firstName]) && !empty($_POST[lastName]) && !empty($_POST[email]) && !empty($_POST[ccname]) && !empty($_POST[ccnumber]) && !empty($_POST[ccexpiration])) {
          echo '<div class="grey lighten-3 col s12 center-align container"><h5 id="green"><strong> Votre paiement a été effectué, '.$_POST[firstName].' ! </strong></h5></div><br />';
        }
          // echo '<div class="col s12 center-align container"><h5 id="red"><strong> Votre payement a été refusé ! </strong></h5></div><br />';
        unset($_POST);
      ?>
    </div>
</div>
</div>
</div>
  <footer class="page-footer  indigo lighten-1">
    <?php include 'Footer.php'; ?>
  </footer>
  </body>
</html>

<!--
php -S localhost:8080
http://localhost:8080/payement.php
git pull origin master
git add .
git commit -m "message"
git push origin master->
