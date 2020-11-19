<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="css/shadow.css">
    <link rel="stylesheet" type="text/css" href="css/entreprise.css">
  </head>

  <body>
    <header>
       <?php include 'Header.php'; ?>
    </header>

    <title> L'entreprise </title>
<div class="grey lighten-3">
    <div class="container">
      <div class="row">
        <div class="col s12 m12 l6">
          <div class="center-align">
            <img class="responsive-img imageV" src="images/1.png">
          </div>
        </div>
        <div class="col s12 m12 l6">
          <div class="containerS white center-align">
            <h5> ACH INTERIM, </h5>
            <div class=" margerhr">
            <div class="container">
               <hr/>
            </div>
            </div>
Agence de travail temporaire spécialisée dans le placement des Maitres Nageurs Sauveteurs. <br>
Nous proposons la mise à disposition d’intérimaires pour les professionnels qui sont à la recherche de personnel qualifié et spécialisé dans les activités de la natation.

Nous vous offrons souplesse et disponibilités dans la gestion des besoins de vos piscines et intervenons rapidement, au sein de votre établissement, sur des missions d’enseignement, d’encadrement, de surveillance, de formation et d’animation.
Nous vous offrons souplesse et disponibilités dans la gestion des besoins de vos piscines et intervenons rapidement, au sein de votre établissement, sur des missions d’enseignement, d’encadrement, de surveillance, de formation et d’animation.
          </div>
        </div>
      </div>
    </div>
  </div>

    <div class="grey lighten-3">
    <div class="container">
      <div class="row">
        <div class="col s12 m12 l6">
          <div class="containerS white">
            Nous vous offrons souplesse et disponibilités dans la gestion des besoins de vos piscines et intervenons rapidement, au sein de votre établissement, sur des missions d’enseignement, d’encadrement, de surveillance, de formation et d’animation.
            <br>
            <br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
            <br>
            <br>
            Nous vous offrons souplesse et disponibilités dans la gestion des besoins de vos piscines et intervenons rapidement, au sein de votre établissement, sur des missions d’enseignement, d’encadrement, de surveillance, de formation et d’animation.
            <br>
            <br>
            Nous vous offrons souplesse et disponibilités dans la gestion des besoins de vos piscines et intervenons rapidement, au sein de votre établissement, sur des missions d’enseignement, d’encadrement, de surveillance, de formation et d’animation.
            <br>
          </div>
        </div>
        <div class="col s12 m12 l6">
          <div class="containerS center-align white">
            <h3>Notre équipe</h3>
            <div class=" margerhr">
            <div class="container">
               <hr/>
            </div>
            </div>
            <div class="carousel position">
            <a class="carousel-item" href="#one!"><img src="images/avatar1.png"><p id="para">Bonjour, nous sommes un groupe d'élèves créant un site pour ACH Intérim.</p></a>
            <a class="carousel-item" href="#two!"><img src="images/avatar2.png"><p id="para">Je suis la personne N°2<br>Nom<br>Prénom<br>Parcours<br></p></a>
            <a class="carousel-item" href="#three!"><img src="images/avatar3.png"><p id="para">Je suis la personne N°3<br>Nom<br>Prénom<br>Parcours<br></p></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <footer class="page-footer  indigo lighten-1">
      <?php include 'Footer.php'; ?>
    </footer>
    <script>
    // Or with jQuery

    $(document).ready(function(){
      $('.carousel').carousel();

      setInterval(function(){
        $('.carousel').carousel('next');
      }, 3000);
    });
    </script>
  </body>
</html>
