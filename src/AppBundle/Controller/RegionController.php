<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Region;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Region controller.
 *
 * @Route("region")
 */
class RegionController extends Controller
{
    const PER_PAGE = 3;

    /**
     * Lists all region entities.
     *
     * @Route("/", name="region_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator)
    {
        //$em = $this->get('doctrine.orm.entity_manager');
        $em = $this->getDoctrine()->getManager();

        $regionsQuery = $em->getRepository(Region::class)->listAll();

        $pagination = $paginator->paginate(
            $regionsQuery, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            self:: PER_PAGE /*limit per page*/
        );

        return $this->render('region/index.html.twig', [
            'regions' => $pagination,
        ]);
    }

    /**
     * Creates a new region entity.
     *
     * @Route("/new", name="region_new")
     * @Method({"GET"})
     */
    public function newAction(Request $request)
    {
        $region = new Region();
        $form = $this->createForm('AppBundle\Form\RegionType', $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('region_index');
        }

        return $this->render('region/new.html.twig', array(
            'region' => $region,
            'form' => $form->createView(),
        ));
    }

     /**
     * Displays a form to edit an existing region entity.
     *
     * @Route("/{id}/edit", name="region_edit")
     * @Method({"GET"})
     */
    // автоматическое использование ParamConverter.
    // Вместо ожидаемого $id даем функции объекта типа "объект" Region
    // ParamConverter автоматически запрашивает объект id которого совпадает с {id} и
    // выдаст 404 страницу если не найдет. В данном случае в форм билдер отдается
    // целиком весь объект Region с id = {id}
    // В данном случае работает без конфигурации, т.к. имя заполнителя {id} совпадает
    // с именем свойства сущености [ Region имеет свойство ID]
    // Если имена не свопадают можно запросить сущность вручную, передав в параметры
    // значение переменной
    // Или добавить в анностацию, например для сущности Post
    // @ParamConverter("post", options={"mapping"={"postSlug"="slug"}})
    // свойство slug есть у объекта post

    public function editAction(Request $request, Region $region)
    {

        if (!isset($region) ) { //не работает Ошибка перехватывается раньше этого места.
            throw $this->createNotFoundException('The object does not exist');
        }

        $deleteForm = $this->createDeleteForm($region);
        $editForm = $this->createForm('AppBundle\Form\RegionType', $region);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('region_index');
        }

        return $this->render('region/edit.html.twig', array(
            'region' => $region,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a region entity.
     *
     * @Route("/{id}", name="region_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Region $region)
    {
        $form = $this->createDeleteForm($region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($region);
            $em->flush();
        }

        return $this->redirectToRoute('region_index');
    }

    /**
     * Creates a form to delete a region entity.
     *
     * @param Region $region The region entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Region $region)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('region_delete', array('id' => $region->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
