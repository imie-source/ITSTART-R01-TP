<?php

	class voiture {
	
		private $couleur;
	
		public function __construct($couleur) {
			echo "je suis construit, avec la couleur : $couleur !<br />";
			$this->setCouleur($couleur);
		}
		
		public function getCouleur() {
			return $this->couleur;
		}
		
		public function setCouleur($couleur) {
			switch($couleur) {
				case "noir":
				case "rouge": 
					$this->couleur = $couleur;
					break;
				default:
					$this->couleur = "NA";
			}		
		}
	
		public function __toString() {
			return "je suis une voiture de couleur " . $this->couleur . "<br />";
		}
	
	}

?>