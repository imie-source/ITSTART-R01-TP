<?php

	include("fonctions.inc.php");

	/**
	 * Affiche un formulaire de saisie d'un module (renseign� ou non)
	 * @param int $idModule Id du module � afficher
	 */
	function creerModule($idModule) {
		// Initialisation "g�n�rale" des diff�rentes variables pr�sentes dans
		// le formulaire
		
		$intitule = "";
		$objectifs = "";
		$public = "";
		$duree = "";
		$programme = "";
		$prerequis = "";
		$categorie = false;
		$niveau = false;
		// Comme il peut y avoir plusieurs modalit�s li�es � un module
		// On d�finit la variable $tabModalites commes un tableau
		$tabModalites = array();
			
		// Si un id de module est pass� en param�tre (m�thode GET)
		if ($idModule) {
			// R�cup�ration de l'ensemble des enregistrements des modules
			$tabModules = getDonnees(TABLE_MODULE);
			// Recherche du module sp�cifique
			for($i = 0; $i < count($tabModules); $i++) {
				// L'id du module correspond-il � celui demand� ?
				if ($tabModules[$i][MODULE_ID] == $idModule) {
					// Oui, on r�cup�re l'ensemble des informations
					$intitule = $tabModules[$i][MODULE_INTITULE];
					$objectifs = $tabModules[$i][MODULE_OBJECTIFS];
					$public = $tabModules[$i][MODULE_PUBLIC];
					$duree = $tabModules[$i][MODULE_DUREE];
					$programme = $tabModules[$i][MODULE_PROGRAMME];
					$prerequis = $tabModules[$i][MODULE_PREREQUIS];
					$categorie = $tabModules[$i][MODULE_IDCATEGORIE];
					$niveau = $tabModules[$i][MODULE_IDNIVEAU];
					// Pas la peine de continuer, on a trouv�, donc on arr�te la boucle
					break;
				}
			}
			$tabRelationModuleModalites = getDonnees(TABLE_MODULE_HAS_MODALITE);
			// Recherche des modalit�s li�es au module sp�cifique
			// On parcourt l'ensemble des relations entre les modules et les modalit�s
			for($i = 0; $i < count($tabRelationModuleModalites); $i++) {
				// Si une relation met en jeu le module demand�
				if ($tabRelationModuleModalites[$i][MODMOD_IDMODULE] == $idModule) {
					// On stocke l'id de la modalit� dans le tableau $tabModalites
					$tabModalites[] = $tabRelationModuleModalites[$i][MODMOD_IDMODALITE];
				}
			}
		}
		// G�n�ration des listes des "select" avec potentiellement la "s�lection" d'une pass�e en 4�me argument
		$lesCategories = createOptionsFromTable(TABLE_CATEGORIE, CATEGORIE_ID, CATEGORIE_LIBELLE, $categorie); 
		$lesNiveaux = createOptionsFromTable(TABLE_NIVEAU, NIVEAU_ID, NIVEAU_LIBELLE, $niveau); 
		$lesModalites = createOptionsFromTable(TABLE_MODALITE, MODALITE_ID, MODALITE_LIBELLE, $tabModalites); 

		include("../html/module.html");
	} // Fin creerModule
	
	/**
	 * Insert dans la table Module_has_Modalite l'ensemble des relations entre un module
	 * et une ou plusieurs modalit�s : un enregistrement par relation
	 * @param array $tabModalites Liste des modalit�s en relation avec le module
	 * @param int $idModule l'id (cl� primaire) du module
	 * @param resource $link "Ticket" de connexion � la base de donn�es
	 */
	function attribueRelationsEntreModuleEtModalites($tabModalites, $idModule, $cnxPDO) {
		/* J'ins�re chaque relation entre le module et les modalit�s sous forme
		   d'enregistrements dans la table Module_has_Modalite */
		$requete = "INSERT INTO " . TABLE_MODULE_HAS_MODALITE . "  
					(" . MODMOD_IDMODALITE. ", " . MODMOD_IDMODULE . ") VALUES ";
		for($i = 0; $i < count($tabModalites); $i++) {
			$requete .= "(" . $tabModalites[$i] . ", $idModule)" . ($i < count($tabModalites)-1 ? "," : "");
		}
		
		/* Ex�cution de la requ�te */
		$result = $cnxPDO->exec($requete);
		if (false === $result) {
			// On affiche une erreur et on quitte le script
			bddErreur(BDD_ERREUR_INSERT, $cnxPDO->errorInfo());
		}
	} // Fin attribueRelationsEntreModuleEtModalites
	
	/**
	 * Enregistre le module dont les informations sont pass�es dans la variable
	 * globale $_POST
	 */  
	function enregistrerModule() {
		global $_POST;
		// Partie d�finition des variables ult�rieurement utilis�es
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
		
		// Enregistrement des donn�es dans la base de donn�es
		
		$cnxPDO = cnxBase();
		
		if (is_string($cnxPDO)) {
			// On arr�te le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $cnxPDO);
		}
		
		if (!$idModule) { // cr�ation d'un nouveau module
				
			/* Pr�paration de la requ�te */
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
			
		/* Pr�paration de la requ�te */
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
		
		/* Ex�cution de la requ�te */
		$result = $cnxPDO->exec($requete);

		/* Si la premi�re insertion ou la mise � jour  est r�alis�e 
		   et qu'au moins une modalit� est associ�e, 
		   on cr�e une seconde requ�te pour ins�rer dans la table
		   Module_has_Modalite l'ensemble des modalit�s li�es au module
		 */
		if ($result !== false) {
			if (!$idModule) { // Si on cr�e un module
				/* Je r�cup�re la cl� primaire de l'enregistrement ins�r� dans la table
				   Module */
				$idModule = $cnxPDO->lastInsertId();
			} else { // Si on met � jour un module
				/* Suppression de l'ensemble des relations entre les modalit�s et 
				   le module concern� */
				$requete = "DELETE FROM " . TABLE_MODULE_HAS_MODALITE . "
							WHERE " . MODMOD_IDMODULE . " = $idModule";
							
				/* Ex�cution de la requ�te */
				$result = $cnxPDO->exec($requete);		
				
				if (false === $result) {
					// Si la suppression des anciennes relations ne s'est pas bien pass�e
					bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete); 
				}
			}
			// Si au moins une modalit� associ�e au module
			if (count($tabModalites) > 0) {
				attribueRelationsEntreModuleEtModalites($tabModalites, $idModule, $cnxPDO);
			} 
			
			// On affiche que cela s'est bien pass� et on quitte le script
			include("../html/enregistrement_ok.html");			
		} // Fin du cas o� s'est bien pass�e l'insertion ou la mise � jour
		else { // En cas d'erreur lors de l'insertion ou de la mise � jour
			
			if (false === $idModule) { // Cas de l'insertion
				bddErreur(BDD_ERREUR_INSERT, $cnxPDO->errorInfo(), $requete);	
			} else { // Cas de la mise � jour
				bddErreur(BDD_ERREUR_UPDATE, $cnxPDO->errorInfo(), $requete);
			}
		}
	} // Fin enregistrerModule
	
	/**
	 * Affiche la liste des modules pr�sents dans la base de donn�es
	 */
	function listeDesModules() {
		// Initialisation de la variable qui va contenir le code HTML de la liste
		// des modules
		$lesModules = "";
		
		// On r�cup�re l'ensemble des enregistrements de la table Module sous
		// forme de tableau de tableaux associatifs
		$tabModules = getDonnees(TABLE_MODULE, array(MODULE_INTITULE, MODULE_ID));
		
		// On parcourt l'ensemble des enregistrements et on en extrait l'intitul�
		// qui est rajout� � la variable $lesModules encapsul� par des balises
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
	 * Supprimer le module pass� en param�tre
	 * @param int $idModule Id du module � supprimer
	 */
	function supprimerModule($idModule) {
		
		// Connexion � la base de donn�es
		$cnxPDO = cnxBase();
		
		// Gestion des erreurs �ventuelles
		if (is_string($cnxPDO)) {
			// On arr�te le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $cnxPDO);
		}
		// Suppression des relations entre le module et ses modalit�s
		$requete = "DELETE FROM " . TABLE_MODULE_HAS_MODALITE . " 
					WHERE " . MODMOD_IDMODULE . " = " . $idModule;
					
		/* Ex�cution de la requ�te */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs �ventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}					
						
		// Suppression du module
		$requete = "DELETE FROM " . TABLE_MODULE . " 
					WHERE " . MODULE_ID . " = " . $idModule;		
					 
		/* Ex�cution de la requ�te */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs �ventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}
		
		header("Location: " . $_SERVER["PHP_SELF"] . "?action=listerModule"); 
		
	} // Fin supprimerModule

?>