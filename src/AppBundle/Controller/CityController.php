<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;

use AppBundle\Entity\CityFilterEntity;
use AppBundle\Form\CityRegionFilterType;
use AppBundle\Form\CityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * City controller.
 *
 * @Route("city")
 */
class CityController extends Controller
{
    protected const PER_PAGE = 15;

    /**
     * Lists all city entities.
     * @Route("/", name="city_index")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:City');

        /** @var CityFilterEntity $fieldsFilterEntity */
        $cityFilterEntity = new CityFilterEntity();

        /** @var CityRegionFilterType $formFilterClass */
        $formFilterClass = CityRegionFilterType::class;

        $formFilter = $this->createForm($formFilterClass, $cityFilterEntity);
        $formFilter->handleRequest($request);

        $cityQuery = $repository->getItemList($cityFilterEntity);

        $pagination = $paginator->paginate(
            $cityQuery, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            self:: PER_PAGE /*limit per page*/
        );

        return $this->render('city/index.html.twig', [
                'formFilter'  => $formFilter->createView(),
                'pagination' => $pagination,
            ]
        );

    }


    /**
     * Creates a new city entity.
     *
     * @Route("/new", name="city_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $city = new City();

        $form = $this->createForm(CityType::class, $city);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/new.html.twig', array(
            'city' => $city,
            'form' => $form->createView(),
        ));
    }

        /**
     * Displays a form to edit an existing city entity.
     *
     * @Route("/{id}/edit", name="city_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, City $city)
    {
        $deleteForm = $this->createDeleteForm($city);
        $editForm = $this->createForm('AppBundle\Form\CityType', $city);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/edit.html.twig', [
            'city' => $city,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a city entity.
     *
     * @Route("/{id}", name="city_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, City $city)
    {
        $form = $this->createDeleteForm($city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();
        }

        return $this->redirectToRoute('city_index');
    }

    /**
     * Creates a form to delete a city entity.
     *
     * @param City $city The city entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(City $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('city_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
