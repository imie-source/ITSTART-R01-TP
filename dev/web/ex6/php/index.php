<?php

	include_once("class/voiture.class.php");
	include_once("class/vehicule.class.php");

	$maBatmobile = new voiture("rouge", "lada", "coupébat", "ecoBAT-01", 2, 600, voiture::BV_AUTOMATIQUE, 12, voiture::ENERGIE_GPL);
	
	echo "<pre>" . htmlentities($maBatmobile, ENT_HTML5) . "</pre>";

	$monTracteurRouge = new vehicule("rouge", "MASSEY FERGUSON", "MF 8500", 400, vehicule::ENERGIE_FUEL);
	
	echo "<pre>" . htmlentities($monTracteurRouge, ENT_HTML5) . "</pre>";

?>