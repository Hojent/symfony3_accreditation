<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security;


/**
 * Document controller.
 *
 * @Route("document")
 */
class DocumentController extends Controller
{
    const PER_PAGE = 10;

    /**
     * Lists all document entities.
     *
     * @Route("/", name="document_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $documentQuery = $em->getRepository(Document::class)->listAll();

        $pagination = $paginator->paginate(
            $documentQuery, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            self:: PER_PAGE /*limit per page*/
        );

        return $this->render('document/index.html.twig', array(
            'documents' => $pagination,
        ));
    }

    /**
     * Creates a new document entity.
     *
     * @Route("/new", name="document_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm('AppBundle\Form\DocumentType', $document);
        $form->handleRequest($request);
        $docdir = $this->getParameter('official_documents');
        if (!is_dir($docdir)) {
            mkdir($docdir);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fileName = $form['fileName']->getData();
            if ($fileName) {
                $newFilename = $fileName->getClientOriginalName();
                // Move the file to the directory where documents are stored
                try {
                    $fileName->move(
                        $docdir,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $document->setFileName($newFilename);
            }
            $em->persist($document);
            $em->flush();
            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/new.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }

     /**
     * Displays a form to edit an existing document entity.
     *
     * @Route("/{id}/edit", name="document_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm('AppBundle\Form\DocumentType', $document);
        $editForm->handleRequest($request);
        $docdir = $this->getParameter('official_documents');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $fileName = $editForm['fileName']->getData();
            if ($fileName) {
                $newFilename = $fileName->getClientOriginalName();
                // Move the file to the directory where documents are stored
                try {
                    $fileName->move(
                        $docdir,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $document->setFileName($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_index', array('id' => $document->getId()));
        }

        return $this->render('document/edit.html.twig', array(
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a document entity.
     *
     * @Route("/{id}", name="document_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Document $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filename = $document->getFileName();
            $realfile = 'documents/'.$filename;
            if (file_exists(realpath($realfile))) {
                unlink(realpath($realfile));
                $this->addFlash('success', 'Файл ' . $filename . ' удален!');
            }
            else {
                $this->addFlash('error', 'Файл ' . $realfile . ' не найден!');
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }

        return $this->redirectToRoute('document_index');
    }

    /**
     * Creates a form to delete a document entity.
     *
     * @param Document $document The document entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Document $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
