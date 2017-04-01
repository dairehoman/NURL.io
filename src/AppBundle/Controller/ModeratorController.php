<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Moderator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Moderator controller.
 *
 * @Route("moderator")
 */
class ModeratorController extends Controller
{
    /**
     * Lists all moderator entities.
     *
     * @Route("/", name="moderator_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $moderators = $em->getRepository('AppBundle:Moderator')->findAll();

        return $this->render('moderator/index.html.twig', array(
            'moderators' => $moderators,
        ));
    }

    /**
     * Creates a new moderator entity.
     *
     * @Route("/new", name="moderator_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $moderator = new Moderator();
        $form = $this->createForm('AppBundle\Form\ModeratorType', $moderator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($moderator);
            $em->flush();

            return $this->redirectToRoute('moderator_show', array('id' => $moderator->getId()));
        }

        return $this->render('moderator/new.html.twig', array(
            'moderator' => $moderator,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a moderator entity.
     *
     * @Route("/{id}", name="moderator_show")
     * @Method("GET")
     */
    public function showAction(Moderator $moderator)
    {
        $deleteForm = $this->createDeleteForm($moderator);

        return $this->render('moderator/show.html.twig', array(
            'moderator' => $moderator,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing moderator entity.
     *
     * @Route("/{id}/edit", name="moderator_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Moderator $moderator)
    {
        $deleteForm = $this->createDeleteForm($moderator);
        $editForm = $this->createForm('AppBundle\Form\ModeratorType', $moderator);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('moderator_edit', array('id' => $moderator->getId()));
        }

        return $this->render('moderator/edit.html.twig', array(
            'moderator' => $moderator,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a moderator entity.
     *
     * @Route("/{id}", name="moderator_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Moderator $moderator)
    {
        $form = $this->createDeleteForm($moderator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($moderator);
            $em->flush();
        }

        return $this->redirectToRoute('moderator_index');
    }

    /**
     * Creates a form to delete a moderator entity.
     *
     * @param Moderator $moderator The moderator entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Moderator $moderator)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moderator_delete', array('id' => $moderator->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
