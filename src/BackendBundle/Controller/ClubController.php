<?php

namespace BackendBundle\Controller;

use CoreBundle\Entity\Club;
use CoreBundle\Entity\Jugador;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Bundle\CoreBundle\Manager\ClubManager;

/**
 * Club controller.
 *
 * @Route("club")
 */
class ClubController extends Controller
{
    /**
     * indexAction
     * Lists all club entities.
     *
     * @Route("/", name="club_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $clubManager = $this->get('liga.clubManager');
        $clubs       = $clubManager->getRepository()->findAll();

        return $this->render('BackendBundle:Club:index.html.twig', array(
            'clubs' => $clubs,
        ));
    }

    /**
     * newAction
     * Creates a new club entity.
     *
     * @Route("/new", name="club_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $clubManager = $this->get('liga.clubManager');

        $club = $clubManager->create();
        $form = $this->createForm('BackendBundle\Form\ClubType', $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $clubManager->save($club);

            return $this->redirectToRoute('club_show', array('id' => $club->getId()));
        }

        return $this->render('BackendBundle:Club:new.html.twig', array(
            'club' => $club,
            'form' => $form->createView(),
        ));
    }

    /**
     * showAction
     * Finds and displays a club entity.
     *
     * @Route("/{id}", name="club_show")
     * @Method("GET")
     */
    public function showAction(Club $club)
    {
        $deleteForm = $this->createDeleteForm($club);

        return $this->render('BackendBundle:Club:show.html.twig', array(
            'club'        => $club,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * editAction
     * Displays a form to edit an existing club entity.
     *
     * @Route("/{id}/edit", name="club_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Club $club)
    {
        $clubManager  = $this->get('liga.clubManager');
        $deleteForm   = $this->createDeleteForm($club);
        $editForm     = $this->createForm('BackendBundle\Form\ClubType', $club);

        // save original jugadores
        $originalJugadores = new ArrayCollection();
        foreach ($club->getJugadores() as $jugador) {
            $originalJugadores->add($jugador);
        }

        // after handleRequest $club has his jugadores modified, update with originalClub data
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $clubManager->save($club,$originalJugadores);
            return $this->redirectToRoute('club_edit', array('id' => $club->getId()));
        }

        return $this->render('BackendBundle:Club:edit.html.twig', array(
            'club'        => $club,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * deleteAction
     * Deletes a club entity.
     *
     * @Route("/{id}", name="club_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Club $club)
    {
        $clubManager = $this->get('liga.clubManager');
        $form        = $this->createDeleteForm($club);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clubManager->remove($club);
        }

        return $this->redirectToRoute('club_index');
    }

    /**
     * createDeleteForm
     * Creates a form to delete a club entity.
     *
     * @param Club $club The club entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Club $club)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('club_delete', array('id' => $club->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
