<!--Import Google Icon Font-->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<!--Import materialize.css-->
<link type="text/css" rel="stylesheet" href="materialize/css/materialize.min.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"  media="screen,projection"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

<style>
body {
  font-style: helvetica;
}
input:focus {
  border-bottom: 1px solid #5c6bc0 !important;
  box-shadow: 0 1px 0 0 #5c6bc0 !important;
}

label.active {
  color: #5c6bc0 !important;
}

.dropdown-content li > a, .dropdown-content li > span {
    color: #5c6bc0 !important;
}

textarea:focus {
  border-bottom: 1px solid #5c6bc0 !important;
  box-shadow: 0 1px 0 0 #5c6bc0 !important;
}


</style>

    <a id="button"></a>
      <nav class="nav-wrapper indigo lighten-1">
        <div class="container">
          <div class="col s1">
            <a href="index.php" class="brand-logo">ACH<a>
          <!-- <a href="index.php" class="brand-logo"><img class="responsive-img" src="images/ACH.png" width="70px;" alt=""></a> -->
        </div>
          <a href="#" class="sidenav-trigger" data-target="mobile-nav">
            <i class="material-icons">menu</i>
          </a>
          <ul class="right hide-on-med-and-down ">
            <li><a href="rechercherFormation.php"><i class="material-icons left" style="margin-top:4px; margin-right : 4px;">search</i>Rechercher une Formation</a></li>
            <li><a href="ajoutFormation.php"><i class="material-icons left" style="margin-top:4px; margin-right : 4px;">add_circle_outline</i>Ajouter une Formation</a></li>
            <li class="tab"><a href="entreprise.php"><i class="material-icons left" style="margin-top:4px; margin-right : 4px;">people</i>L'entreprise</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown1"><i class="material-icons left" style="margin-top:4px; margin-right : 4px;">settings</i>Espace Administrateur</a></li>
            <!-- Dropdown Structure -->
              <ul id='dropdown1' class='dropdown-content'>
                <li><a href="adminSite.php">Administrateur Site</a></li>
                <li><a href="adminFormation.php">Administrateur Organisme</a></li>
              </ul>
          </ul>
          <ul class="sidenav grey lighten-3" id="mobile-nav">
            <li class="center-align indigo lighten-1">
              <a class= "white-text" href="index.php">ACH</a>
              <!-- <a class= " white-text" href="index.php"><img src="images/ACH.png" alt="" width="50px;"></a> -->
            </li>
            <li>
                <a href="rechercherFormation.php">
                <i class="material-icons left">search</i>
                Rechercher une Formation</a>
            </li>
            <li><a href="ajoutFormation.php">
                <i class="material-icons left">add_circle_outline</i>
                Ajouter une Formation</a></li>
              <li><a href="entreprise.php"><i class="material-icons left">people</i>L'entreprise</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown2"><i class="material-icons left">settings</i>Espace Administrateur</a></li>
            <!-- Dropdown Structure -->
            <ul id='dropdown2' class='dropdown-content'>
              <li><a href="adminSite.php">Administrateur Site</a></li>
              <li><a href="adminFormation.php">Administrateur Organisme</a></li>
            </ul>
          </ul>
          </div>
      </nav>
 <!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="materialize/js/materialize.min.js"></script>
<script type="text/javascript" src="materialize/js/materialize.js"></script>
<script type="text/javascript" src="js/top.js"></script>
<script type="text/javascript" src="js/dropdown.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<!-- </div> -->
