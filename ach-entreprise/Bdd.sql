DROP TABLE IF EXISTS Inscrire;
DROP TABLE IF EXISTS Diplome_necessaire;
DROP TABLE IF EXISTS Formation;
DROP TABLE IF EXISTS Organisme;
DROP TABLE IF EXISTS Statut;
DROP TABLE IF EXISTS Util_ACH;
DROP TABLE IF EXISTS Inscrit;
DROP TABLE IF EXISTS Personnel;
DROP TABLE IF EXISTS Role;
DROP TABLE IF EXISTS Admin_organisme;
DROP TABLE IF EXISTS Lieu;
DROP TABLE IF EXISTS Adresse;

CREATE TABLE Adresse(
	idAdresse int(11) PRIMARY KEY AUTO_INCREMENT,
	numero varchar(20) NOT NULL,
	rue varchar(60) NOT NULL,
	postal int(11) NOT NULL,
	ville varchar(30) NOT NULL
);

CREATE TABLE Lieu(
	idLieu int(11) PRIMARY KEY AUTO_INCREMENT,
	longitude float(50) NOT NULL,
	latitude float(50) NOT NULL,
	idAdresse_fk int(11),
	FOREIGN KEY Adresse_fk(idAdresse_fk) REFERENCES Adresse (idAdresse)
);


CREATE TABLE Admin_organisme(
	idAdmin_organisme int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email varchar(256) NOT NULL,
    mdp varchar(256) NOT NULL
);

CREATE TABLE Role(
    idRole int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    personnel int(11) NOT NULL,
    regulateur int(11) NOT NULL,
    administrateur int(11) NOT NULL,
    king int(11) NOT NULL
);

CREATE TABLE Personnel(
	idPersonnel int(11) PRIMARY KEY AUTO_INCREMENT,
	nom varchar(30) NOT NULL,
	prenom varchar(30) NOT NULL,
	photo varchar(30) NOT NULL
);

CREATE TABLE Inscrit(
	idInscrit int(11) PRIMARY KEY AUTO_INCREMENT,
	nom varchar(30) NOT NULL,
	prenom varchar(30) NOT NULL,
	naissance DATETIME NOT NULL,
	mail varchar(30) NOT NULL,
  fichier1 varchar(100) NOT NULL,
  fichier2 varchar(100) NOT NULL,
	idAdresse_fk int(11))
;
ALTER TABLE Inscrit ADD CONSTRAINT Adresse_fk FOREIGN KEY (idAdresse_fk) REFERENCES Adresse (idAdresse);


CREATE TABLE Util_ACH(
	idAdmin int(11) PRIMARY KEY AUTO_INCREMENT,
	mail varchar(30) NOT NULL,
	nom varchar(30) NOT NULL,
	prenom varchar(30) NOT NULL,
	mdp varchar(256) NOT NULL,
	idRole_fk int(11)
);
ALTER TABLE Util_ACH ADD CONSTRAINT Role_fk FOREIGN KEY (idRole_fk) REFERENCES Role (idRole);


CREATE TABLE Statut(
	idStatut int(11) PRIMARY KEY AUTO_INCREMENT,
	accepte int(11) NOT NULL,
	attente int(11) NOT NULL,
	refuse int(11) NOT NULL
);

CREATE TABLE Organisme(
	idOrganisme int(11) PRIMARY KEY AUTO_INCREMENT,
	nom varchar(30) NOT NULL,
	presentation varchar(280) NOT NULL,
	email varchar(256) NOT NULL,
	tel int(10) NOT NULL,
	idAdmin_organisme_fk int(11),
	idLieu_fk int(11),
	idPersonnel_fk int(11)
);
/*
ALTER TABLE Organisme ADD CONSTRAINT Lieu_fk FOREIGN KEY (idLieu_fk) REFERENCES Lieu (idLieu);
ALTER TABLE Organisme ADD CONSTRAINT Admin_organisme_fk FOREIGN KEY (idAdmin_organisme_fk) REFERENCES Admin_organisme (idAdmin_organisme);
ALTER TABLE Organisme ADD CONSTRAINT Personnel_fk FOREIGN KEY (idPersonnel_fk) REFERENCES Personnel (idPersonnel); */

CREATE TABLE Formation(
	idFormation int(11) PRIMARY KEY AUTO_INCREMENT,
	nom varchar(80) NOT NULL,
	diplome varchar(80) NOT NULL,
	prix float(11) NOT NULL,
	perspective varchar(1000) NOT NULL,
	description varchar(1000) NOT NULL,
	domaine varchar(1000) NOT NULL,
	financement varchar(1000) NOT NULL,
	epreuves varchar(1000) NULL,
	prerequis varchar(1000) NULL,
	dates DATETIME NOT NULL,
	duree varchar(1000) NOT NULL,
	idLieu_fk int(11),
	idOrganisme_fk int(11),
	idStatut_fk int(11),
	FOREIGN KEY Lieu_fk(idLieu_fk) REFERENCES Lieu (idLieu),
	FOREIGN KEY Statut_fk(idStatut_fk) REFERENCES Statut (idStatut),
	FOREIGN KEY Organisme_fk(idOrganisme_fk) REFERENCES Organisme (idOrganisme)
);


CREATE TABLE Inscrire(
	idFormation_fk int(11),
	idInscrit_fk int(11),
	etat int(11) DEFAULT 0,
	PRIMARY KEY (idFormation_fk, idInscrit_fk),
	FOREIGN KEY Formation_fk(idFormation_fk) REFERENCES Formation (idFormation),
	FOREIGN KEY Inscrit_fk(idInscrit_fk) REFERENCES Inscrit (idInscrit)
);


/* INSERTION ADMIN */
-- INSERT INTO Admin_organisme(idAdmin_organisme,email,mdp) VALUES ('1','lagahehugo@gmail.com','123');
-- SELECT * FROM Admin_organisme;


/* EXEMPLE: INSERTION ADRESSE */

-- INSERT INTO Adresse (numero,rue,postal,ville) VALUES ('56','Boulevard de la paix', '64000', 'Pau');

/*  EXEMPLE : INSERTION LIEU */

-- INSERT INTO Lieu (longitude,latitude,idAdresse_fk) VALUES ('2.3488','48.8534','1');

/* EXEMPLE : INSERTION STATUT */

-- INSERT INTO Statut (accepte,refuse,attente) VALUES ('1','1','1');

/* EXEMPLE : INSERTION ORGANISME */
INSERT INTO Organisme (nom, presentation, email,tel) VALUES ('Sans orga','Sans orga!', 'sansorga@gmail.com', '0');



/* Vrais infos pour la BDD */




/* ORGANISME A L'EAU MNS */

INSERT INTO Personnel (idPersonnel,nom, prenom, photo) VALUES (2,"Dubois", "Alexandre", "photo2.jpg") ;

INSERT INTO Admin_organisme (idAdmin_organisme, email, mdp) VALUES (2, "adminmns@organisme.fr", "f757c82beaeaf49d8a97d3e63488a002");

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (2, 60, "Rue Christian Lacouture", 69500, "Bron") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (2, 2.287592, 48.862725, 2);


INSERT INTO Organisme (nom, presentation, email, tel, idAdmin_organisme_fk, idLieu_fk, idPersonnel_fk) VALUES ("A leau MNS", "Secourisme et sauvetage", "info@almns.org","0472819369", 2, 2, 2) ;


/* ORGANISME Global Training formation */

INSERT INTO Personnel (idPersonnel,nom, prenom, photo) VALUES (3,"Geoffrey", "Charette", "photo3.jpg") ;

INSERT INTO Admin_organisme (idAdmin_organisme, email, mdp) VALUES (3, "admingtf@organisme.fr", "f757c82beaeaf49d8a97d3e63488a002");

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (3, 4, "Rue Louis Armand", 75015, "Paris") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (3,2.277, 48.8329, 3);

INSERT INTO Organisme (nom, presentation, email, tel, idAdmin_organisme_fk, idLieu_fk, idPersonnel_fk) VALUES ("Global Training Formation", "Ecole de sport", "contact@globaltraining-formation.fr","0144263989", 3, 3, 3) ;





/* ORGANISME UCPA */

INSERT INTO Personnel (idPersonnel,nom, prenom, photo) VALUES (4,"Lionel", "Charles", "photo4.jpg") ;

INSERT INTO Admin_organisme (idAdmin_organisme, email, mdp) VALUES (4, "adminucpa@organisme.fr", "f757c82beaeaf49d8a97d3e63488a002");

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (4, 12, "Rue des Halles", 75001, "Paris") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (4, 2.3468681, 48.8598098, 4);

INSERT INTO Organisme (nom, presentation, email, tel, idAdmin_organisme_fk, idLieu_fk, idPersonnel_fk) VALUES ("UCPA", "Travail dans le sport", "contact@globaltraining-formation.fr","0145874786", 4, 4,4) ;


/* ORGANISME CFPMS */

INSERT INTO Personnel (idPersonnel,nom, prenom, photo) VALUES (5,"Dupont", "Jean", "photo1.jpg") ;

INSERT INTO Admin_organisme (idAdmin_organisme, email, mdp) VALUES (5, "admincfpms@organisme.fr", "f757c82beaeaf49d8a97d3e63488a002");

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (5, 22, "Boulevard Gambetta", 92130, "Issy-les-Moulineaux") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (5, 2.2778286, 48.827342, 5);


INSERT INTO Organisme (nom, presentation, email, tel, idAdmin_organisme_fk, idLieu_fk, idPersonnel_fk) VALUES ("CFPMS", " Travail dans le sport", "secretariat@cfpms.fr", "0756864660", 5, 5, 5) ;




/* AJOUT FORMATION 1 CFPMS */

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (6, 22, "Boulevard Gambetta", 92130, "Issy-les-Moulineaux") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (6, 2.3468681, 48.8598098, 5);

INSERT INTO Statut (idStatut, accepte, attente, refuse) VALUES (1, 1,0,0) ;

INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('Formation BPJEPS APT', 'BPJEPS AF','1490','Devenir coach...','Le titulaire de ce diplome peut envisager de devenir coach sportif', 'Coaching', 'Pole emploi, club sportifs','Le diplome est obtenu en 4 examens capitalisables. Il faut valider les 4 pour obtenir le diplome.','Avoir les TEP, son PSC et 18 ans minimum.', '2020-01-20','10 mois','6','1','5');




/* AJOUT FORMATION 1 UCPA */

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (7, 35, "Rue Jean Mermoz", 77400, "Lagny-sur-Marne") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (7, 2.71879, 48.8657, 7);

INSERT INTO Statut (idStatut, accepte, attente, refuse) VALUES (2, 1,0,0) ;

INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ("Formation au BNSSA + PSE1 + PSE2", "BNSSA + PSE1 + PSE2",'2000','Le possesseur du BPJEPS APT peut travailler dans des associations, en milieu scolaire et en structures','Ce diplome est le premier pas vers le
poste de Maitre Nageur Sauveteur (MNS).', 'Natation', 'Pole emploi, club de natation','4 examens de natation selon plusieurs criteres','17 ans minimum et certificat de premier secours obligatoire', '2020-01-01','une semaine','7','2','4');


/* AJOUT FORMATION 2 UCPA */

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (8, 2, "Route de Bez", 05240, "La-salle-les-Alpes") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (8, 2.287592, 48.862725, 8);

INSERT INTO Statut (idStatut, accepte, attente, refuse) VALUES (3, 1,0,0) ;

INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('Formation au DEJEPS VTT', 'DEJEPS VTT','2000','Faire le tour de France','Formation en alternance pour les saisonniers surtout.', 'Sport Individuel', 'Fond personnel','Il faut passer des tests physiques','Titulaire du PSC1 et bon niveau technique en VTT', '2020-05-01','10 mois','8','3','4'); 


/* AJOUT FORMATION SUD OUEST */


INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (9, 186, "Boulevard de la Paix", 64000, "Pau") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (9, -0.3517, 43.3192, 9);

INSERT INTO Statut (idStatut, accepte, attente, refuse) VALUES (4, 1,0,0) ;

INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('Formation BPJEPS Judo', 'BPJEPS Judo','300','Obtenir un niveau reconnu en Judo','Le titulaire de ce diplome peut devenir professeur de judo', 'Coaching', 'Club sportif','Le diplome est obtenu en validant tous les niveaux de ceinture existantes de judo.','Avoir 18 ans minimum.', '2020-02-22','3 mois','9','4','3');




/* AJOUT FORMATION EISTI */

INSERT INTO Admin_organisme (idAdmin_organisme, email, mdp) VALUES (6, "laurence@eisti.eu", "f757c82beaeaf49d8a97d3e63488a002");

INSERT INTO Adresse (idAdresse, numero, rue, postal, ville) VALUES (10, 2, "Boulevard Lucien Favre", 64000, "Pau") ;

INSERT INTO Lieu (idLieu, longitude, latitude, idAdresse_fk) VALUES (10, -0.3606969185336828, 43.318871010628676, 10);

INSERT INTO Personnel (idPersonnel,nom, prenom, photo) VALUES (6,"Lamoulie", "Laurence", "photo6.jpg") ;

INSERT INTO Organisme (nom, presentation, email, tel, idAdmin_organisme_fk, idLieu_fk, idPersonnel_fk) VALUES ("EISTI", "Formation ingénieurs", "eisti@eisti.fr", "0621547896", 6, 10, 6) ;

INSERT INTO Statut (idStatut, accepte, attente, refuse) VALUES (6, 1,0,0) ;

INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('Formation Ingenieur', 'Ingenieur Maths-Info','3500','Obtenir un statut reconnu par la CTI','Le titulaire de ce diplome peut travailler dans de nombreuses branches du monde professionel', 'Informatique-Maths', 'Etudes','Le diplome est obtenu en validant le cycle ingenieur','Bac+5.', '2022-12-31','5 ans','10','6','6'); 



INSERT INTO Role(personnel,regulateur,administrateur,king) VALUES ('1','1','1','1'); 

INSERT INTO Util_ACH(mail,nom,prenom,mdp,idRole_fk) VALUES ('test@eisti.eu','LAGAHE','Hugo','1d712b182c0b11dc482c8d61d7991a91','1');
      



















































-- INSERT INTO Organisme (nom, presentation, email,tel) VALUES ('ACH Intérim','Nous sommes une agence super!', 'ach-interim@gmail.com', '0606060606');

/* EXEMPLE : INSERTION FORMATION */

-- INSERT INTO Formation (nom,diplome,prix,perspective,description,domaine,financement,epreuves,prerequis,dates,duree,idLieu_fk,idStatut_fk,idOrganisme_fk) VALUES ('Secourisme', 'Recyclage PSE1','2500','perspective','Le titulaire du brevet national de sécurité et de sauvetage aquatique (BNSSA) peut travailler', 'Secourisme', 'financement','epreuves','prerequis', '2000-01-20','1 mois','1','1','1');

/* EXEMPLE : AFFICHER DETAILS FORMATION */

-- Select idFormation,nom,diplome,prix,perspective,description from Formation ;
