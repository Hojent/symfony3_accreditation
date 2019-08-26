<?php
// src/Controller/LuckyNumberController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LuckyNumberController extends  Controller
{
    /**
     * @Route("/lucky", name="lucky_nomer")
     */
    public function numAction()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}