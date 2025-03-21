test2-----------------------------------------------------------------
<!-- 
    Créez une classe abstraite Vehicule avec les propriétés nom et vitesse.

    Ajoutez une méthode abstraite deplacer().
    Créez deux classes Voiture et Moto qui héritent de Vehicule.
    Chaque classe définit sa propre logique dans deplacer().
    Créez une classe Course pour organiser une course entre plusieurs véhicules, en affichant le gagnant en fonction de leur vitesse. -->


<?php


abstract class Vehicule{
    private $nom;
    private $vitesse;


    abstract function deplacer();
}

class Voiture extends Vehicule{

    public function construct($nom,$vitesse){
        $this->nom=$nom;
        $this->vitesse=$vitesse;
    }

    public function getVitesse(){
        return $this->vitesse=$vitesse;
    }

    public function getNom(){
        return $this->nom=$nom;
    }

    public function deplacer(){
        echo 'Voiture';
    }
}

class Moto extends Vehicule{

    public function construct($nom,$vitesse){
        $this->nom=$nom;
        $this->vitesse=$vitesse;
    }

    public function getNom(){
        return $this->nom=$nom;
    }

    public function getVitesse(){
        return $this->vitesse=$vitesse;
    }


    public function deplacer(){
        echo 'Moto';
    }
}

class Course{
    private $vehicules = [];
    private $gagnant = "";

    public function affichantgagnant(){
        foreach($vehicules as $vehicule){
            if($this->$vehicule->getVitesse() > $this->$gagnant->getVitesse()){
                $this->$gagnant = $this->$vehicule;
            }
        }
    }

    public function 
}