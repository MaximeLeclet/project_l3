<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity(fields="nom_team", message="Nom de team déjà pris")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=191, nullable=true)
     */
    private $nom_team;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bcrypt;

    public function getId()
    {
        return $this->id;
    }

    public function getNomTeam()
    {
        return $this->nom_team;
    }

    public function setNomTeam($nom_team)
    {
        $this->nom_team = $nom_team;

        return $this;
    }

    public function getBcrypt()
    {
        return $this->bcrypt;
    }

    public function setBcrypt($bcrypt)
    {
        $this->bcrypt = $bcrypt;

        return $this;
    }
}
