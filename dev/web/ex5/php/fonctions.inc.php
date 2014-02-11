<?php

	/* Inclusion des variables de configuration */
	include("../config/config.inc.php");
	
	/* Inclusion de la définition des constantes */
	include("constantes.inc.php");
	
	function cnxBase() {
		/* Rendre visible dans la fonction les variables "globales" du script */
		global $hote, $port, $utilisateur, $motdepasse, $nomBase;
		
		/* Connexion à la base de données */
		$link = @mysql_connect($hote.":".$port, $utilisateur, $motdepasse);
		
		/* Si la connexion ne s'effectue pas */
		if (!$link) {
			// En cas d'erreur : on renvoie l'erreur
			return mysql_error();
		}
			
		/* Sélection de la base de données */
		mysql_select_db($nomBase, $link);
		
		return $link;
	}
	
	function bddErreur($codeErreur, $info, $requete = "") {
		switch($codeErreur) {
			case BDD_ERREUR_CNX: 
				$msg = "Impossible de se connecter &agrave; la base de donn&eacute;es : ";
				break;
			case BDD_ERREUR_INSERT:
				$msg = "Erreur au moment de l'insertion : ";
				break;
			case BDD_ERREUR_DELETE:
				$msg = "Erreur au moment de la suppression : ";
				break;
			case BDD_ERREUR_UPDATE:
				$msg = "Erreur au moment de la modification : ";
				break;
		}
		include("../html/bdderreur.html");
		die();
	}
	
	/*
		Fonction qui renvoie un tableau contenant les données d'une table
		@param string $nomTable Nom de la table
		@return Array Tableau contenant les enregistrements de la table
	*/
	function getDonnees($nomTable, $champs = "*") {
		
		$link = cnxBase();
		// Soit $link contient une chaîne de caractères (l'erreur)
		// Soit $link contient une "ressource"
		
		// S'il y a un problème de connexion on renvoie l'erreur
		if (is_string($link)) {
			return $link;
		}
		
		// Dans le cas où $champs contient un tableau
		if (is_array($champs)) {
			// on transforme le tableau de champs en une chaîne de caractères
			// pour l'inclure dans la requête SQL
			$champs = implode(",", $champs);
		}
		
		/* Préparation de la requète */
		$requete = "SELECT " . $champs . " FROM " . $nomTable . ";";

		/* Exécution de la requète */
		$result = mysql_query($requete, $link);

		/* Parcours des enregistrements */
		while($tabRow = mysql_fetch_assoc($result)) {
			//echo $tabRow["idCategorie"] . " : " . $tabRow["categorie_libelle"] . "<br />";
			$tabRes[] = $tabRow;
		}
		
		/* Libération du "ticket" */
		mysql_free_result($result);
		
		/* Déconnexion de la base */
		mysql_close($link);
		
		return $tabRes;
	} /* Fin de la fonction getDonnees */
	
	/**
	 * Fonction renvoyant le code HTML sous forme d'options des 
	 * enregistrements contenu dans une table
	 * @param string $tableName Nom de la table
	 * @param string $primaryKey Nom du champ "clé primaire"
	 * @param string $label Libellé de l'information
	 * @return string Code HTML des options
	 */
	function createOptionsFromTable($tableName, $primaryKey, $label, $idSelected = false) {
		$tab = getDonnees($tableName);
		if (!is_array($tab)) {
			$res = "<option value=\"\">BD not connected : " . utf8_encode($tab) . "</option>";
		} else {
			$res = "";
			$nbElements = count($tab); // GreenIT ;-)
			for($i = 0; $i < $nbElements; $i++) {
				if (is_array($idSelected)) {
					$res .= "<option value=\"" . 
						    $tab[$i][$primaryKey] . "\"" . 
							(in_array($tab[$i][$primaryKey], $idSelected) ? " selected " : "") .
							">" . utf8_encode($tab[$i][$label]) . "</option>\n";
				} else {
					$res .= "<option value=\"" . 
						$tab[$i][$primaryKey] . "\"" . 
						($tab[$i][$primaryKey] == $idSelected ? " selected " : "") .
						">" . utf8_encode($tab[$i][$label]) . "</option>\n";
				}	
			}
		}
		return $res;
	}
?>