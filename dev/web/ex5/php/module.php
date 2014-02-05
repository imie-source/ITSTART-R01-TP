<?php
	
	include("fonctions.inc.php");

	$tabCategories = getDonnees("Categorie");
	if (!is_array($tabCategories)) {
		$lesCategories = "<option value=\"\">BD not connected : " . utf8_encode($tabCategories) . "</option>";
	} else {
		$lesCategories = "";
		for($i = 0; $i < count($tabCategories); $i++) {
			$lesCategories .= "<option value=\"" . 
				$tabCategories[$i]["idCategorie"] . "\">" . 
				utf8_encode($tabCategories[$i]["categorie_libelle"]) . "</option>\n";
		}
	}

	$tabNiveaux = getDonnees("Niveau");
	if (!is_array($tabNiveaux)) {
		$lesNiveaux = "<option value=\"\">BD not connected : " . utf8_encode($tabNiveaux) . "</option>";
	} else {
		$lesNiveaux = "";
		for($i = 0; $i < count($tabNiveaux); $i++) {
			$lesNiveaux .= "<option value=\"" . 
				$tabNiveaux[$i]["idNiveau"] . "\">" . 
				utf8_encode($tabNiveaux[$i]["niveau_libelle"]) . "</option>\n";
		}
	}

	$tabModalites = getDonnees("Modalite");
	if (!is_array($tabModalites)) {
		$lesModalites = "<option value=\"\">BD not connected : " . utf8_encode($tabModalites) . "</option>";
	} else {
		$lesModalites = "";
		for($i = 0; $i < count($tabModalites); $i++) {
			$lesModalites .= "<option value=\"" . 
				$tabModalites[$i]["idModalite"] . "\">" . 
				utf8_encode($tabModalites[$i]["modalite_libelle"]) . "</option>\n";
		}
	}
	
	include("../html/module.html");
	
?>