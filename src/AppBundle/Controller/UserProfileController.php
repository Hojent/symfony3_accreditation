<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Userprofile controller.
 *
 * @Route("profile")
 */
class UserProfileController extends Controller
{
    private $eventDispatcher;
    private $formFactory;
    private $userManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, FormFactoryInterface $formFactory,   UserManagerInterface $userManager) {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
    }

        /**
     *
     * @Route("/user", name="user_profile_show")
     * @Method("GET")
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('userprofile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Displays a form to edit an existing userProfile entity.
     *
     * @Route("/user/edit", name="user_profile_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm('AppBundle\Form\Type\ProfileType');
        $form->setData($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $up = $form['userprofile']->getData();
            $uid = $up->getUserid();
            //var_dump($uid); die();
            $userprofile = $user->getUserprofile();
            //var_dump($userprofile); die();
            $userprofile->setUserid($uid);

            $pictFile = $form['pict_file_name']->getData();

            if ($pictFile) {
                 $newFilename = $user->getUsername().$user->getId().'.' . $pictFile->guessExtension();
                 $user->setPictFileName($newFilename);

                //$user->setPictFileName(
                //    new File($this->getParameter('clients_directory').'/'.$user->getPictFileName())
                //);

                // Move the file to the directory where photos are stored
                try {
                    $pictFile->move(
                        $this->getParameter('clients_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }


            }

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('user_profile_show');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('userprofile/edit.html.twig', array(
            'edit_form' => $form->createView(),
        ));
    }

}

