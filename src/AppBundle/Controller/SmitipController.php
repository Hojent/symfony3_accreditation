<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Smitip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Smitip controller.
 *
 * @Route("admin/smitip")
 */
class SmitipController extends Controller
{
    /**
     * Lists all smitip entities.
     *
     * @Route("/", name="admin_smitip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $smitips = $em->getRepository(Smitip::class)->findAll();

        return $this->render('admin/smitip/index.html.twig', array(
            'smitips' => $smitips,
        ));
    }

    /**
     * Creates a new smitip entity.
     *
     * @Route("/new", name="admin_smitip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $smitip = new Smitip();
        $form = $this->createForm('AppBundle\Form\SmitipType', $smitip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($smitip);
            $em->flush();

            return $this->redirectToRoute('admin_smitip_index');
        }

        return $this->render('admin/smitip/new.html.twig', [
            'smitip' => $smitip,
            'form' => $form->createView(),
        ]);
    }

     /**
     * Displays a form to edit an existing smitip entity.
     *
     * @Route("/{id}/edit", name="admin_smitip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Smitip $smitip)
    {
        $deleteForm = $this->createDeleteForm($smitip);
        $editForm = $this->createForm('AppBundle\Form\SmitipType', $smitip);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_smitip_index');
        }

        return $this->render('admin/smitip/edit.html.twig', array(
            'smitip' => $smitip,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a smitip entity.
     *
     * @Route("/{id}", name="admin_smitip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Smitip $smitip)
    {
        $form = $this->createDeleteForm($smitip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($smitip);
            $em->flush();
        }

        return $this->redirectToRoute('admin_smitip_index');
    }

    /**
     * Creates a form to delete a smitip entity.
     *
     * @param Smitip $smitip The smitip entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Smitip $smitip)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_smitip_delete', array('id' => $smitip->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
