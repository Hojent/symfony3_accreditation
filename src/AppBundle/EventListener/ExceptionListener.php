<?php
/**
 * Created by PhpStorm.
 * User: german
 * Date: 19.03.2020
 * Time: 13:34
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = sprintf(
            'My Error says: %s with code: %s', null, null
            //$exception->getMessage(),
            //$exception->getCode()
        );

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            //var_dump($exception->getTraceAsString()); die();
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }
}