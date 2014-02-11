<?php

	include("fonctions.inc.php");
	
	// R�cup�ration de l'id du module
	$idModule = isset($_POST["idModule"]) ? $_POST["idModule"] : false;
	
	if ($idModule) {
	
		// Connexion � la base de donn�es
		$cnxPDO = cnxBase();
	
		// Gestion des erreurs �ventuelles
		if (is_string($cnxPDO)) {
			// On arr�te le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $cnxPDO);
		}
		// Suppression des relations entre le module et ses modalit�s
		$requete = "DELETE FROM Module_has_Modalite
		            WHERE Module_idModule = " . $idModule;
					
		/* Ex�cution de la requ�te */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs �ventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}					
						
		// Suppression du module
		$requete = "DELETE FROM Module
                    WHERE idModule = " . $idModule;		
					 
		/* Ex�cution de la requ�te */
		$result = $cnxPDO->exec($requete);
		
		// Gestion des erreurs �ventuelles
		if (false === $result) {
			bddErreur(BDD_ERREUR_DELETE, $cnxPDO->errorInfo(), $requete);
		}
		
		header("Location: liste_modules.php"); 
		
	} else {
		// L'id du module n'est pas d�fini
		die("d'o� venez-vous ?");
	}

?>