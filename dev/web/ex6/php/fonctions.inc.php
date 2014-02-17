<?php

	/**
	 * Librairie de fonctions "outils"
	 */
	 
	/**
	 * Retire l'ensemble des accents d'une chaξne de caractθres
	 * 
	 * @param string $string Chaξne dont on retire les accents
	 * @return string Chaξne sans accent
	 */
	function retireAccents($string) {
		return strtr($string,
					 'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ',
					 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

?>