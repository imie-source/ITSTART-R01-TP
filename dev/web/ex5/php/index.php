<?php

	include("fonctionnalites.inc.php");
	
	// Poste de pilotage
	// On récupère l'action souhaitée (en POST ou en GET)
	if (isset($_GET["action"])) {
		$action = $_GET["action"];
	} else if (isset($_POST["action"])) {
		$action = $_POST["action"];
	} else {
		$action = false;
	}	
	// En fonction de l'action
	switch($action) {
		case "creerModule":
			creerModule(isset($_GET["idModule"]) ? $_GET["idModule"] : false);
			break;
		case "enregistrerModule":
			enregistrerModule($_POST);
			break;
		case "listerModule":
			listeDesModules();
			break;
		case "supprimerModule":
			if (isset($_POST["idModule"])) {
				supprimerModule($_POST["idModule"]);
			}	
			break;
		default:
			include("../html/accueil.html");
	}		
	
?>