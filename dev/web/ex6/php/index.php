<?php

	include("class/voiture.class.php");

	$maBatmobile = new voiture("rouge");
	
	echo $maBatmobile;
	
	$maBatmobile->setCouleur("bleue");
	
	echo "la couleur de ma voiture est : " . $maBatmobile->getCouleur() . "<br />";

?>