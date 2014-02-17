<?php

	include("class/voiture.class.php");

	$maBatmobile = new voiture("rouge", "lada", "coupébat", "ecoBAT-01", 2, 600, "automatique", 12, "GPL");
	
	echo $maBatmobile;
	
	$maBatmobile->setCouleur("bleue");
	
	echo "la couleur de ma voiture est : " . $maBatmobile->getCouleur() . "<br />";

?>