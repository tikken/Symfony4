<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/14/20
 * Time: 2:53 PM
 */

namespace App\Exception;


use Throwable;

class InvalidConfirmationTokenException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct('Confirmation token is invalid', $code, $previous);
    }
}