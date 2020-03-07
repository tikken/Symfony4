<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/7/20
 * Time: 8:15 AM
 */
namespace App\EventSubscriber;

use http\Env\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class PasswordHashSubscriber implements EventSubscriberInterface
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function hashPassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();

        if($user instanceof User)
        {
            //It is an User, hash here
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user, $user->getPassword())
            );
        }


    }
}