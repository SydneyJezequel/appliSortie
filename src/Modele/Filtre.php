<?php

namespace App\Modele;

use App\Entity\Campus;
use DateTime;


class Filtre
{

    // Attributs :
    public ?Campus $campus=null;
    public String $nom;
    public DateTime $dateDebut;

    /*
    public DateTime $dateFin;
    public $organisateur;
    public $inscrit;
    public $pasInscrit;
    public $passe;
*/
}