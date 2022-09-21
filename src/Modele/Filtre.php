<?php

namespace App\Modele;

use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class Filtre
{


    // Attributs :
    public Campus $campus;
    public $nom;
    public DateType $dateDebut;
    public DateType $dateFin;
    public $organisateur;
    public $inscrit;
    public $pasInscrit;
    public $passe;


    // Constructeurs :

    public function __construct()
    {}



    /**
     * @return Campus
     */
    public function getCampus(): Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus $campus
     */
    public function setCampus(Campus $campus): void
    {
        $this->campus = $campus;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return DateType
     */
    public function getDateDebut(): DateType
    {
        return $this->dateDebut;
    }

    /**
     * @param DateType $dateDebut
     */
    public function setDateDebut(DateType $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return DateType
     */
    public function getDateFin(): DateType
    {
        return $this->dateFin;
    }

    /**
     * @param DateType $dateFin
     */
    public function setDateFin(DateType $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return mixed
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param mixed $organisateur
     */
    public function setOrganisateur($organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return mixed
     */
    public function getInscrit()
    {
        return $this->inscrit;
    }

    /**
     * @param mixed $inscrit
     */
    public function setInscrit($inscrit): void
    {
        $this->inscrit = $inscrit;
    }

    /**
     * @return mixed
     */
    public function getPasInscrit()
    {
        return $this->pasInscrit;
    }

    /**
     * @param mixed $pasInscrit
     */
    public function setPasInscrit($pasInscrit): void
    {
        $this->pasInscrit = $pasInscrit;
    }

    /**
     * @return mixed
     */
    public function getPasse()
    {
        return $this->passe;
    }

    /**
     * @param mixed $passe
     */
    public function setPasse($passe): void
    {
        $this->passe = $passe;
    }




}