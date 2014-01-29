<?php

/*	foreach($_POST as $etiquette => $valeur) {
		if ($etiquette == "modalites") {
			echo "<p>" . $etiquette . " : ";
			for($i = 0; $i < count($valeur); $i++) {
				echo $valeur[$i] . ",";
			}
			echo "</p>\n";
		} else {	
			echo "<p>" . $etiquette . " : " . $valeur . "</p>\n";
		}	
	}*/
	
	foreach($_POST as $etiquette => $valeur) {
		if (is_array($valeur)) {
			echo "<p>" . $etiquette . " : ";
			for($i = 0; $i < count($valeur); $i++) {
				echo $valeur[$i] . ",";
			}
			echo "</p>\n";
		} else {	
			echo "<p>" . $etiquette . " : " . $valeur . "</p>\n";
		}	
	}


/*	$categorie = isset($_POST["categorie"]) ? $_POST["categorie"] : "ND";
	$niveau = isset($_POST["niveau"]) ? $_POST["niveau"] : "ND";
	$intitule = isset($_POST["intitule"]) ? $_POST["intitule"] : "ND";
	$duree = isset($_POST["duree"]) ? $_POST["duree"] : "ND";
	$public = isset($_POST["public"]) ? $_POST["public"] : "ND";
	$prerequis = isset($_POST["prerequis"]) ? $_POST["prerequis"] : "ND";
	$tabModalites = isset($_POST["modalites"]) ? $_POST["modalites"] : "ND";
	$programme = isset($_POST["programme"]) ? $_POST["programme"] : "ND";
	
	echo "<p>cat&eacute;gorie : $categorie</p>\n";
	echo "<p>niveau : $niveau</p>\n";
	echo "<p>intitul&eacute; : " . $intitule . "</p>\n";
	echo "<p>dur&eacute;e : $duree</p>\n";
	echo "<p>public : $public</p>\n";
	echo "<p>pr&eacute;-requis : $prerequis</p>\n";
	echo "<p>modalit&eacute;s : ";
	for($i = 0; $i < count($tabModalites); $i++) {
		echo $tabModalites[$i] . ",";
	}
	echo "</p>\n";
	echo "<p>programme : $programme</p>\n";
	
	*/
?>