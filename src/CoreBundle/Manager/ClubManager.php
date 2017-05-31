<?php

namespace CoreBundle\Manager;

use CoreBundle\Entity\Club;
use CoreBundle\Entity\Jugador;
use Doctrine\ORM\EntityManager;
use CoreBundle\Repository\ClubRepository;
use CoreBundle\Manager\JugadorManager;
use Doctrine\Common\Collections\ArrayCollection;

class ClubManager
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ClubRepository
     */
    private $clubRepository;

    /**
     * @var JugadorManager $jugadorManager
     */
    private $jugadorManager;

    public function __construct(EntityManager $entityManager, JugadorManager $jugadorManager)
    {
        $this->entityManager    = $entityManager;
        $this->jugadorManager   = $jugadorManager;
        $this->clubRepository   = $this->entityManager->getRepository('CoreBundle:Club');
    }

    /**
     * @return Club
     */
    public function create()
    {
        return new Club();
    }

    /**
     * @return ClubRepository
     */
    public function getRepository()
    {
        return $this->clubRepository;
    }


    /**
     * @param Club $newClub
     * @param null $originalJugadores
     * @param bool $flush
     * @return Club
     */
    public function save(Club $newClub,$originalJugadores = null,$flush = true)
    {

        if(count($originalJugadores) > 0) {

            // logical delete Jugadores
            /** @var Jugador $jugador */
            foreach ($originalJugadores as $jugador) {
                if (false === $newClub->getJugadores()->contains($jugador)) {
                    $this->jugadorManager->remove($jugador);
                }
            }
        }


        $this->entityManager->persist($newClub);

        if ($flush) {
            $this->entityManager->flush($newClub);
        }

        return $newClub;
    }



    /**
     * remove
     * Club logical delete
     *
     * @param Club $club
     * @param bool|true $flush
     * @return Club
     */
    public function remove(Club $club, $flush = true)
    {
        $today = new \DateTime('NOW');

        foreach ($club->getJugadores() as $jugador) {
            $this->jugadorManager->remove($jugador);
        }

        $club->setDeletedAt($today);

        $this->save($club);

        return $club;
    }
}