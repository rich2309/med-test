<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DSD;
use AppBundle\Form\DSDType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $request->query->getInt('limit', 4)
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
     * @Route("/update/{id}/edit", name="dsd_edit")
     * @param Request $request
     * @param DSD $dSD
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, DSD $dSD)
    {
        $editForm = $this->createForm(DSDType::class, $dSD);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dsd_index');
        }

        return $this->render('@App/SDS/edit.html.twig', array(
            'dSD' => $dSD,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a dSD entity.
     *
     * @Route("/delete/{id}", name="dsd_delete")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, int $id)
    {
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($em->getRepository(DSD::class)->find($id));
            $em->flush();

            return new JsonResponse([
                'url' => $this->generateUrl('dsd_index'),
                'code' => 201]);
        }
        return $this->redirectToRoute('dsd_index');
    }

}
