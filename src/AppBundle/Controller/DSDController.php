<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DSD;
use AppBundle\Form\DSDType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DSDController extends Controller
{
    /**
     * Lists all dSD entities.
     *
     * @Route("/", name="dsd_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator  = $this->get('knp_paginator');
        $dSDs = $em->getRepository('AppBundle:DSD')->findAll();
        $resultsPaginated = $paginator->paginate(
            $dSDs,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('@App/SDS/list.html.twig', array(
            'dSDs' => $resultsPaginated,
        ));
    }

    /**
     * Creates a new dSD entity.
     *
     * @Route("/new", name="dsd_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $dSD = new Dsd();
        $form = $this->createForm(DSDType::class, $dSD);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dSD);
            $em->flush();
            $dSDs = $em->getRepository(DSD::class)->findAll();

            return $this->redirectToRoute('dsd_index', array('DSDs' => $dSDs));
        }

        return $this->render('@App/SDS/add.html.twig', array(
            'dSD' => $dSD,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dSD entity.
     *
     * @Route("/{id}/edit", name="dsd_edit")
     * @param Request $request
     * @param DSD $dSD
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, DSD $dSD)
    {
        $deleteForm = $this->createDeleteForm($dSD);
        $editForm = $this->createForm(DSDType::class, $dSD);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dsd_edit', array('id' => $dSD->getId()));
        }

        return $this->render('@App/SDS/edit.html.twig', array(
            'dSD' => $dSD,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dSD entity.
     *
     * @Route("/{id}", name="dsd_delete")
     * @param Request $request
     * @param DSD $dSD
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
