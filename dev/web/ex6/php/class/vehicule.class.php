<?php

include_once(__DIR__ . "/../fonctions.inc.php");

class vehicule {

	protected $_energie;
	
	protected $_couleur;
	
	protected $_marque;
		
	protected $_modele;
	
	protected $_puissance;
	
	const ENERGIE_ESSENCE = "essence";
	const ENERGIE_DIESEL = "diesel";
	const ENERGIE_GPL = "gpl";
	const ENERGIE_ELECTRICITE = "électricité";
	const ENERGIE_FUEL = "fuel";
	const ENERGIE_NONCONNUE = "non connue";
	
	public function __construct($couleur, $marque, $modele, $puissance, $energie = self::ENERGIE_DIESEL) {
		echo "moi, " . __CLASS__ . ", je suis construit, avec la couleur : $couleur !<br />";
		$this->setCouleur($couleur);
		$this->setMarque($marque);
		$this->setModele($modele);
		$this->setPuissance($puissance);
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
	
	public function getPuissance() {
		return $this->_puissance;
	}
		
	public function setPuissance($puissance) {
		$this->_puissance = $puissance;
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
			case "fuel" :
				$this->_energie = self::ENERGIE_FUEL;
				break;
			default:
				$this->_energie = self::ENERGIE_NONCONNUE;
		}
	}

	public function __toString() {
		$desc = "je suis un " . __CLASS__ . " ";
		$desc .= $this->getMarque() . "\n";
		$desc .= " type " . $this->getModele() . "\n";
		$desc .= " de couleur " . $this->getCouleur() . "\n";
		$desc .= " de " . $this->getPuissance() . "CV\n";
		$desc .= " roulant ";
		switch($this->getEnergie()) {
			case self::ENERGIE_ESSENCE:
			case self::ENERGIE_ELECTRICITE:
				$desc .= "à l'";
				break;
			case self::ENERGIE_DIESEL:
			case self::ENERGIE_GPL:
			case self::ENERGIE_FUEL:
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