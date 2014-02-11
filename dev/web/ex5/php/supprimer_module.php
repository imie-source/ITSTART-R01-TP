<?php

	include("fonctions.inc.php");
	
	// Récupération de l'id du module
	$idModule = isset($_POST["idModule"]) ? $_POST["idModule"] : false;
	
	if ($idModule) {
	
		// Connexion à la base de données
		$link = cnxBase();
	
		// Gestion des erreurs éventuelles
		if (is_string($link)) {
			// On arrête le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $link);
		}
		// Suppression des relations entre le module et ses modalités
		$requete = "DELETE FROM Module_has_Modalite
		            WHERE Module_idModule = " . $idModule;
					
		/* Exécution de la requète */
		$result = mysql_query($requete, $link, $requete);
		
		// Gestion des erreurs éventuelles
		if (!$result) {
			bddErreur(BDD_ERREUR_DELETE, $link, $requete);
		}					
						
		// Suppression du module
		$requete = "DELETE FROM Module
                    WHERE idModule = " . $idModule;		
					 
		/* Exécution de la requète */
		$result = mysql_query($requete, $link, $requete);
		
		// Gestion des erreurs éventuelles
		if (!$result) {
			bddErreur(BDD_ERREUR_DELETE, $link, $requete);
		}
		
		/* Déconnexion de la base */
		mysql_close($link);
		
		header("Location: liste_modules.php"); 
		
	} else {
		// L'id du module n'est pas défini
		die("d'où venez-vous ?");
	}

?>