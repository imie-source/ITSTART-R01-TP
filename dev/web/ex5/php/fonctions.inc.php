<?php

	/* Inclusion des variables de configuration */
	include("../config/config.inc.php");
	
	/* Inclusion de la d�finition des constantes */
	include("constantes.inc.php");
	
	function cnxBase() {
		/* Rendre visible dans la fonction les variables "globales" du script */
		global $hote, $port, $utilisateur, $motdepasse, $nomBase;
		
		/* Connexion � la base de donn�es */
		$link = @mysql_connect($hote.":".$port, $utilisateur, $motdepasse);
		
		/* Si la connexion ne s'effectue pas */
		if (!$link) {
			// En cas d'erreur : on renvoie l'erreur
			return mysql_error();
		}
			
		/* S�lection de la base de donn�es */
		mysql_select_db($nomBase, $link);
		
		return $link;
	}
	
	function bddErreur($codeErreur, $info) {
		switch($codeErreur) {
			case 0: 
				die("Impossible de se connecter &agrave; la base de donn&eacute;es : " . $info);
				break;
			case 1:
				die("Erreur au moment de l'insertion : " . $info);
				break;
		}
	}
	
	/*
		Fonction qui renvoie un tableau contenant les donn�es d'une table
		@param string $nomTable Nom de la table
		@return Array Tableau contenant les enregistrements de la table
	*/
	function getDonnees($nomTable) {
		
		$link = cnxBase();
		// Soit $link contient une cha�ne de caract�res (l'erreur)
		// Soit $link contient une "ressource"
		
		// S'il y a un probl�me de connexion on renvoie l'erreur
		if (is_string($link)) {
			return $link;
		}
		
		/* Pr�paration de la requ�te */
		$requete = "SELECT * FROM " . $nomTable . ";";
		
		/* Ex�cution de la requ�te */
		$result = mysql_query($requete, $link);

		/* Parcours des enregistrements */
		while($tabRow = mysql_fetch_assoc($result)) {
			//echo $tabRow["idCategorie"] . " : " . $tabRow["categorie_libelle"] . "<br />";
			$tabRes[] = $tabRow;
		}
		
		/* Lib�ration du "ticket" */
		mysql_free_result($result);
		
		/* D�connexion de la base */
		mysql_close($link);
		
		return $tabRes;
	} /* Fin de la fonction getDonnees */
	
	/**
	 * Fonction renvoyant le code HTML sous forme d'options des 
	 * enregistrements contenu dans une table
	 * @param string $tableName Nom de la table
	 * @param string $primaryKey Nom du champ "cl� primaire"
	 * @param string $label Libell� de l'information
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