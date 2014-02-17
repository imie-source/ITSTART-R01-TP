<?php

	/**
	 * Librairie de fonctions "outils"
	 */
	 
	/**
	 * Retire l'ensemble des accents d'une cha�ne de caract�res
	 * 
	 * @param string $string Cha�ne dont on retire les accents
	 * @return string Cha�ne sans accent
	 */
	function retireAccents($string) {
		return strtr($string,
					 '���������������������������������������������������',
					 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

?>