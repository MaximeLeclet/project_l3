<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_team;

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
}
