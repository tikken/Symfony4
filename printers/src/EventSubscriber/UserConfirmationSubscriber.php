<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/9/20
 * Time: 6:23 PM
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Exception\InvalidConfirmationTokenException;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;

class UserConfirmationSubscriber implements EventSubscriberInterface
{

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['confirmUser', EventPriorities::POST_VALIDATE]
        ];
    }

    public function confirmUser(ViewEvent $event)
    {
        $this->logger->debug('Fetching user by confirmation token');

        $request = $event->getRequest();

        if('api_user_confirmations_post_collection' !== $request->get('_route')) {
            return;
        }

        $confirmationToken = $event->getControllerResult();

        $user = $this->userRepository->findOneBy(
            ['confirmationToken' => $confirmationToken->confirmationToken]
        );

        if(!$user) {
            $this->logger->debug('User by confirmation token not found');
            throw new InvalidConfirmationTokenException();
        }

        $user->setEnabled(true);
        $user->setConfirmationToken(null);
        $this->entityManager->flush();

        $event->setResponse(new JsonResponse(null, Response::HTTP_OK));

        $this->logger->debug('User confirmed by confirmation token');
    }
}