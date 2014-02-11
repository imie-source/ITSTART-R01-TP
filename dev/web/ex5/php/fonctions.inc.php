<?php

	/* Inclusion des variables de configuration */
	include("../config/config.inc.php");
	
	/* Inclusion de la définition des constantes */
	include("constantes.inc.php");
	
	/**
	 * Connexion à la base de données avec le module PDO
	 * @return mixed Objet PDO ou Chaîne de caractères décrivant l'erreur
	 */
	function cnxBase() {
		/* Rendre visible dans la fonction les variables "globales" du script */
		global $hote, $port, $utilisateur, $motdepasse, $nomBase;
		
		/* Connexion à la base de données */
		// Définition du DSN : Data Source Name
		$dsn = "mysql:host=$hote;port=$port;dbname=$nomBase";
		// Tentative de connexion à la base en instanciant une classe PDO
		try {
			// Création de l'instance de la classe PDO avec les paramètres de cnx
			$cnxPDO = new PDO($dsn, $utilisateur, $motdepasse);
		} catch(PDOException $exception) {
			/* En cas d'erreur, le constructeur de la classe PDO lève une exception
			   de type PDOException que l'on capture et qui est placée dans
			   la variable $exception */
			// Renvoie le message décrivant l'erreur
			return $exception->getMessage();
		}
		// Renvoie l'objet créé
		return $cnxPDO;
	}
	
	/**
	 * Gestion des erreurs de BDD avec affichage d'une page HTML d'erreur personnalisée
	 * @param int $codeErreur Code erreur BDD
	 * @param mixed $info Chaîne de caractères ou tableau décrivant les erreurs
	 * @param string $requete Requête ayant généré l'erreur
	 */
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
		// Si $info est un tableau,
		if (is_array($info)) {
			// on le transforme en une chaîne "continue" de caractères,
			// chaque élément étant séparé par un saut de ligne HTML
			$info = implode("<br />", $info);
		}
		// Inclusion du "modèle" HTML 
		include("../html/bdderreur.html");
		die();
	}
	
	/*
		Fonction qui renvoie un tableau contenant les données d'une table
		@param string $nomTable Nom de la table
		@return Array Tableau contenant les enregistrements de la table
	*/
	function getDonnees($nomTable, $champs = "*") {
		
		$cnxPDO = cnxBase();
		// Soit $cnxPDO contient une chaîne de caractères (l'erreur)
		// Soit $cnxPDO contient un objet de classe PDO
		
		// S'il y a un problème de connexion on renvoie l'erreur
		if (is_string($cnxPDO)) {
			return $cnxPDO;
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
		$result = $cnxPDO->query($requete);
		
		// Initialisation de la variable "resultat" 
		$tabRes = $result->fetchAll(PDO::FETCH_ASSOC);
		
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