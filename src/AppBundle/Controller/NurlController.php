<?php

namespace AppBundle\Controller;

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
    //---------------------------------------------------------------

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
    //---------------------------------------------------------------

    /**
     * Creates a new nurl entity.
     *
     * @Route("/new", name="nurl_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $nurl = new Nurl();
        $form = $this->createForm('AppBundle\Form\NurlType',$nurl, array('user' => $this->getUser()));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            if($form["tags"]->getData() != null)
            {
                $tags = $form["tags"]->getData();
                $tagArray = $tags->toArray();
                foreach ($tagArray as $tag) {
                    $nurl->addTag($tag);
                }
            }

            $nurl->setAuthor($user);

            if(null === $nurl->getAuthor())
            {
                $nurl->setTimeReported(new \DateTime());
                $nurl->setDateCreated(new \DateTime());
                $nurl->setDateLastEdited(new \DateTime());
                $nurl->setIsProposedByAnonymous(true);
                $nurl->setIsPublic(false);
                $em->persist($nurl);
                $em->flush();
            }

            else
            {
                if($form["collection"]->getData() != null)
                {
                    $collection = $form["collection"]->getData();
                    $nurl->addCollection($collection);
                    $collection->addNurl($nurl);
                }
                $nurl->setIsProposedByAnonymous(false);
                $nurl->setTimeReported(new \DateTime());
                $nurl->setDateCreated(new \DateTime());
                $nurl->setDateLastEdited(new \DateTime());
                $em->persist($nurl);
                $em->flush();
            }
            return $this->redirectToRoute('nurl_show', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/new.html.twig', array(
            'nurl' => $nurl,
            'form' => $form->createView(),
        ));
    }
    //---------------------------------------------------------------

    /**
     * Finds and displays a nurl entity.
     *
     * @Route("/{id}", name="nurl_show")
     * @Method("GET")
     */
    public function showAction(Nurl $nurl)
    {
        $deleteForm = $this->createDeleteForm($nurl);
        $upVoteForm = $this->createUpVoteForm($nurl);
        $createReportAgainstForm = $this->createReportAgainstForm($nurl);

        return $this->render('nurl/show.html.twig', array(
            'nurl' => $nurl,
            'delete_form' => $deleteForm->createView(),
            'nurl_upvote' => $upVoteForm->createView(),
            'nurl_report' => $createReportAgainstForm->createView()
        ));
    }
    //---------------------------------------------------------------

    /**
     * Finds and displays a nurl entity.
     *
     * @Route("/{id}/report", name="nurl_report")
     * @Method({"GET","POST"})
     */
    public function reportAction(Request $request, Nurl $nurl)
    {

        $createReportAgainstForm = $this->createForm('AppBundle\Form\ReportNurlType', $nurl);
        $createReportAgainstForm->handleRequest($request);

        if ($createReportAgainstForm->isSubmitted() && $createReportAgainstForm->isValid())
        {
            $nurl->setTimeReported(new \DateTime());
            $nurl->setEmailOfReporter($this->getUser()->getEmail());
            $nurl->setReportedAgainstReason($createReportAgainstForm['reportedAgainstReason']->getData());
            $nurl->setIsReportedAgainst(true);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('nurl/report.html.twig', array(
            'nurl' => $nurl,
            'nurl_report' => $createReportAgainstForm->createView()
        ));
    }
    //---------------------------------------------------------------

    //---------------------------------------------------------------

    /**
     * Finds and displays a nurl entity.
     *
     * @Route("/frozen/index", name="nurl_frozen")
     * @Method("GET")
     *
     */
    public function frozenIndexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        return $this->render('nurl/frozen.html.twig', array(
            'nurls' => $nurls,
        ));
    }
    //---------------------------------------------------------------
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


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if(null != $nurl->getAuthor())
            {
                if($editForm["collection"]->getData() != null)
                {
                    $collection = $editForm["collection"]->getData();
                    $nurl->addCollection($collection);
                }
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('nurl_edit', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/edit.html.twig', array(
            'nurl' => $nurl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    //---------------------------------------------------------------
    /**
     * Upvotes a nurl entity.
     *
     * @Route("/{id}/upvote", name="nurl_upvote")
     * @Method("PUT")
     */
    public function upVoteAction(Request $request, Nurl $nurl)
    {
        $form = $this->createUpVoteForm($nurl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($this->getUser() == null)
            {
                if($nurl->getNumVotes() == -1)
                {
                    $nurl->setNumVotes($nurl->getNumVotes() + 2);
                }
                else
                {
                    $nurl->setNumVotes($nurl->getNumVotes() + 1);
                }
            }
            else {
                if($nurl->getNumVotes() == -1)
                {
                    $nurl->setNumVotes($nurl->getNumVotes() + 6);
                }
                else
                {
                    $nurl->setNumVotes($nurl->getNumVotes() + 5);
                }

            }
            $em->flush();
        }

        return $this->redirectToRoute('home');
    }
    //---------------------------------------------------------------

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
    //---------------------------------------------------------------

    /**
     * Shows a decision form for moderator/admin to freeze/unfreeze a nurl.
     *
     * @Route("/{id}/decide", name="nurl_decide")
     * @Method({"GET", "POST"})
     */
    public function decideAction(Request $request, Nurl $nurl)
    {

        $form = $this->createForm('AppBundle\Form\DecideType', $nurl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $nurl->setModeratorComments($form["moderatorComments"]->getData());
            $nurl->setIsReportedAgainst(false);
            $nurl->setIsPublic(true);
            $nurl->setIsProposedByAnonymous(false);
            $nurl->setReportedAgainstReason('');
            $nurl->setEmailOfReporter('');
            $em->flush();
            return $this->redirectToRoute('nurl_index');
        }

        return $this->render('nurl/decision.html.twig', array(
            'nurl' => $nurl,
            'decision_form' => $form->createView()
        ));
    }
    //---------------------------------------------------------------

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
    //---------------------------------------------------------------

    /**
     * Creates a form to upvote a nurl entity.
     *
     * @param Nurl $nurl The nurl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createUpVoteForm(Nurl $nurl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurl_upvote', array('id' => $nurl->getId())))
            ->setMethod('PUT')
            ->getForm()
            ;
    }
    //---------------------------------------------------------------

    /**
     * Creates a form to report a nurl entity.
     *
     * @param Nurl $nurl The nurl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createReportAgainstForm(Nurl $nurl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurl_report', array('id' => $nurl->getId())))
            ->setMethod('PUT')
            ->getForm()
            ;
    }
    //---------------------------------------------------------------

    /**
     * Creates a form to decide a nurl entity.
     *
     * @param Nurl $nurl The nurl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDecisionForm(Nurl $nurl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurl_decide', array('id' => $nurl->getId())))
            ->setMethod('PUT')
            ->getForm()
            ;
    }
    //---------------------------------------------------------------

}
