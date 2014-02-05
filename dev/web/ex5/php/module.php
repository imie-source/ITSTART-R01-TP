<?php
	
	include("fonctions.inc.php");
 
	$lesCategories = createOptionsFromTable("Categorie", "idCategorie", "categorie_libelle"); 
	$lesNiveaux = createOptionsFromTable("Niveau", "idNiveau", "niveau_libelle"); 
	$lesModalites = createOptionsFromTable("Modalite", "idModalite", "modalite_libelle"); 

	include("../html/module.html");
	
?>