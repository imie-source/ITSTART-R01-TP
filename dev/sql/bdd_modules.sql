/* Création de la base de données module */

CREATE DATABASE module;

/* Utilisation de la base module */

USE module;

/* Création de la table "entité" Categorie */

CREATE TABLE Categorie (
	idCategorie CHAR(1) NOT NULL,
	categorie_libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (idCategorie)
);

/* Peuplement de la table Categorie 
	1 enregistrement par instruction
*/

INSERT INTO Categorie (categorie_libelle) VALUES ("Générale");
INSERT INTO Categorie (categorie_libelle) VALUES ("Système et Réseau");
INSERT INTO Categorie (categorie_libelle) VALUES ("Développement");
INSERT INTO Categorie (categorie_libelle) VALUES ("Projet");

/* Création de la table "entité" Niveau */

CREATE TABLE Niveau (
	idNiveau INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	niveau_libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (idNiveau)
);

/* Peuplement de la table Niveau 
	3 enregistrements en une seule instruction
*/

INSERT INTO Niveau (niveau_libelle) VALUES ("Débutant"), ("Confirmé"), ("Expert");

/* Création de la table "entité"  Modalite */

CREATE TABLE Modalite (
	idModalite INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	modalite_libelle VARCHAR(255) NOT NULL,
	PRIMARY KEY (idModalite)
);

/* Peuplement de la table Modalité 
	3 enregistrements en une seule instruction
*/

INSERT INTO Modalite (modalite_libelle) VALUES 
	("Dictée"), 
	("Exercices rédactionnels rapides"), 
	("Exercices pratiques");
	

/* Création de la table "entité" module 
   avec création des clés étrangères */

CREATE TABLE Module (
	idModule INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	intitule_module VARCHAR(255) NOT NULL,
	objectifs TEXT NOT NULL,
	duree FLOAT UNSIGNED NOT NULL,
	public TEXT NOT NULL,
	prerequis TEXT,
	programme TEXT NOT NULL,
	Niveau_idNiveau INTEGER UNSIGNED NOT NULL,
	Categorie_idCategorie CHAR(1) NOT NULL,
	PRIMARY KEY (idModule),
	FOREIGN KEY (Niveau_idNiveau) REFERENCES Niveau (idNiveau),
	FOREIGN KEY (Categorie_idCategorie) REFERENCES Categorie (idCategorie)
);

/* Création de la table "association/relation" Module_has_Modalite
*/

CREATE TABLE Module_has_Modalite (
	Module_idModule INTEGER UNSIGNED NOT NULL,
	Modalite_idModalite INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (Module_idModule, Modalite_idModalite),
	FOREIGN KEY (Module_idModule) REFERENCES Module (idModule),
	FOREIGN KEY (Modalite_idModalite) REFERENCES Modalite (idModalite)
);	