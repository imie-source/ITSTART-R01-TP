<?php

	include("fonctions.inc.php");
	
	// Récupération de l'id du module
	$idModule = isset($_POST["idModule"]) ? $_POST["idModule"] : false;
	
	if ($idModule) {
	
		// Connexion à la base de données
		$cnxPDO = cnxBase();
	
		// Gestion des erreurs éventuelles
		if (is_string($cnxPDO)) {
			// On arrête le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $cnxPDO);
		}
		// Suppression des relations entre le module et ses modalités
		$requete = "DELETE FROM Module_has_Modalite
		            WHERE Module_idModule = " . $idModule;
					
		/* Exécution de la requète */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs éventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}					
						
		// Suppression du module
		$requete = "DELETE FROM Module
                    WHERE idModule = " . $idModule;		
					 
		/* Exécution de la requète */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs éventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}
		
		header("Location: liste_modules.php"); 
		
	} else {
		// L'id du module n'est pas défini
		die("d'où venez-vous ?");
	}

?>