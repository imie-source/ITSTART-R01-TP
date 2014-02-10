<?php

	/* Inclusion des variables de configuration */
	include("fonctions.inc.php");

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
	
	$link = cnxBase();
	
	if (is_string($link)) {
			// On arrête le script et on affiche l'erreur
			bddErreur(BDD_ERREUR_CNX, $link);
		}
	
	if (!$idModule) {
			
		/* Préparation de la requète */
		$requete = "INSERT INTO Module 
					(Niveau_idNiveau, Categorie_idCategorie, intitule_module, 
					 Objectifs, duree, public, prerequis, programme) 
					VALUES 
					($niveau, '$categorie', '$intitule', 
					 '$objectifs', $duree, '$public', '$prerequis', '$programme')"; 
		
		/* Exécution de la requète */
		$result = mysql_query($requete, $link);

		/* Si la première insertion est réalisée et qu'au moins une modalité est 
		   associée, on crée une seconde requète pour insérer dans la table
		   Module_has_Modalite l'ensemble des modalités liées au module
		 */
		if ($result) {
			if (count($tabModalites) > 0) {
				/* Je récupère la clé primaire de l'enregistrement inséré dans la table
				   Module */
				$idModule = mysql_insert_id($link);
				/* J'insère chaque relation entre le module et les modalités sous forme
				   d'enregistrements dans la table Module_has_Modalite */
				$requete = "INSERT INTO Module_has_Modalite 
							(Modalite_idModalite, Module_idModule) VALUES ";
				for($i = 0; $i < count($tabModalites); $i++) {
					$requete .= "(" . $tabModalites[$i] . ", $idModule)" . ($i < count($tabModalites)-1 ? "," : "");
				}
				/* Exécution de la requète */
				$result = mysql_query($requete, $link);
				// Si cela se passe mal...
				if (!$result) {
					// On affiche une erreur et on quitte le script
					bddErreur(BDD_ERREUR_INSERT, mysql_error());
				}
			} // if (count($tabModalites) > 0)
			// On affiche que cela s'est bien passé et on quitte le script
			die("<html><body>
				 <h1 style=\"text-align: center\">Enregistrement du module 
				 bien effectu&eacute;</h1>
				 <p style=\"text-align: center;\">
				 <a href=\"../html/accueil.html\">Retour</a>
				 </p> 
				 </body></html>");			
		} // if ($result) { 
		else {
			bddErreur(BDD_ERREUR_INSERT, mysql_error()); 
		}
			
	} // Fin du cas de la création d'un module
	else {
		/* cas de mise à jour d'un module */
		
		/* Préparation de la requète */
		$requete = "UPDATE Module
					SET Niveau_idNiveau = $niveau,
					    Categorie_idCategorie = '$categorie',
						intitule_module = '$intitule',
						Objectifs = '$objectifs',
						duree = $duree,
						public = '$public',
						prerequis = '$prerequis',
						programme = '$programme'
					WHERE idModule = $idModule";	
		
		/* Exécution de la requète */
		$result = mysql_query($requete, $link);

		/* Si la première insertion est réalisée et qu'au moins une modalité est 
		   associée, on crée une seconde requète pour insérer dans la table
		   Module_has_Modalite l'ensemble des modalités liées au module
		 */
		if ($result) {
			/* Suppression de l'ensemble des relations entre les modalités et 
			   le module concerné */
			$requete = "DELETE FROM Module_has_Modalite
			            WHERE Module_idModule = $idModule";
						
			/* Exécution de la requète */
			$result = mysql_query($requete, $link);			
			
			if ($result) {
				if (count($tabModalites) > 0) {
					/* J'insère chaque relation entre le module et les modalités sous forme
					   d'enregistrements dans la table Module_has_Modalite */
					$requete = "INSERT INTO Module_has_Modalite 
								(Modalite_idModalite, Module_idModule) VALUES ";
					for($i = 0; $i < count($tabModalites); $i++) {
						$requete .= "(" . $tabModalites[$i] . ", $idModule)" . ($i < count($tabModalites)-1 ? "," : "");
					}
					/* Exécution de la requète */
					$result = mysql_query($requete, $link);
					// Si cela se passe mal...
					if (!$result) {
						// On affiche une erreur et on quitte le script
						bddErreur(BDD_ERREUR_INSERT, mysql_error());
					}
				} // if (count($tabModalites) > 0)
				// On affiche que cela s'est bien passé et on quitte le script
				die("<html><body>
					 <h1 style=\"text-align: center\">Enregistrement du module 
					 bien effectu&eacute;</h1>
					 <p style=\"text-align: center;\">
					 <a href=\"../html/accueil.html\">Retour</a>
					 </p> 
					 </body></html>");	
			} 
			else { // Si la suppression des anciennes relations ne s'est pas bien passée
				bddErreur(BDD_ERREUR_DELETE, mysql_error()); 
			}
		} // if ($result) { 
		else { // Si la modification ne s'est pas bien effectuée
			bddErreur(BDD_ERREUR_UPDATE, mysql_error()); 
		}
	} // Fin du cas de la mise à jour d'un module

	/* Déconnexion de la base */
	mysql_close($link);

	
?>