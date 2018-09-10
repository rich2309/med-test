<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DSD;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dsd controller.
 *
 * @Route("dsd")
 */
class DSDController extends Controller
{
    /**
     * Lists all dSD entities.
     *
     * @Route("/", name="dsd_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dSDs = $em->getRepository('AppBundle:DSD')->findAll();

        return $this->render('dsd/index.html.twig', array(
            'dSDs' => $dSDs,
        ));
    }

    /**
     * Creates a new dSD entity.
     *
     * @Route("/new", name="dsd_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dSD = new Dsd();
        $form = $this->createForm('AppBundle\Form\DSDType', $dSD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dSD);
            $em->flush();

            return $this->redirectToRoute('dsd_show', array('id' => $dSD->getId()));
        }

        return $this->render('dsd/new.html.twig', array(
            'dSD' => $dSD,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dSD entity.
     *
     * @Route("/{id}", name="dsd_show")
     * @Method("GET")
     */
    public function showAction(DSD $dSD)
    {
        $deleteForm = $this->createDeleteForm($dSD);

        return $this->render('dsd/show.html.twig', array(
            'dSD' => $dSD,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dSD entity.
     *
     * @Route("/{id}/edit", name="dsd_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DSD $dSD)
    {
        $deleteForm = $this->createDeleteForm($dSD);
        $editForm = $this->createForm('AppBundle\Form\DSDType', $dSD);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dsd_edit', array('id' => $dSD->getId()));
        }

        return $this->render('dsd/edit.html.twig', array(
            'dSD' => $dSD,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dSD entity.
     *
     * @Route("/{id}", name="dsd_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DSD $dSD)
    {
        $form = $this->createDeleteForm($dSD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dSD);
            $em->flush();
        }

        return $this->redirectToRoute('dsd_index');
    }

    /**
     * Creates a form to delete a dSD entity.
     *
     * @param DSD $dSD The dSD entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DSD $dSD)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dsd_delete', array('id' => $dSD->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
