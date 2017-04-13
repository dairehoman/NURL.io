<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Collection;
use AppBundle\Entity\Nurl;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Nurl controller.
 *
 * @Route("nurl")
 */
class NurlController extends Controller
{
    /**
     * Lists all nurl entities.
     *
     * @Route("/", name="nurl_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        return $this->render('nurl/index.html.twig', array(
            'nurls' => $nurls,
        ));
    }

    /**
     * Creates a new nurl entity.
     *
     * @Route("/new", name="nurl_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $nurl = new Nurl();
        $form = $this->createForm('AppBundle\Form\NurlType',$nurl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            if($form["collection"]->getData() != null)
            {
                $collection = $form["collection"]->getData();
                $nurl->addCollection($collection);
            }
            $nurl->setDateCreated(new \DateTime());
            $nurl->setDateLastEdited(new \DateTime());
            $nurl->setAuthor($user);
            $em->persist($nurl);
            $em->flush();

            return $this->redirectToRoute('nurl_show', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/new.html.twig', array(
            'nurl' => $nurl,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a nurl entity.
     *
     * @Route("/{id}", name="nurl_show")
     * @Method("GET")
     */
    public function showAction(Nurl $nurl)
    {
        $deleteForm = $this->createDeleteForm($nurl);
        $addToCollectionForm = $this->createAddToCollectionForm($nurl);
        return $this->render('nurl/show.html.twig', array(
            'nurl' => $nurl,
            'delete_form' => $deleteForm->createView(),
            'add_to_collection_form'=>$addToCollectionForm->createView(),

        ));
    }

    /**
     * Displays a form to edit an existing nurl entity.
     *
     * @Route("/{id}/edit", name="nurl_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Nurl $nurl)
    {
        $deleteForm = $this->createDeleteForm($nurl);
        $editForm = $this->createForm('AppBundle\Form\NurlType', $nurl);
        $editForm->handleRequest($request);
        $nurl->setDateLastEdited(new \DateTime());
        $user = $this->getUser();
        if($editForm["collection"]->getData() != null)
        {
            $collection = $editForm["collection"]->getData();
            $nurl->addCollection($collection);
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('nurl_edit', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/edit.html.twig', array(
            'nurl' => $nurl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
//--------------------------------------------------------------------------------------------
    /**
     * Creates a route to add a Nurl to a Collection
     *
     * @Route("/{id}/add/", name="nurl_add_to_collection")
     * @Method({"GET", "POST"})
     */
    public function addToCollectionAction(Request $request, Nurl $nurl)
    {
        $addToCollectionForm = $this->createAddToCollectionForm($nurl);
        $addToCollectionForm->handleRequest($request);

        if ($addToCollectionForm->isSubmitted() && $addToCollectionForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('nurl/edit.html.twig', array(
            'nurl' => $nurl,
            'edit_form' => $addToCollectionForm->createView(),
            'delete_form' => $addToCollectionForm->createView(),
            'add_to_collection_form'=>$addToCollectionForm->createView(),
        ));
    }
//--------------------------------------------------------------------------------------------

    /**
     * Deletes a nurl entity.
     *
     * @Route("/{id}", name="nurl_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Nurl $nurl)
    {
        $form = $this->createDeleteForm($nurl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nurl);
            $em->flush();
        }

        return $this->redirectToRoute('nurl_index');
    }

    /**
     * Creates a form to delete a nurl entity.
     *
     * @param Nurl $nurl The nurl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Nurl $nurl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurl_delete', array('id' => $nurl->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to ADD a nurl entity TO A COLLECTION.
     *
     * @param Nurl $nurl
     * @return \Symfony\Component\Form\Form The form
     */
    private function createAddToCollectionForm(Nurl $nurl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurl_add_to_collection', array('id' => $nurl->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }
}
