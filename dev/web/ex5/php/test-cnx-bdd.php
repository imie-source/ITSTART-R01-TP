<?php
	include("fonctions.inc.php");

	$tabNiveau = getDonnees("Niveau");
	echo "Voici le contenu de la table Niveau : <br />";
	if (false == $tabNiveau) {
		echo "La connexion n'a pas pu �tre r�alis�e...";
	} else {
		for($i = 0; $i < count($tabNiveau); $i++) {
			echo $tabNiveau[$i]["idNiveau"] . " : ". 
				 $tabNiveau[$i]["niveau_libelle"] . "<br />";
		}
	}
?>











