<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\LaLigaEntity;

/**
 * JUgador
 *
 * @ORM\Table(name="jugador")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\JugadorRepository")
 */
class Jugador extends LaLigaEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable = true)
     */
    private $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Club", inversedBy="jugadores")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    public function __construct() {
        parent::__construct();
    }

    public function __toString() {

        return $this->nombre;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Jugador
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Jugador
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set club
     *
     * @param \CoreBundle\Entity\Club $club
     *
     * @return Jugador
     */
    public function setClub(\CoreBundle\Entity\Club $club = null)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return \CoreBundle\Entity\Club
     */
    public function getClub()
    {
        return $this->club;
    }


}
