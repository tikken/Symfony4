<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/14/20
 * Time: 1:11 PM
 */

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;
use App\Exception\EmptyBodyException;

class EmptyBodySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['handleEmptyBody', EventPriorities::POST_DESERIALIZE]
        ];
    }

    public function handleEmptyBody(RequestEvent $event)
    {
        $method = $event->getRequest()->getMethod();

        if(!in_array($method, [Request::METHOD_POST, Request::METHOD_PUT]))
        {
            return;
        }

        $data = $event->getRequest()->get('data');


    }
}