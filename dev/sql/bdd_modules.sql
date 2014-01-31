/* Cr�ation de la base de donn�es module */

CREATE DATABASE module;

/* Utilisation de la base module */

USE module;

/* Cr�ation de la table Categorie */

CREATE TABLE Categorie (
	idCategorie CHAR(1) NOT NULL,
	categorie_libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (idCategorie)
);

/* Peuplement de la table Categorie 
	1 enregistrement par instruction
*/

INSERT INTO Categorie (categorie_libelle) VALUES ("G�n�rale");
INSERT INTO Categorie (categorie_libelle) VALUES ("Syst�me et R�seau");
INSERT INTO Categorie (categorie_libelle) VALUES ("D�veloppement");
INSERT INTO Categorie (categorie_libelle) VALUES ("Projet");

/* Cr�ation de la table Niveau */

CREATE TABLE Niveau (
	idNiveau INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	niveau_libelle VARCHAR(20) NOT NULL,
	PRIMARY KEY (idNiveau)
);

/* Peuplement de la table Niveau 
	3 enregistrements en une seule instruction
*/

INSERT INTO Niveau (niveau_libelle) VALUES ("D�butant"), ("Confirm�"), ("Expert");

/* Cr�ation de la table Modalite */

CREATE TABLE Modalite (
	idModalite INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	modalite_libelle VARCHAR(255) NOT NULL,
	PRIMARY KEY (idModalite)
);

/* Peuplement de la table Modalit� 
	3 enregistrements en une seule instruction
*/

INSERT INTO Modalite (modalite_libelle) VALUES 
	("Dict�e"), 
	("Exercices r�dactionnels rapides"), 
	("Exercices pratiques");
	

/* Cr�ation de la table module 
   avec cr�ation des cl�s �trang�res */

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
