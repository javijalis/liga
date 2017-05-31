<?php

namespace CoreBundle\Manager;


use CoreBundle\Entity\Jugador;
use Doctrine\ORM\EntityManager;
use CoreBundle\Repository\JugadorRepository;

class JugadorManager
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var JugadorRepository
     */
    private $jugadorRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager       = $entityManager;
        $this->jugadorRepository = $this->entityManager->getRepository('CoreBundle:Jugador');
    }

    /**
     * create
     * @return Jugador
     */
    public function create()
    {
        return new Jugador();
    }

    /**
     * getRepository
     * @return JugadorRepository
     */
    public function getRepository()
    {
        return $this->jugadorRepository;
    }



    /**
     * save
     * persist and flush jugador
     *
     * @param JUgador $jugador
     * @param bool|true $flush
     * @return Jugador
     */
    public function save(Jugador $jugador, $flush = true)
    {
        $this->entityManager->persist($jugador);

        if ($flush) {
            $this->entityManager->flush($jugador);
        }

        return $jugador;
    }

    /**
     * @param Jugador $jugador
     * @param bool $flush
     * @return Jugador
     */
    public function remove(Jugador $jugador, $flush = true)
    {
        $today = new \DateTime('NOW');

        $jugador->setClub(null);
        $jugador->setDeletedAt($today);

        $this->save($jugador);

        return $jugador;

    }
}