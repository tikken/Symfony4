<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/9/20
 * Time: 3:33 PM
 */

namespace App\Security;


class TokenGenerator
{
    private const APLHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public function getRandomSecureToken(int $length = 30): string
    {
        $token = '';
        $maxNumber = strlen(self::APLHABET);

        for($i = 0; $i < $length; $i++)
        {
            $token .= self::APLHABET[random_int(0,$maxNumber - 1)];
        }

        return $token;
    }
}