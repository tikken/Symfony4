<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/8/20
 * Time: 12:44 PM
 */

namespace App\EventSubscriber;

use Symfony\Component\Security\Core\User\UserInterface;

interface AuthoredEntityInterface
{
    public function setAuthor(UserInterface $user): AuthoredEntityInterface;
}