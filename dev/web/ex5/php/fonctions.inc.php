<?php

	/*
		Fonction qui renvoie un tableau contenant les données d'une table
		@param string $nomTable Nom de la table
		@return Array Tableau contenant les enregistrements de la table
	*/
	function getDonnees($nomTable) {
		/* Définition des variables utiles à la connexion à la base de données*/
		$utilisateur = "modules";
		$motdepasse = "modules2014!";
		$hote = "127.0.0.1";
		$port = 3306;
		$nomBase = "modules";
		
		/* Connexion à la base de données */
		$link = @mysql_connect($hote.":".$port, $utilisateur, $motdepasse);
		
		/* Si la connexion ne s'effectue pas */
		if (!$link) {
			// On arrête le script et on affiche l'erreur
			//die("Impossible de se connecter &agrave; la base : " . mysql_error());
			return mysql_error();
		}
		
		/* Sélection de la base de données */
		mysql_select_db($nomBase, $link);
		
		//echo "Je me suis bien connect&eacute; &agrave; la base de donn&eacute;es : " . $link . "<br />";
		
		/* Préparation de la requète */
		$requete = "SELECT * FROM " . $nomTable . ";";
		
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
	function createOptionsFromTable($tableName, $primaryKey, $label) {
		$tab = getDonnees($tableName);
		if (!is_array($tab)) {
			$res = "<option value=\"\">BD not connected : " . utf8_encode($tab) . "</option>";
		} else {
			$res = "";
			$nbElements = count($tab); // GreenIT ;-)
			for($i = 0; $i < $nbElements; $i++) {
				$res .= "<option value=\"" . 
					$tab[$i][$primaryKey] . "\">" . 
					utf8_encode($tab[$i][$label]) . "</option>\n";
			}
		}
		return $res;
	}
?>	