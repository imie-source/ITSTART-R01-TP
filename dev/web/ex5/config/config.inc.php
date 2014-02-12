<?php

/* Fichier contenant la configuration de l'application */

/* Définition des constantes sur la base et les tables */
	define('TABLE_MODULE', "Module");
	define('TABLE_NIVEAU', "Niveau");
	define('TABLE_CATEGORIE', "Categorie");
	define('TABLE_MODALITE', "Modalite");
	define('TABLE_MODULE_HAS_MODALITE', "Module_has_Modalite");
	
	define('MODULE_ID', "idModule");
	define('MODULE_IDNIVEAU', "Niveau_idNiveau");
	define('MODULE_IDCATEGORIE',"Categorie_idCategorie");
	define('MODULE_INTITULE', "intitule_module");
	define('MODULE_OBJECTIFS', "objectifs");
	define('MODULE_DUREE', "duree");
	define('MODULE_PUBLIC', "public");
	define('MODULE_PREREQUIS', "prerequis");
	define('MODULE_PROGRAMME', "programme");
	
	define('NIVEAU_ID', "idNiveau");
	define('NIVEAU_LIBELLE', "niveau_libelle");
	
	define('CATEGORIE_ID', "idCategorie");
	define('CATEGORIE_LIBELLE', "categorie_libelle");
	
	define('MODALITE_ID', "idModalite");
	define('MODALITE_LIBELLE', "modalite_libelle");
	
	define('MODMOD_IDMODULE', "Module_idModule");
	define('MODMOD_IDMODALITE', "Modalite_idModalite");
	
	/* Définition des variables utiles à la connexion à la base de données */
	$utilisateur = "modules";
	$motdepasse = "modules2014!";
	$hote = "127.0.0.1";
	$port = 3306;
	$nomBase = "modules";
	
?>	