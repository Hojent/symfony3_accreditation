<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use AppBundle\Entity\User;

/**
 *
 * @IsGranted("ROLE_ADMIN")
 * @Route("admin/clients")
 */
class UserAdminController extends Controller
{
    private const PER_PAGE = 20;

    /**
     * @Route("/", name="user_list")     *
     */
    public function indexAction(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository(UserProfile::class)->listAll();

        $pagination = $paginator->paginate(
            $clients, /* query NOT result */
            $request->query->get('page', 1), /*page number*/
            self:: PER_PAGE /*limit per page*/
        );
        //------------------

        $users = [];
        foreach ($pagination as $client ) {
            $em->getRepository(User::class)->loadUserByUserprofile($client->getId());
            //вызов функции из репозитория User связал id пользователя и id профайла и
        }
        //---------------------
        return $this->render('admin/users/index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

     /**
     * @Route("/{id}", name="admin_user_show")
     */
    public function showAction(UserProfile $userprofile)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->loadUserByUserprofile($userprofile);
        $uid = $user->getId();

        return $this->render('admin/users/show.html.twig', [
            'client' => $userprofile,
            'uid' => $uid,
        ]);
    }


}

