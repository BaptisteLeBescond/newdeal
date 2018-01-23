<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Pmss;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pmss controller.
 *
 * @Route("cotisations")
 */
class PmssController extends Controller
{
    /**
     * Lists all pmss entities.
     *
     * @Route("/", name="cotisations_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pmsses = $em->getRepository('AppBundle:Pmss')->findAll();

        return $this->render('pmss/index.html.twig', array(
            'pmsses' => $pmsses,
        ));
    }

    /**
     * Creates a new pmss entity.
     *
     * @Route("/new", name="cotisations_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pmss = new Pmss();
        $form = $this->createForm('AppBundle\Form\PmssType', $pmss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pmss);
            $em->flush();

            return $this->redirectToRoute('cotisations_show', array('id' => $pmss->getId()));
        }

        return $this->render('pmss/new.html.twig', array(
            'pmss' => $pmss,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pmss entity.
     *
     * @Route("/{id}", name="cotisations_show")
     * @Method("GET")
     */
    public function showAction(Pmss $pmss)
    {
        $deleteForm = $this->createDeleteForm($pmss);

        return $this->render('pmss/show.html.twig', array(
            'pmss' => $pmss,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pmss entity.
     *
     * @Route("/{id}/edit", name="cotisations_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pmss $pmss)
    {
        $deleteForm = $this->createDeleteForm($pmss);
        $editForm = $this->createForm('AppBundle\Form\PmssType', $pmss);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cotisations_edit', array('id' => $pmss->getId()));
        }

        return $this->render('pmss/edit.html.twig', array(
            'pmss' => $pmss,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pmss entity.
     *
     * @Route("/{id}", name="cotisations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pmss $pmss)
    {
        $form = $this->createDeleteForm($pmss);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pmss);
            $em->flush();
        }

        return $this->redirectToRoute('cotisations_index');
    }

    /**
     * Creates a form to delete a pmss entity.
     *
     * @param Pmss $pmss The pmss entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pmss $pmss)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cotisations_delete', array('id' => $pmss->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Get a pmss by year and month.
     *
     * @Route("/{year}/{month}", name="cotisations_by_year_month")
     * @Method("GET")
     */
    public function showYearMonthAction($year, $month)
    {
        $em = $this->getDoctrine()->getManager();

        $pmss = $em->getRepository('AppBundle:Pmss')->findBy(
            array(
                'year' => $year,
                'month' => $month,
            )
        );

        $deleteForm = $this->createDeleteForm($pmss);

        return $this->render('pmss/show.html.twig', array(
            'pmss' => $pmss,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
