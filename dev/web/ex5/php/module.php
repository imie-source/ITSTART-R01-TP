<?php
	
	include("fonctions.inc.php");
	
	$idModule = isset($_GET["idModule"]) ? $_GET["idModule"] : false;

	// Initialisation "générale" des différentes variables présentes dans
	// le formulaire
	
	$intitule = "";
	$objectifs = "";
	$public = "";
	$duree = "";
	$programme = "";
	$prerequis = "";
	$categorie = false;
	$niveau = false;
	// Comme il peut y avoir plusieurs modalités liées à un module
	// On définit la variable $tabModalites commes un tableau
	$tabModalites = array();
		
	// Si un id de module est passé en paramètre (méthode GET)
	if ($idModule) {
		// Récupération de l'ensemble des enregistrements des modules
		$tabModules = getDonnees("Module");
		// Recherche du module spécifique
		for($i = 0; $i < count($tabModules); $i++) {
			// L'id du module correspond-il à celui demandé ?
			if ($tabModules[$i]["idModule"] == $idModule) {
				// Oui, on récupère l'ensemble des informations
				$intitule = $tabModules[$i]["intitule_module"];
				$objectifs = $tabModules[$i]["objectifs"];
				$public = $tabModules[$i]["public"];
				$duree = $tabModules[$i]["duree"];
				$programme = $tabModules[$i]["programme"];
				$prerequis = $tabModules[$i]["prerequis"];
				$categorie = $tabModules[$i]["Categorie_idCategorie"];
				$niveau = $tabModules[$i]["Niveau_idNiveau"];
				// Pas la peine de continuer, on a trouvé, donc on arrête la boucle
				break;
			}
		}
		$tabRelationModuleModalites = getDonnees("module_has_modalite");
		// Recherche des modalités liées au module spécifique
		// On parcourt l'ensemble des relations entre les modules et les modalités
		for($i = 0; $i < count($tabRelationModuleModalites); $i++) {
			// Si une relation met en jeu le module demandé
			if ($tabRelationModuleModalites[$i]["Module_idModule"] == $idModule) {
				// On stocke l'id de la modalité dans le tableau $tabModalites
				$tabModalites[] = $tabRelationModuleModalites[$i]["Modalite_idModalite"];
			}
		}
	}
	// Génération des listes des "select" avec potentiellement la "sélection" d'une passée en 4ème argument
	$lesCategories = createOptionsFromTable("Categorie", "idCategorie", "categorie_libelle", $categorie); 
	$lesNiveaux = createOptionsFromTable("Niveau", "idNiveau", "niveau_libelle", $niveau); 
	$lesModalites = createOptionsFromTable("Modalite", "idModalite", "modalite_libelle", $tabModalites); 

	include("../html/module.html");
	
?>