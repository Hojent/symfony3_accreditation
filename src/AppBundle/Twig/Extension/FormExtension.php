<?php

namespace AppBundle\Twig\Extension;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{

    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function getName()
    {
        return 'form_extention';
    }

    public function getFunctions()
    {
        return [new TwigFunction('getForm', [$this, 'generateForm']),];
    }

    /*
     * $path - Controller action route name. For example 'app_user_update'.
     */
    public function generateForm($path)
    {
        $form = $this->formFactory->createBuilder(FormType::class, null, ['action' => $path])->getForm();
        return $form->createView();
    }

}
