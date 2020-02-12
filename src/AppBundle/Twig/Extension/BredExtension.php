<?php

namespace AppBundle\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class BredExtension extends \Twig_Extension

{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * @var Router
     */
    private $router;

    /**
     * @param Breadcrumbs $breadcrumbs
     * @param RouteInterface $router
     */
    public function __construct(Breadcrumbs $breadcrumbs, RouterInterface $router)
    {
        $this->breadcrumbs = $breadcrumbs;
        $this->router = $router;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bread', array($this, 'addBread'))
        );
    }

    public function addBread($label, $url = '', array $translationParameters = array())
    {
        $this->breadcrumbs->addItem($label, $url, $translationParameters);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'bread';
    }

}