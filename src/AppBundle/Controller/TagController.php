<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tag controller.
 *
 * @Route("tag")
 */
class TagController extends Controller
{
    /**
     * Lists all tag entities.
     *
     * @Route("/", name="tag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        return $this->render('tag/index.html.twig', array(
            'tags' => $tags,

        ));
    }

    /**
     * Creates a new tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tag = new Tag();

        $form = $this->createForm('AppBundle\Form\TagType', $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tag->setIsProposed(true);
            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('tag_show', array('id' => $tag->getId()));
        }

        return $this->render('tag/new.html.twig', array(
            'tag' => $tag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tag entity.
     *
     * @Route("/{id}", name="tag_show")
     * @Method("GET")
     */
    public function showAction(Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $tagUpVoteForm = $this->createUpVoteForm($tag);
        $tagDownVoteForm = $this->createDownVoteForm($tag);

        return $this->render('tag/show.html.twig', array(
            'tag' => $tag,
            'delete_form' => $deleteForm->createView(),
            'tag_upvote' => $tagUpVoteForm->createView(),
            'tag_downvote' => $tagDownVoteForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing tag entity.
     *
     * @Route("/{id}/edit", name="tag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm('AppBundle\Form\TagType', $tag, array('user' => $this->getUser()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tag_edit', array('id' => $tag->getId()));
        }

        return $this->render('tag/edit.html.twig', array(
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tag entity.
     *
     * @Route("/{id}", name="tag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
        }

        return $this->redirectToRoute('tag_index');
    }

    //---------------------------------------------------------------
    /**
     * Upvotes a tag entity.
     *
     * @Route("/{id}/upvote", name="tag_upvote")
     * @Method("PUT")
     */
    public function upVoteAction(Request $request, Tag $tag)
    {
        $form = $this->createUpVoteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($this->getUser() == null)
            {
                if($tag->getNumVotes() == -1)
                {
                    $tag->setNumVotes($tag->getNumVotes() + 2);
                }
                else
                {
                    $tag->setNumVotes($tag->getNumVotes() + 1);
                }
            }
            else {
                if($tag->getNumVotes() == -1)
                {
                    $tag->setNumVotes($tag->getNumVotes() + 6);
                }
                else
                {
                    $tag->setNumVotes($tag->getNumVotes() + 5);
                }

            }
            $em->flush();
        }

        return $this->redirectToRoute('tag_index');
    }
    //---------------------------------------------------------------

    //---------------------------------------------------------------
    /**
     * downvotes a tag entity.
     *
     * @Route("/{id}/downvote", name="tag_downvote")
     * @Method("PUT")
     */
    public function downVoteAction(Request $request, Tag $tag)
    {
        $form = $this->createDownVoteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if($tag->getNumVotes() == -1)
            {
                //do nothing
            }
            else
            {
                $tag->setNumVotes($tag->getNumVotes() - 1);
            }
            $em->flush();
        }

        return $this->redirectToRoute('tag_index');
    }
    //---------------------------------------------------------------

    /**
     * Creates a form to delete a tag entity.
     *
     * @param Tag $tag The tag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', array('id' => $tag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to upvote a tag entity.
     *
     * @param Tag $tag The tag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createUpVoteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_upvote', array('id' => $tag->getId())))
            ->setMethod('PUT')
            ->getForm()
            ;
    }

    /**
     * Creates a form to upvote a tag entity.
     *
     * @param Tag $tag The tag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDownVoteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_downvote', array('id' => $tag->getId())))
            ->setMethod('PUT')
            ->getForm()
            ;
    }
}
