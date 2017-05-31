<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoreBundle\Entity\LaLigaEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ClubRepository")
 */
class Club extends LaLigaEntity
{

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="deletedAt", type="datetime", length=255, nullable = true)
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="Jugador", mappedBy="club",cascade={"persist"})
     */
    private $jugadores;


    public function __construct() {
        parent::__construct();
        $this->jugadores = new ArrayCollection();
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
     * @return Club
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
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Club
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return int
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set deletedAt
     *
     * @param string $deletedAt
     *
     * @return Club
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }



    /**
     * Add jugadores
     *
     * @param \CoreBundle\Entity\Jugador $jugador
     *
     * @return Club
     */
    public function addJugador(\CoreBundle\Entity\Jugador $jugador)
    {
        $jugador->setClub($this);

        $this->jugadores->add($jugador);
        return $this;
    }

    /**
     * Remove jugadores
     *
     * @param \CoreBundle\Entity\Jugador $jugador
     */
    public function removeJugador(\CoreBundle\Entity\Jugador $jugador)
    {
        $this->jugadores->removeElement($jugador);
    }

    /**
     * Get jugadores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJugadores()
    {
        return $this->jugadores;
    }

}
