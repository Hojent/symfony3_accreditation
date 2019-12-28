<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evtip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Evtip controller.
 *
 * @Route("admin/evtip")
 */
class EvtipController extends Controller
{
    /**
     * Lists all evtip entities.
     *
     * @Route("/", name="admin_evtip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evtips = $em->getRepository('AppBundle:Evtip')->findAll();

        return $this->render('admin/evtip/index.html.twig', [
            'evtips' => $evtips,
        ]);
    }

    /**
     * Creates a new evtip entity.
     *
     * @Route("/new", name="admin_evtip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evtip = new Evtip();
        $form = $this->createForm('AppBundle\Form\EvtipType', $evtip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evtip);
            $em->flush();

            return $this->redirectToRoute('admin_evtip_index');
        }

        return $this->render('admin/evtip/new.html.twig', [
            'evtip' => $evtip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing evtip entity.
     *
     * @Route("/{id}/edit", name="admin_evtip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evtip $evtip)
    {
        $deleteForm = $this->createDeleteForm($evtip);
        $editForm = $this->createForm('AppBundle\Form\EvtipType', $evtip);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_evtip_index', array('id' => $evtip->getId()));
        }

        return $this->render('admin/evtip/edit.html.twig', [
            'evtip' => $evtip,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a evtip entity.
     *
     * @Route("/{id}", name="admin_evtip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evtip $evtip)
    {
        $form = $this->createDeleteForm($evtip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evtip);
            $em->flush();
        }

        return $this->redirectToRoute('admin_evtip_index');
    }

    /**
     * Creates a form to delete a evtip entity.
     *
     * @param Evtip $evtip The evtip entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Evtip $evtip)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_evtip_delete', array('id' => $evtip->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
