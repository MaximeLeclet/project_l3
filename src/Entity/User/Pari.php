<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pari
 *
 * @ORM\Table(name="pari", indexes={@ORM\Index(name="IDX_2A091C1FA76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class Pari
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="equipe1", type="string", length=255, nullable=true)
     */
    private $equipe1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="equipe2", type="string", length=255, nullable=true)
     */
    private $equipe2;

    /**
     * @var int|null
     *
     * @ORM\Column(name="score_equipe1", type="integer", nullable=true)
     */
    private $scoreEquipe1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="score_equipe2", type="integer", nullable=true)
     */
    private $scoreEquipe2;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}
