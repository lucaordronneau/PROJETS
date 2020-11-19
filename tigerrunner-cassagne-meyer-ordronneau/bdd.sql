DROP TABLE IF EXISTS Score;
DROP TABLE IF EXISTS Messagerie;
DROP TABLE IF EXISTS Blocage;
DROP TABLE IF EXISTS Signalement;
DROP TABLE IF EXISTS Inscrits;
DROP TABLE IF EXISTS Adresse;
DROP TABLE IF EXISTS Roles;

CREATE TABLE Adresse (
	idAdresse int(11) PRIMARY KEY AUTO_INCREMENT,
	numero varchar(20) NOT NULL,
	rue varchar(60) NOT NULL,
	postal int(11) NOT NULL,
	ville varchar(30) NOT NULL
);

CREATE TABLE Roles (
	idRole int(11) PRIMARY KEY AUTO_INCREMENT,
	role varchar(20) NOT NULL
);

CREATE TABLE Inscrits (
	idUtilisateur int(11) PRIMARY KEY AUTO_INCREMENT,
	nom varchar(30) NOT NULL,
	prenom varchar(20) NOT NULL,
	email varchar(256) DEFAULT '',
	infos varchar(500) DEFAULT '',
	sexe varchar(10) NOT NULL,
	idAdresse int(11) NOT NULL,
	passe varchar(20) NOT NULL,
	idRole int(11) NOT NULL,
	FOREIGN KEY (idAdresse) REFERENCES Adresse(idAdresse),
	FOREIGN KEY (idRole) REFERENCES Roles(idRole)
);

CREATE TABLE Ami (
	idJoueur int(11) NOT NULL,
	idAmi int(11) NOT NULL,
	PRIMARY KEY (idJoueur, idAmi),
	FOREIGN KEY (idJoueur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE,
	FOREIGN KEY (idAmi) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE
);

CREATE TABLE Score (
	idScore int(11) PRIMARY KEY AUTO_INCREMENT,
	idUtilisateur int(11) NOT NULL,
	score int(11) NOT NULL,
	FOREIGN KEY (idUtilisateur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE
);

CREATE TABLE Messagerie (
	idEnvoyeur int(11) NOT NULL,
	idReceveur int(11) NOT NULL,
	dates DATETIME NOT NULL,
	message varchar(280) NOT NULL,
	PRIMARY KEY (idEnvoyeur, idReceveur, dates),
	FOREIGN KEY (idEnvoyeur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE,
	FOREIGN KEY (idReceveur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE
);

CREATE TABLE Blocage (
	idUtilisateur int(11) NOT NULL,
	idBloquer int(11) NOT NULL,
	FOREIGN KEY (idUtilisateur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE,
	FOREIGN KEY (idBloquer) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE
);

CREATE TABLE Signalement (
	idIncrement int(11) PRIMARY KEY AUTO_INCREMENT,
	idEnvoyeur int(11) NOT NULL,
	idReceveur int(11) NOT NULL,
	dates DATETIME,
	FOREIGN KEY (idEnvoyeur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE,
	FOREIGN KEY (idReceveur) REFERENCES Inscrits(idUtilisateur) ON DELETE CASCADE
);

INSERT INTO Roles VALUES
(1, "Utilisateur"),
(2, "Administrateur");

INSERT INTO Adresse VALUES
(1, "34", "Avenue Louis Sallenave", "64000", "Pau"),
(2, "1", "Avenue du Général Leclerc", "64000", "Pau");

INSERT INTO Inscrits VALUES
(1, 'Toto', 'Titi',  'toto@gmail.com', '', 'Homme', 1, '123', 1),
(2, 'admin', 'admin',  'root', 'Admin du site Tiger Runner', 'Femme', 1, '1234', 2);
