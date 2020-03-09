<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/7/20
 * Time: 8:15 AM
 */
namespace App\EventSubscriber;

use App\Security\TokenGenerator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Swift_Message;
use Swift_Mailer;
use App\Entity\User;

class UserRegisterSubscriber implements EventSubscriberInterface
{
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        TokenGenerator $tokenGenerator,
        Swift_Mailer $mailer
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
          KernelEvents::VIEW => ['userRegistered', EventPriorities::PRE_WRITE]
        ];
    }

    public function userRegistered(ViewEvent $event)
    {
        $user = $event->getControllerResult();

        if($user instanceof User)
        {
            //It is an User, hash here
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user, $user->getPassword())
            );
        }

        $user->setConfirmationToken(
            $this->tokenGenerator->getRandomSecureToken()
        );


        $message = (new Swift_Message('Hello from api platform'))
            ->setFrom('tikken23@gmail.com')
            ->setTo('Tikken23@yandex.ru')
            ->setBody('Hello bitch');

        $this->mailer->send($message);
    }
}