<?php

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
		die("Impossible de se connecter &agrave; la base : " . mysql_error());
	}
	
	/* Sélection de la base de données */
	mysql_select_db($nomBase, $link);
	
	echo "Je me suis bien connect&eacute; &agrave; la base de donn&eacute;es : " . $link . "<br />";
	
	/* Préparation de la requète */
	$requete = "SELECT * FROM Categorie;";
	
	/* Exécution de la requète */
	$result = mysql_query($requete, $link);

	/* Parcours des enregistrements */
	while($tabRow = mysql_fetch_assoc($result)) {
		echo $tabRow["idCategorie"] . " : " . $tabRow["categorie_libelle"] . "<br />";
	}
	
	/* Libération du "ticket" */
	mysql_free_result($result);
	
	/* Déconnexion de la base */
	mysql_close($link);
?>