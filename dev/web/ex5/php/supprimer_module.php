<?php

	include("fonctions.inc.php");
	
	// R�cup�ration de l'id du module
	$idModule = isset($_POST["idModule"]) ? $_POST["idModule"] : false;
	
	if ($idModule) {
	
		// Connexion � la base de donn�es
		$link = cnxBase();
	
		// Gestion des erreurs �ventuelles
		if (is_string($link)) {
			// On arr�te le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $link);
		}
		// Suppression des relations entre le module et ses modalit�s
		$requete = "DELETE FROM Module_has_Modalite
		            WHERE Module_idModule = " . $idModule;
					
		/* Ex�cution de la requ�te */
		$result = mysql_query($requete, $link, $requete);
		
		// Gestion des erreurs �ventuelles
		if (!$result) {
			bddErreur(BDD_ERREUR_DELETE, $link, $requete);
		}					
						
		// Suppression du module
		$requete = "DELETE FROM Module
                    WHERE idModule = " . $idModule;		
					 
		/* Ex�cution de la requ�te */
		$result = mysql_query($requete, $link, $requete);
		
		// Gestion des erreurs �ventuelles
		if (!$result) {
			bddErreur(BDD_ERREUR_DELETE, $link, $requete);
		}
		
		/* D�connexion de la base */
		mysql_close($link);
		
		header("Location: liste_modules.php"); 
		
	} else {
		// L'id du module n'est pas d�fini
		die("d'o� venez-vous ?");
	}

?>