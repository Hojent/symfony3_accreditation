<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Banner controller.
 *
 * @Route("admin/banner")
 */
class BannerController extends Controller
{
    /**
     * Lists all banner entities.
     *
     * @Route("/", name="banner_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $banners = $em->getRepository('AppBundle:Banner')->findAll();

        return $this->render('banner/index.html.twig', array(
            'banners' => $banners,
        ));
    }

    /**
     * Creates a new banner entity.
     *
     * @Route("/new", name="banner_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $banner = new Banner();
        $form = $this->createForm('AppBundle\Form\BannerType', $banner);
        $form->handleRequest($request);
        $imgdir = $this->getParameter('img_directory');

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fileName = $form['fileName']->getData();
            if ($fileName) {
                $newFilename = $fileName->getClientOriginalName();
                // Move the file to the directory where documents are stored
                try {
                    $fileName->move(
                        $imgdir,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $banner->setFileName($newFilename);
            }

            $em->persist($banner);
            $em->flush();

            return $this->redirectToRoute('banner_show', array('id' => $banner->getId()));
        }

        return $this->render('banner/new.html.twig', array(
            'banner' => $banner,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a banner entity.
     *
     * @Route("/{id}", name="banner_show")
     * @Method("GET")
     */
    public function showAction(Banner $banner)
    {
        $deleteForm = $this->createDeleteForm($banner);

        return $this->render('banner/show.html.twig', array(
            'banner' => $banner,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing banner entity.
     *
     * @Route("/{id}/edit", name="banner_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Banner $banner)
    {
        $deleteForm = $this->createDeleteForm($banner);
        $editForm = $this->createForm('AppBundle\Form\BannerType', $banner);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $fileName = $editForm['fileName']->getData();
            if ($fileName) {
                $newFilename = 'banner'.$banner->getId().'.' . $fileName->guessExtension();
                $banner->setFileName($newFilename);
                //$user->setPictFileName(
                //    new File($this->getParameter('clients_directory').'/'.$user->getPictFileName())
                //);
                // Move the file to the directory where photos are stored
                try {
                    $fileName->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('banner_edit', array('id' => $banner->getId()));
        }

        return $this->render('banner/edit.html.twig', array(
            'banner' => $banner,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a banner entity.
     *
     * @Route("/{id}", name="banner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Banner $banner)
    {
        $form = $this->createDeleteForm($banner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filename = $banner->getFileName();
            $realfile = 'uploads/img/'.$filename;
            if (file_exists(realpath($realfile))) {
                unlink(realpath($realfile));
                $this->addFlash('success', 'Файл ' . $filename . ' удален!');
            }
            else {
                $this->addFlash('error', 'Файл ' . $realfile . ' не найден!');
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($banner);
            $em->flush();
        }
        return $this->redirectToRoute('banner_index');
    }

    /**
     * Creates a form to delete a banner entity.
     *
     * @param Banner $banner The banner entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Banner $banner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('banner_delete', array('id' => $banner->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
