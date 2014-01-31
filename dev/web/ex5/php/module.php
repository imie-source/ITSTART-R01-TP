<?php
	
	include("fonctions.inc.php");

	$tabCategories = getDonnees("Categorie");
	if (false == $tabCategories) {
		$lesCategories = "<option value=\"\">BD not connected</option>";
	} else {
		$lesCategories = "";
		for($i = 0; $i < count($tabCategories); $i++) {
			$lesCategories .= "<option value=\"" . 
				$tabCategories[$i]["idCategorie"] . "\">" . 
				utf8_encode($tabCategories[$i]["categorie_libelle"]) . "</option>\n";
		}
	}
	
	include("../html/module.html");
	
?>