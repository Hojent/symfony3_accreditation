<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 *
 * @IsGranted("ROLE_ADMIN")
 * @Route("admin/clients")
 */
class UserAdminController extends Controller
{
    private const PER_PAGE = 10;

    /**
     * @Route("/", name="user_list")     *
     */
    public function indexAction(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $uid = $user->getId();
        $clients = $em->getRepository(UserProfile::class)->listAll($uid);

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
        $deleteForm = $this->createDeleteForm($userprofile);
        $userdir = $this->getParameter('documents_directory').'/'.$user->getUsername().$user->getId();
        if (is_dir($userdir)) {
           $files = array_diff(scandir($userdir), ['..', '.']);
        } else {
            $files = [];
        }
        return $this->render('admin/users/show.html.twig', [
            'client' => $userprofile,
            'uid' => $uid,
            'delete_form' => $deleteForm->createView(),
            'files' => $files,
        ]);
    }

    /**
     * Deletes a smitip entity.
     *
     * @Route("/{id}/delete", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserProfile $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$event->removeUser($user->getUserid());
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_list');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param UserProfile $user
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserProfile $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', ['id' => $user->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Blocks user.
     * @Route("/{id}/block", name="admin_user_block")
     */
    public function blockAction(Request $request, UserProfile $user)
    {
            $em = $this->getDoctrine()->getManager();
            $user->getUserid()->setEnabled(false);
            $em->flush();
        return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
    }

    /**
     * Unblocks user.
     * @Route("/{id}/unblock", name="admin_user_unblock")
     */
    public function unblockAction(Request $request, UserProfile $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->getUserid()->setEnabled(true);
        $em->flush();
        return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
    }


}

