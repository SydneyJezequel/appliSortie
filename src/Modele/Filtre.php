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
    public ?DateTime $dateFin=null;
    public ?bool $organisateur=null;
    public ?int $id=null;
    public ?bool $inscrit=null;
    public ?bool $pasInscrit=null;
    public ?bool $passee=null;



}