<?php

	// Inclusion pour pouvoir utiliser la fonction getDonnees
	include("fonctions.inc.php");
	
	// Initialisation de la variable qui va contenir le code HTML de la liste
	// des modules
	$lesModules = "";
	
	// On récupère l'ensemble des enregistrements de la table Module sous
	// forme de tableau de tableaux associatifs
	$tabModules = getDonnees("Module", array("intitule_module", "idModule"));
	
	// On parcourt l'ensemble des enregistrements et on en extrait l'intitulé
	// qui est rajouté à la variable $lesModules encapsulé par des balises
	// HTML de paragraphes
	for($i = 0; $i < count($tabModules); $i++) {
		$lesModules .= "<tr>";
		$lesModules .= "<td style=\"border: 1px solid black;\" >";
		$lesModules .= "<a href=\"module.php?idModule=" . $tabModules[$i]["idModule"] . "\">" . $tabModules[$i]["intitule_module"] . "</a>";
		$lesModules .= "</td>";
		$lesModules .= "<td style=\"text-align: center; vertical-align: middle;\" >";
		$lesModules .= "<img src=\"../medias/images/supprimer.gif\" onclick=\"suppression(" . $tabModules[$i]["idModule"] . ");\"/>";
		$lesModules .= "</td>";
		$lesModules .= "</tr>\n";
	}
	
	// On inclue finalement le fichier HTML global
	include("../html/liste_modules.html");

?>