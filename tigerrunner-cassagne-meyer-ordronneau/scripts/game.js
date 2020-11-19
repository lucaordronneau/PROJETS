/* ----Définition des variables---- */
var canvas = document.getElementById("game"); //On définit le canvas
var ctx = canvas.getContext("2d"); // On définit le context du canvas
var player = {};                   //On crée la variable du joueur
var ground = [];                   //On crée le tableau du sol
//On crée les variables d'obstacles obs, obs_speed et obs_y
var obs;
var obs_speed;
var obs_y;
//On crée la variable contenant le temps de saut maximum.
var tmps_saut_max;
//On définit la taille d'un cube de sol
var platformWidth = 32;
//On définit la hauteur du placement du sol
var platformHeight = canvas.height - platformWidth * 4;
//On crée un tableau contenant les chiffres de 0 au nombre d'image necessaire à l'animation du personnage -1 (vu qu'on commence à 0)
const cycleLoop = [0,1,2,3,4,5];
//On définit la variable qui va compter le nombre d'image passé
let frameCount = 0;
//On définit la variable qui va contenir la position de l'image actuelle de l'animation de notre personnage sur le spritesheet.
let currentLoopIndex = 0;
//On définit la variable de score
let score = 0;
//On crée la variable qui contiendra la hauteur par défaut de notre personnage
let default_y = 0;
//On définit la variable qui nous servira à gérer le saut
let saut = false;
//On définit la position x à laquelle l'obstacle sera dessiné
let obstacle_x = 820;
//On définit la variable contenant le temps de saut
let tmps_saut = 0;
//On définit la variable qui nous servira à gérer la glissade
let glisse = false;

// Requete Ajax
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
//Enregistrement du score
function save_score(scoreFin) {
     var xhr = getXHR();
     // On définit que l'on va faire à chq changement d'état
     xhr.onreadystatechange = function() {
          // On ne fait quelque chose que si on a tout reçu
          // et que le serveur est ok
          if (xhr.readyState == 4 && xhr.status == 200){
             // traitement réalisé avec la réponse...
             var res = xhr.responseText;
             alert(res);
             menu();
          }
     }
     // On envoie le score final en POST
     xhr.open('POST','./scripts/saveScore.php',true) ;
     xhr.setRequestHeader('Content-Type',
         'application/x-www-form-urlencoded;charset=utf-8');
     xhr.send("score="+scoreFin);
}

/**
  * Requete d'animation Polyfill
  */
var requestAnimFrame = (function(){
     return  window.requestAnimationFrame       ||
             window.webkitRequestAnimationFrame ||
             window.mozRequestAnimationFrame    ||
             window.oRequestAnimationFrame      ||
             window.msRequestAnimationFrame     ||
             function(callback, element){
                  window.setTimeout(callback, 1000 / 60);
             };
})();
// Chargement des images en définissant le nom, la source et la taille de chaque image
//     --Background
var background = new Image();
background.name = "Background";
background.src = "images/bg.png";
background.width = canvas.width;
background.height = canvas.height;
//     --Sky
var sky = new Image();
sky.name = "Sky";
sky.src = "images/sky.png";
sky.width = canvas.width;
sky.height = canvas.height;
//     --Obstacle Arbre
var obs1 = new Image();
obs1.name = "Obstacle Arbre";
obs1.src = "images/Arbre.png";
obs1.width = 130;
obs1.height = 131;
//     --Grass
var grass = new Image();
grass.name = "Grass";
grass.src = "images/grass.png";
grass.width = 32;
grass.height = 32;
//     --backdrop
var backdrop = new Image();
backdrop.name = "Backdrop";
backdrop.src = "images/backdrop.png";
backdrop.width = canvas.width;
backdrop.height = canvas.height;
//     --Bouton Jouer
var bouton_jouer = new Image();
bouton_jouer.name = "Bouton Jouer";
bouton_jouer.src = "images/bouton.png";
bouton_jouer.width = 160;
bouton_jouer.height = 75;
//     --Avatar normal
var avatar_normal = new Image();
avatar_normal.name = "avatar normal";
avatar_normal.src = "images/sprite_normal.png";
avatar_normal.width = 130;
avatar_normal.height = 94;

//Variable qui récupère la position d'un objet sur la fenêtre
var getOffsetPosition = function(obj){
     var offsetX = offsetY = 0;

     if (obj.offsetParent) {
          do {
               offsetX += obj.offsetLeft;
               offsetY += obj.offsetTop;
          } while(obj = obj.offsetParent);
     }
     return [offsetX,offsetY];
}

//     --Fonction retournant un nombre entre 0 et max-1
function getRandomInt(max) {
     return Math.floor(Math.random() * Math.floor(max));
}
//     --Fonction qui affiche les decorations
function draw_asset() {
     ctx.drawImage(background, 0, 0); //Dessine l'arrière-plan
     ctx.drawImage(sky, 0, 0);          //Dessine le ciel (les nuages)
     ctx.drawImage(backdrop, 0, 0);    //Dessine les arbres d'arrière-plan
}

//     --Fonction de lancement du jeu
function lancer_jeu(e) {
     OFFSET = getOffsetPosition(canvas);
     mouse_x = (e.pageX || (e.clientX + document.body.scrollLeft +  document.documentElement.scrollLeft)) - OFFSET[0]; // Calcule de la position x de la souris
     mouse_y = (e.pageY || (e.clientY + document.body.scrollTop + document.documentElement.scrollTop)) - OFFSET[1];  // Calcule de la position y de la souris
     var positions = [mouse_x,mouse_y]; //Définit un tableau contenant la position x et y de la souris
     if ( positions[ 0 ] > 245 && positions[ 0 ] < 360 && positions[ 1 ] > 158 && positions[ 1 ] < 208 ) { //Si la position de la souris est sur le bouton, on lance le jeu
          start_game();
       }
}

//Fonction qui dessine l'animation d'un avatar en fonction de la sprite_table, de la postion de l'avatar sur la sprite_table, et de la position où on souhaite le dessiner
function drawFrame(frameX, frameY, canvasX, canvasY) {
     ctx.drawImage(avatar_normal, frameX *  player.width, frameY * player.height,  player.width, player.height, canvasX, canvasY, player.width, player.height);
}
//Fonction boucle du jeu
function animate() {
     //Vérification de la collision avec un obstacle
     if ((player.width >= obstacle_x+15) && (5 <= obstacle_x +obs1.width-35) && (player.y+player.height >= obs_y) && (player.y <= obs_y+obs1.height)) {
          save_score(score); //Si le personnage rentre en colision avec l'obstacle, envoie le score à la fonction de sauvegarde du score
     } else {
          requestAnimFrame( animate ); //Boucle de l'animation
     }
     //Affichage du décors
     ctx.clearRect(0, 0, canvas.width, canvas.height); //On vide le canvas de toute image précedemment dessinées
     draw_asset(); //On dessines les images d'arrière-plan
     //Affichage du score
     ctx.font = '48px serif'; //On définit la taille d'écriture et la police d'écriture
     ctx.fillStyle = "Black"; //On définit la couleur de remplissage
     ctx.fillText('Score : '+score, 10, 50);      //On affiche le score
     //Affichage du sol déffilant
     for (i = 0; i < ground.length; i++) {
          ground[i].x -= player.speed;
          ctx.drawImage(grass, ground[i].x, ground[i].y);
     }
     //Si un bloc de terre sort de l'écran, on le supprime et le replace à la fin du tableau
     if (ground[0].x <= -platformWidth) {
          ground.shift();
          ground.push({'x': ground[ground.length-1].x + platformWidth, 'y': platformHeight});
     }
     //Affichage des obstacles
     ctx.drawImage(obs1, obstacle_x, obs_y);
     obstacle_x -= obs_speed;
     //Actualisation de l'obstacle
     if (obstacle_x <= 0-obs1.width) {
          //Calcul d'un nombre entier random entre 0 et X (exclu)
          obs = getRandomInt(3);     //Calcul d'un nombre entier random entre 0 et X (exclu)
          switch (obs) {             //Changement de la source et de la taille de l'image en fonction du nombre obtenue
               case 1 :
                    obs1.src = "images/buisson.png"
                    obs1.width = 157;
                    obs1.height = 112;
                    obs_y = 240;
                    break;
               case 2 :
                    obs1.src = "images/bird.png"
                    obs1.width = 95;
                    obs1.height = 59;
                    obs_y = 220;
                    break;
               default :
                    obs1.src = "images/Arbre.png";
                    obs1.width = 130;
                    obs1.height = 131;
                    obs_y = 221;
          }
          obstacle_x = 820;                 //Déplacement de l'obstacle pour remise à zero
     }
     //Si le joueur ne glisse pas, on le dessine en l'animant
     if (!glisse) {
          drawFrame(cycleLoop[currentLoopIndex], 0, 0, player.y);
     } else {
          //Si il glisse, on dessine simplement l'image
          ctx.drawImage(avatar_normal,0,player.y)
     }
     //Calcul du saut
     //Si le personnage saute et qu'il a un y supérieur à 100, on augmente progressivement son y
     if (saut && (player.y > 100)) {
          player.y = player.y * 0.965;
     //si le personnage saute et qu'il a y inférieur ou égal à 100, on augmente le temps de saut
     } else if (saut && (player.y <= 100)) {
          tmps_saut++;
     //Si le joueur ne saute pas et qu'il n'est pas revenu à sa position par défaut
     //   ou que le temps de saut est dépassé et qu'il n'est pas revenu à sa position par défaut,
     //   alors on remet le saut sur false et on diminue progressivement sa hauteur
     } else if ((!saut && (player.y < default_y)) || ((tmps_saut>tmps_saut_max) && (player.y < default_y))) {
          saut = false;
          player.y = player.y * 1.035;
     //Si on ne saute plus et qu'on ne glisse pas,
     //   on remet le temps de saut à 0 et la position par defaut
     } else if (!glisse){
          tmps_saut = 0;
          player.y = default_y;
     }
     //On augmente la nombre de frame de 1
     frameCount++;
     //Si le nombre de frame modulo 4 est égale à 0, on augmente l'index de l'image du personnage de 1
     if ((frameCount % 4) == 0) {
          currentLoopIndex++;
     }
     //Si le nombre de frame modulo 12 est égale à 0, on augmente le score de 1
     if ((frameCount % 12) == 0) {
          score++;
     }
     //Si on dépasse l'index des images, on replace l'index à 0 et on reset le nombre de frame
     if (currentLoopIndex >= cycleLoop.length) {
       currentLoopIndex = 0;
       frameCount = 0;
     }
     //Si le score modulo 200 est égale à 0 et le score est supérieure à 0
     //   on augmente la vitesse de 0.3
     //   et on enlève 10 au temps de saut maximum si le temps de saut max n'est pas inférieur à 10
     if (((score % 200) == 0) && score > 0) {
          obs_speed += 0.3;
          if (tmps_saut_max > 10) {
               tmps_saut_max -= 10;
          }
     }
}

// -- Fonction de démarage du jeu
function start_game() {
     // Gestion des events
     document.addEventListener('keydown', function (evt) {
          //Si on appuie sur la flèche du haut ou la touche z, alors
          if ((evt.keyCode === 38) || (evt.keyCode === 90)) {
          //Si le temps du saut est inférieur au tamps de saut maximum,
          //   alors on met la variable saut sur true
               if (tmps_saut <=tmps_saut_max) {
                    saut = true;
          //Sinon, on met la variable saut sur false
               } else {
                    saut = false;
               }
          //Si on appuie sur la flèche du bas ou la toucche s, alors on change l'image, la taille, la position du joueur, et on met la variable glisse sur true
     } else if ((evt.keyCode === 40) || (evt.keyCode === 83)) {
               avatar_normal.src = "images/glisse.png";
               avatar_normal.height = 60;
               player.y = 292;
               glisse = true;
          }
     });
     document.addEventListener("keyup", function (evt) {
          //Si on relache la touche flèche haut ou la touche z, alors on met la variable saut sur false
          if ((evt.keyCode === 38) || (evt.keyCode === 90)) {
               saut = false;
          //Si on relache la touche flèche bas ou la touche s, alors on remet la source, la taille, la position du joueur par défaut, et on met la variable glisse sur false
          } else if ((evt.keyCode === 40) || (evt.keyCode === 83)) {
               avatar_normal.src = "images/sprite_normal.png";
               avatar_normal.height = 108;
               player.y = 256;
               glisse = false;
          }
     });
     //On enlève l'évènement "lancer la fonction lancer_jeu sur un clique"
     window.removeEventListener("mousedown", lancer_jeu)
     ctx.clearRect(0, 0, canvas.width, canvas.height); //On vide le canvas de toute image précedemment dessinées

     // On définit la taille, la vitesse, la source et la hauteur du personnage
     player.width  = 132;
     player.height = 94;
     player.speed  = 5;
     avatar_normal.src = "images/sprite_normal.png";
     avatar_normal.height = 94;

     score = 0;     //Initialisation de la variable score
     ground = [];   //Initialisation de la variable sol
     tmps_saut_max = 40; //Initialisation de la variable temps de saut max
     frameCount = 0;     //Initialisation de la variable qui compte les frames
     currentLoopIndex = 0;    //Initialisation de la variable de position de l'avatar sur la spritesheet
     obstacle_x = 820;   //Initialisation de la variable obstacle_x
     obs_speed = 6; //Initialisation de la variable de vitesse de l'obstacle
     obs_y = 221;   //Initialisation de la variable hauteur de l'obstacle
     saut = false;  //Initialisation de la variable de saut

     //Initialisation du tableau de sol
     for (i = 0, length = Math.floor(canvas.width / platformWidth) + 2; i < length; i++) {
          ground[i] = {'x': i * platformWidth, 'y': platformHeight};
     }
     player.y = 256;     //Initialisation de la variable de hauteur de position du personnage
     default_y = 256;    //Initialisation de la variable de hauteur de position du personnage

     animate();     //Lance l'animation du jeu
}

//Fonction du menu de jeu
function menu() {
     ctx.clearRect(0, 0, canvas.width, canvas.height); //On vide le canvas de toute image précedemment dessinées
     window.addEventListener("mousedown", lancer_jeu); //On ajoute un event qui lance la fonction lancer_jeu au moment où l'on appuie sur un bouton de la souris
     //On définie un gradient circulaire de couleurs rouge et blanc
     var grd = ctx.createRadialGradient(410, 230, 50, 390, 250, 300);
     grd.addColorStop(0, "gray");
     grd.addColorStop(1, "white");
     //On dit à la fonction que jusqu'à nouvel ordre, on remplira tout dessin avec le gradient définie juste au dessus
     ctx.fillStyle = grd;
     //on dessine un rectangle de la taille du canvas
     ctx.fillRect(0, 0, canvas.width, canvas.height);
     //On dessine le bouton jouer
     ctx.drawImage(bouton_jouer, 320, 202);
}

//Lancement automatique au chargement de la page
window.onload = function() {
     menu(); //Lancement de la fonction menu au chargement de la page
}
