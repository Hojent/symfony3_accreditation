<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class RegistrationController extends Controller
{
     private $security;  //check if user authorised

     public function __construct(Security $security)
     {
         $this->security = $security;
     }

    /**
     * @Route("/registration")
     */
    public function newAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!$this->security->isGranted('ROLE_USER')) {
            // 1) build the form
            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            // 2) handle the submit (will only happen on POST)
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // ... do any other work - like sending them an email, etc
                // maybe set a "flash" success message for the user

                return $this->redirectToRoute('homepage');
            }

            return $this->render(
                'registration/registration.html.twig',
                ['form' => $form->createView()]
            );
        } else {return $this->redirectToRoute('homepage', [
            'reRegister' => 1 ]);}
    }


}
