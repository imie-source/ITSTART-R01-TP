<?php
	
	include("fonctions.inc.php");
	
	$idModule = isset($_GET["idModule"]) ? $_GET["idModule"] : false;
 
	if ($idModule) {
		$intitule = "mon intitulé statique";
		$objectifs = "mes objectifs statiques";
		$public = "mon public statique";
		$duree = "-1";
		$programme = "mon programme statique";
		$prerequis = "mes pré-requis statiques";
	}
 
	$lesCategories = createOptionsFromTable("Categorie", "idCategorie", "categorie_libelle"); 
	$lesNiveaux = createOptionsFromTable("Niveau", "idNiveau", "niveau_libelle"); 
	$lesModalites = createOptionsFromTable("Modalite", "idModalite", "modalite_libelle"); 

	include("../html/module.html");
	
?>