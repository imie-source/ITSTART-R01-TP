<?php

	include(__DIR__ . "/../fonctions.inc.php");

	class voiture {
	
		private $_couleur;
		
		private $_marque;
		
		private $_modele;
		
		private $_immatriculation;
		
		private $_nbPortes;
		
		private $_puissance;
		
		private $_boiteVitesse;
		
		private $_nbVitesses;
		
		private $_energie;
		
		const ENERGIE_ESSENCE = "essence";
		const ENERGIE_DIESEL = "diesel";
		const ENERGIE_GPL = "gpl";
		const ENERGIE_ELECTRICITE = "électricité";
		const ENERGIE_NONCONNUE = "non connue";

				
		
		public function __construct($couleur, $marque, $modele, $immatriculation, $nbPortes, $puissance, $boiteVitesse, $nbVitesses, $energie) {
			echo "je suis construit, avec la couleur : $couleur !<br />";
			$this->setCouleur($couleur);
			$this->setMarque($marque);
			$this->setModele($modele);
			$this->setImmatriculation($immatriculation);
			$this->setNbPortes($nbPortes);
			$this->setPuissance($puissance);
			$this->setBoiteVitesse($boiteVitesse);
			$this->setNbVitesses($nbVitesses);
			$this->setEnergie($energie);
		}
		
		public function getCouleur() {
			return $this->_couleur;
		}
		
		public function setCouleur($couleur) {
			switch($couleur) {
				case "noir":
				case "rouge": 
					$this->_couleur = $couleur;
					break;
				default:
					$this->_couleur = "NA";
			}		
		}
		
		public function getMarque() {
			return $this->_marque;
		}
		
		public function setMarque($marque) {
			$this->_marque = $marque;
		}
		
		public function getModele() {
			return $this->_modele;
		}
		
		public function setModele($modele) {
			$this->_modele = $modele;
		}
		
		public function getImmatriculation() {
			return $this->_immatriculation;
		}
		
		public function setImmatriculation($immatriculation) {
			$this->_immatriculation = $immatriculation;
		}
		
		public function getNbPortes() {
			return $this->_nbPortes;
		}
		
		public function setNbPortes($nbPortes) {
			$this->_nbPortes = $nbPortes;
		}
		
		public function getPuissance() {
			return $this->_puissance;
		}
		
		public function setPuissance($puissance) {
			$this->_puissance = $puissance;
		}
		
		public function getBoiteVitesse() {
			return $this->_boiteVitese;
		}
		
		public function setBoiteVitesse($boiteVitesse) {
			$this->_boiteVitesse = $boiteVitesse;
		}
		
		public function getNbVitesses() {
			return $this->_nbVitesses;
		} 
		
		public function setNbVitesses($nbVitesses) {
			$this->_nbVitesses = $nbVitesses;
		}
		
		public function getEnergie() {
			return $this->_energie;
		}
		
		public function setEnergie($energie) {
			$energie = strtolower($energie);
			$energie = retireAccents($energie);
			switch($energie) {
				case "essence" :
					$this->_energie = self::ENERGIE_ESSENCE;
					break;
				case "diesel" :
					$this->_energie = self::ENERGIE_DIESEL;
					break;
				case "electricite" :
					$this->_energie = self::ENERGIE_ELECTRICITE;
					break;
				case "gpl" :
					$this->_energie = self::ENERGIE_GPL;
					break;
				default:
					$this->_energie = self::ENERGIE_NONCONNUE;
			}
		}	
		
		public function __toString() {
			return "je suis une voiture de couleur " . $this->_couleur . "<br />";
		}
	
	}

?>