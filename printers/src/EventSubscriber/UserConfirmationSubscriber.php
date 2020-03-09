<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/9/20
 * Time: 6:23 PM
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class UserConfirmationSubscriber implements EventSubscriberInterface
{

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['confirmUser', EventPriorities::POST_VALIDATE]
        ];
    }

    public function confirmUser(ViewEvent $event)
    {
        $request = $event->getRequest();

        if('' !== $request->get('_route')) {
            return;
        }

        $confirmationToken = $event->getControllerResult();

        $user = $this->userRepository->findOneBy(
            ['confirmationToken' => $confirmationToken->$confirmationToken]
        );

        if(!$user) {
            throw new NotFoundHttpException();
        }

        $user->setEnabled(true);
        $user->setConfirmationToken(null);
        $this->entityManager->flush();

        $event->setResponse(new JsonResponse(null, Response::HTTP_OK));
    }
}