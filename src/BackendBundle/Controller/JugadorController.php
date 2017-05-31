<?php

namespace BackendBundle\Controller;

use CoreBundle\Entity\Jugador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Jugador controller.
 *
 * @Route("jugador")
 */
class JugadorController extends Controller
{
    /**
     * indexAction
     * Lists all jugador entities.
     *
     * @Route("/", name="jugador_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $jugadorManager = $this->get('liga.jugadorManager');
        $jugadors       = $jugadorManager->getRepository()->findAll();

        return $this->render('BackendBundle:Jugador:index.html.twig', array(
            'jugadors' => $jugadors,
        ));
    }

    /**
     * newAction
     * Creates a new jugador entity.
     *
     * @Route("/new", name="jugador_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jugadorManager = $this->get('liga.jugadorManager');
        $jugador        = $jugadorManager->create();
        $form             = $this->createForm('BackendBundle\Form\JugadorType', $jugador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $jugadorManager->save($jugador);
            return $this->redirectToRoute('jugador_show', array('id' => $jugador->getId()));
        }

        return $this->render('BackendBundle:Jugador:new.html.twig', array(
            'jugador' => $jugador,
            'form'      => $form->createView(),
        ));
    }

    /**
     * showAction
     * Finds and displays a jugador entity.
     *
     * @Route("/{id}", name="jugador_show")
     * @Method("GET")
     */
    public function showAction(Jugador $jugador)
    {
        $deleteForm = $this->createDeleteForm($jugador);

        return $this->render('BackendBundle:Jugador:show.html.twig', array(
            'jugador' => $jugador,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * editAction
     * Displays a form to edit an existing jugador entity.
     *
     * @Route("/{id}/edit", name="jugador_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Jugador $jugador)
    {
        $deleteForm = $this->createDeleteForm($jugador);
        $editForm   = $this->createForm('BackendBundle\Form\JugadorType', $jugador);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('jugador_edit', array('id' => $jugador->getId()));
        }

        return $this->render('BackendBundle:Jugador:edit.html.twig', array(
            'jugador'   => $jugador,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *  deleteAction
     * Deletes a jugador entity.
     *
     * @Route("/{id}", name="jugador_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Jugador $jugador)
    {
        $jugadorManager = $this->get('liga.jugadorManager');
        $form             = $this->createDeleteForm($jugador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jugadorManager->remove($jugador);
        }

        return $this->redirectToRoute('jugador_index');
    }

    /**
     * createDeleteForm
     * Creates a form to delete a jugador entity.
     *
     * @param Jugador $jugador The jugador entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Jugador $jugador)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jugador_delete', array('id' => $jugador->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
