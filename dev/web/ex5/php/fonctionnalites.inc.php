<?php

	include("fonctions.inc.php");

	/**
	 * Affiche un formulaire de saisie d'un module (renseigné ou non)
	 * @param int $idModule Id du module à afficher
	 */
	function creerModule($idModule) {
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
			$tabModules = getDonnees(TABLE_MODULE);
			// Recherche du module spécifique
			for($i = 0; $i < count($tabModules); $i++) {
				// L'id du module correspond-il à celui demandé ?
				if ($tabModules[$i][MODULE_ID] == $idModule) {
					// Oui, on récupère l'ensemble des informations
					$intitule = $tabModules[$i][MODULE_INTITULE];
					$objectifs = $tabModules[$i][MODULE_OBJECTIFS];
					$public = $tabModules[$i][MODULE_PUBLIC];
					$duree = $tabModules[$i][MODULE_DUREE];
					$programme = $tabModules[$i][MODULE_PROGRAMME];
					$prerequis = $tabModules[$i][MODULE_PREREQUIS];
					$categorie = $tabModules[$i][MODULE_IDCATEGORIE];
					$niveau = $tabModules[$i][MODULE_IDNIVEAU];
					// Pas la peine de continuer, on a trouvé, donc on arrête la boucle
					break;
				}
			}
			$tabRelationModuleModalites = getDonnees(TABLE_MODULE_HAS_MODALITE);
			// Recherche des modalités liées au module spécifique
			// On parcourt l'ensemble des relations entre les modules et les modalités
			for($i = 0; $i < count($tabRelationModuleModalites); $i++) {
				// Si une relation met en jeu le module demandé
				if ($tabRelationModuleModalites[$i][MODMOD_IDMODULE] == $idModule) {
					// On stocke l'id de la modalité dans le tableau $tabModalites
					$tabModalites[] = $tabRelationModuleModalites[$i][MODMOD_IDMODALITE];
				}
			}
		}
		// Génération des listes des "select" avec potentiellement la "sélection" d'une passée en 4ème argument
		$lesCategories = createOptionsFromTable(TABLE_CATEGORIE, CATEGORIE_ID, CATEGORIE_LIBELLE, $categorie); 
		$lesNiveaux = createOptionsFromTable(TABLE_NIVEAU, NIVEAU_ID, NIVEAU_LIBELLE, $niveau); 
		$lesModalites = createOptionsFromTable(TABLE_MODALITE, MODALITE_ID, MODALITE_LIBELLE, $tabModalites); 

		include("../html/module.html");
	} // Fin creerModule
	
	/**
	 * Insert dans la table Module_has_Modalite l'ensemble des relations entre un module
	 * et une ou plusieurs modalités : un enregistrement par relation
	 * @param array $tabModalites Liste des modalités en relation avec le module
	 * @param int $idModule l'id (clé primaire) du module
	 * @param resource $link "Ticket" de connexion à la base de données
	 */
	function attribueRelationsEntreModuleEtModalites($tabModalites, $idModule, $cnxPDO) {
		/* J'insère chaque relation entre le module et les modalités sous forme
		   d'enregistrements dans la table Module_has_Modalite */
		$requete = "INSERT INTO " . TABLE_MODULE_HAS_MODALITE . "  
					(" . MODMOD_IDMODALITE. ", " . MODMOD_IDMODULE . ") VALUES ";
		for($i = 0; $i < count($tabModalites); $i++) {
			$requete .= "(" . $tabModalites[$i] . ", $idModule)" . ($i < count($tabModalites)-1 ? "," : "");
		}
		
		/* Exécution de la requète */
		$result = $cnxPDO->exec($requete);
		if (false === $result) {
			// On affiche une erreur et on quitte le script
			bddErreur(BDD_ERREUR_INSERT, $cnxPDO->errorInfo());
		}
	} // Fin attribueRelationsEntreModuleEtModalites
	
	/**
	 * Enregistre le module dont les informations sont passées dans la variable
	 * globale $_POST
	 */  
	function enregistrerModule() {
		global $_POST;
		// Partie définition des variables ultérieurement utilisées
		$categorie = isset($_POST["categorie"]) ? $_POST["categorie"] : "ND";
		$niveau = isset($_POST["niveau"]) ? $_POST["niveau"] : "ND";
		$intitule = addslashes(isset($_POST["intitule"]) ? $_POST["intitule"] : "ND");
		$objectifs = addslashes(isset($_POST["objectifs"]) ? $_POST["objectifs"] : "ND");
		$duree = isset($_POST["duree"]) ? $_POST["duree"] : "ND";
		$public = addslashes(isset($_POST["public"]) ? $_POST["public"] : "ND");
		$prerequis = addslashes(isset($_POST["prerequis"]) ? $_POST["prerequis"] : "ND");
		$tabModalites = isset($_POST["modalites"]) ? $_POST["modalites"] : array();
		$programme = addslashes(isset($_POST["programme"]) ? $_POST["programme"] : "ND");
		$idModule = isset($_POST["idModule"]) ? $_POST["idModule"] : false;
		
		// Enregistrement des données dans la base de données
		
		$cnxPDO = cnxBase();
		
		if (is_string($cnxPDO)) {
			// On arrête le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $cnxPDO);
		}
		
		if (!$idModule) { // création d'un nouveau module
				
			/* Préparation de la requète */
			$requete = "INSERT INTO " . TABLE_MODULE . "  
						(" . MODULE_IDNIVEAU . ", " .
						 MODULE_IDCATEGORIE . ", " .
						 MODULE_INTITULE . ", " .
						 MODULE_OBJECTIFS . ", " . 
						 MODULE_DUREE . ", " .
						 MODULE_PUBLIC . ", " .
						 MODULE_PREREQUIS . ", " .
						 MODULE_PROGRAMME . ") 
						VALUES 
						($niveau, '$categorie', '$intitule', 
						 '$objectifs', $duree, '$public', '$prerequis', '$programme')"; 
		} else { // modification d'un module
			
		/* Préparation de la requète */
			$requete = "UPDATE " . TABLE_MODULE . " 
						SET " . MODULE_IDNIVEAU . " = $niveau, " .
							MODULE_IDCATEGORIE . " = '$categorie', " .
							MODULE_INTITULE . " = '$intitule', " . 
							MODULE_OBJECTIFS . " = '$objectifs', " .
							MODULE_DUREE . " = $duree, " .
							MODULE_PUBLIC . " = '$public', " .
							MODULE_PREREQUIS . " = '$prerequis', " .
							MODULE_PROGRAMME . " = '$programme' 
						WHERE " . MODULE_ID . " = $idModule";		
		}	
		
		/* Exécution de la requète */
		$result = $cnxPDO->exec($requete);

		/* Si la première insertion ou la mise à jour  est réalisée 
		   et qu'au moins une modalité est associée, 
		   on crée une seconde requète pour insérer dans la table
		   Module_has_Modalite l'ensemble des modalités liées au module
		 */
		if ($result !== false) {
			if (!$idModule) { // Si on crée un module
				/* Je récupère la clé primaire de l'enregistrement inséré dans la table
				   Module */
				$idModule = $cnxPDO->lastInsertId();
			} else { // Si on met à jour un module
				/* Suppression de l'ensemble des relations entre les modalités et 
				   le module concerné */
				$requete = "DELETE FROM " . TABLE_MODULE_HAS_MODALITE . "
							WHERE " . MODMOD_IDMODULE . " = $idModule";
							
				/* Exécution de la requète */
				$result = $cnxPDO->exec($requete);		
				
				if (false === $result) {
					// Si la suppression des anciennes relations ne s'est pas bien passée
					bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete); 
				}
			}
			// Si au moins une modalité associée au module
			if (count($tabModalites) > 0) {
				attribueRelationsEntreModuleEtModalites($tabModalites, $idModule, $cnxPDO);
			} 
			
			// On affiche que cela s'est bien passé et on quitte le script
			include("../html/enregistrement_ok.html");			
		} // Fin du cas où s'est bien passée l'insertion ou la mise à jour
		else { // En cas d'erreur lors de l'insertion ou de la mise à jour
			
			if (false === $idModule) { // Cas de l'insertion
				bddErreur(BDD_ERREUR_INSERT, $cnxPDO->errorInfo(), $requete);	
			} else { // Cas de la mise à jour
				bddErreur(BDD_ERREUR_UPDATE, $cnxPDO->errorInfo(), $requete);
			}
		}
	} // Fin enregistrerModule
	
	/**
	 * Affiche la liste des modules présents dans la base de données
	 */
	function listeDesModules() {
		// Initialisation de la variable qui va contenir le code HTML de la liste
		// des modules
		$lesModules = "";
		
		// On récupère l'ensemble des enregistrements de la table Module sous
		// forme de tableau de tableaux associatifs
		$tabModules = getDonnees(TABLE_MODULE, array(MODULE_INTITULE, MODULE_ID));
		
		// On parcourt l'ensemble des enregistrements et on en extrait l'intitulé
		// qui est rajouté à la variable $lesModules encapsulé par des balises
		// HTML de paragraphes
		for($i = 0; $i < count($tabModules); $i++) {
			$lesModules .= "<tr>";
			$lesModules .= "<td style=\"border: 1px solid black;\" >";
			$lesModules .= "<a href=\"" . $_SERVER["PHP_SELF"] . "?idModule=" . $tabModules[$i][MODULE_ID] . "&action=creerModule\">" . $tabModules[$i][MODULE_INTITULE] . "</a>";
			$lesModules .= "</td>";
			$lesModules .= "<td style=\"text-align: center; vertical-align: middle;\" >";
			$lesModules .= "<img src=\"../medias/images/supprimer.gif\" onclick=\"suppression(" . $tabModules[$i][MODULE_ID] . ");\"/>";
			$lesModules .= "</td>";
			$lesModules .= "</tr>\n";
		}
		
		// On inclue finalement le fichier HTML global
		include("../html/liste_modules.html");
	} // Fin listeDesModules
	
	/**
	 * Supprimer le module passé en paramètre
	 * @param int $idModule Id du module à supprimer
	 */
	function supprimerModule($idModule) {
		
		// Connexion à la base de données
		$cnxPDO = cnxBase();
		
		// Gestion des erreurs éventuelles
		if (is_string($cnxPDO)) {
			// On arrête le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $cnxPDO);
		}
		// Suppression des relations entre le module et ses modalités
		$requete = "DELETE FROM " . TABLE_MODULE_HAS_MODALITE . " 
					WHERE " . MODMOD_IDMODULE . " = " . $idModule;
					
		/* Exécution de la requète */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs éventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}					
						
		// Suppression du module
		$requete = "DELETE FROM " . TABLE_MODULE . " 
					WHERE " . MODULE_ID . " = " . $idModule;		
					 
		/* Exécution de la requète */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs éventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}
		
		header("Location: " . $_SERVER["PHP_SELF"] . "?action=listerModule"); 
		
	} // Fin supprimerModule

?>