<?php

namespace App\Modele;

use App\Entity\Campus;
use DateTime;


class Filtre
{

    // Attributs :
    public ?Campus $campus=null;
    public ?string $nom=null;
    public ?DateTime $dateDebut=null;

    /*
    public DateTime $dateFin;
    public $organisateur;
    public $inscrit;
    public $pasInscrit;
    public $passe;
*/
}