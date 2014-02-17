<?php

	include_once(__DIR__ . "/vehicule.class.php");

	class voiture extends vehicule {
	
		private $_immatriculation;
		
		private $_nbPortes;
		
		private $_boiteVitesse;
		
		private $_nbVitesses;
		
		const BV_AUTOMATIQUE = "automatique";
		const BV_MANUELLE = "manuelle";
		
		public function __construct($couleur, $marque, $modele, $immatriculation, $nbPortes, $puissance, $boiteVitesse = self::BV_MANUELLE, $nbVitesses = 5, $energie = self::ENERGIE_DIESEL) {
			parent::__construct($couleur, $marque, $modele, $puissance, $energie);
			echo "moi, " . __CLASS__ . ", je suis construit, avec la couleur : $couleur !<br />";
			$this->setImmatriculation($immatriculation);
			$this->setNbPortes($nbPortes);
			$this->setBoiteVitesse($boiteVitesse);
			$this->setNbVitesses($nbVitesses);
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
		
		public function getBoiteVitesse() {
			return $this->_boiteVitesse;
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
		
		public function __toString() {
			$desc = "je suis une " . __CLASS__ . " ";
			$desc .= $this->getMarque() . "\n";
			$desc .= " type " . $this->getModele() . "\n";
			$desc .= " de couleur " . $this->getCouleur() . "\n";
			$desc .= " immatriculée " . $this->getImmatriculation() . "\n";
			$desc .= " (" . $this->getNbPortes() . "p)\n";
			$desc .= " de " . $this->getPuissance() . "CV\n";
			$desc .= " - boîte de vitesse : " . $this->getBoiteVitesse() . "\n";
			$desc .= " avec " . $this->getNbVitesses() . " vitesses\n";
			$desc .= " roulant ";
			switch($this->getEnergie()) {
				case self::ENERGIE_ESSENCE:
				case self::ENERGIE_ELECTRICITE:
					$desc .= "à l'";
					break;
				case self::ENERGIE_DIESEL:
				case self::ENERGIE_GPL:
					$desc .= "au ";
					break;
				default:
					$desc .= "avec une énergie ";
			}
			$desc .= $this->getEnergie();
			return $desc;
		}
	
	}

?>