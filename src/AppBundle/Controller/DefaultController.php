<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Banner;
use AppBundle\Entity\Event;
use AppBundle\Repository\BannerRepository;
use AppBundle\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DefaultController extends Controller
{
    /*
     * var $reRegister - if user try to duplicate register
     */
    private $reRegister = 0;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->reRegister = $request->query->get('reRegister');
                $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAllOne();

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir').DIRECTORY_SEPARATOR),
            'reRegister' => $this->reRegister,
            'events' => $events,
        ]);
    }

    /**
     * @Route("/contact", name="contact_email")
     */
    public function contactAction(Request $request)
    {
        $defaultData = ['text' => ' . '];

        $transport = new \Swift_MailTransport('mail.memo.by');
        $this->mailer = new \Swift_Mailer($transport);

        $form = $this->createFormBuilder($defaultData)
            ->add('name', TextType::class, ['label' => 'Ваше имя'])
            ->add('email', EmailType::class, ['label' => 'E-mail'])
            ->add('text', TextareaType::class, ['label' => 'Текст сообщения'])
            ->add('phone', HiddenType::class)
            ->add('send', SubmitType::class, ['label' => 'Отправить'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('phone')->getData()){
                return $this->render('default/index.html.twig');
            }
            else {
                $from = $form->get('email')->getData();
                $fromadmin = 'admin@memo.by';
                $myname = $form->get('name')->getData();
                $text = $form->get('text')->getData();
                // data is an array with "name", "email", and "message" keys
                $message = (new \Swift_Message('EvLogger - Hello Admin: From: '.$myname))
                    ->setFrom($fromadmin)
                    ->setTo('irin_german@yahoo.com')
                    ->setBody(
                        $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                            'default/email.html.twig',
                            ['name' => $myname, 'from' => $from, 'text' => $text ]
                        ),
                        'text/html'
                    );

                $this->mailer->send($message);
                return $this->render('default/sent.html.twig', ['name' => $myname, 'from' => $from, 'text' => $text]);
            }

        }
        return $this->render('default/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);

    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle\Entity\Banner');
        $banners = $repo->findBy(['publish' => true]);
        return $this->render('sidebar.html.twig', array(
            'banners' => $banners
        ));
    }

}
