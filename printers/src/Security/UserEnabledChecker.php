<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/9/20
 * Time: 3:18 PM
 */

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserEnabledChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {
        if(!$user instanceof User) {
            return;
        }

        if(!$user->getEnabled()) {
            throw new DisabledException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }
}