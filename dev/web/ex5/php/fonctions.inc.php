<?php

	/*
		Fonction qui renvoie un tableau contenant les donn�es d'une table
		@param string $nomTable Nom de la table
		@return Array Tableau contenant les enregistrements de la table
	*/
	function getDonnees($nomTable) {
		/* D�finition des variables utiles � la connexion � la base de donn�es*/
		$utilisateur = "modules";
		$motdepasse = "modules2014!";
		$hote = "127.0.0.1";
		$port = 3306;
		$nomBase = "modules";
		
		/* Connexion � la base de donn�es */
		$link = @mysql_connect($hote.":".$port, $utilisateur, $motdepasse);
		
		/* Si la connexion ne s'effectue pas */
		if (!$link) {
			// On arr�te le script et on affiche l'erreur
			//die("Impossible de se connecter &agrave; la base : " . mysql_error());
			return mysql_error();
		}
		
		/* S�lection de la base de donn�es */
		mysql_select_db($nomBase, $link);
		
		//echo "Je me suis bien connect&eacute; &agrave; la base de donn&eacute;es : " . $link . "<br />";
		
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
	
?>	