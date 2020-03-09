<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/9/20
 * Time: 6:00 PM
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserConfirmation
 * @ApiResource(
 *    collectionOperations={
 *        "post"={
 *           "path"="/users/confirm"
 *      }
 *    }
 *  )
 */
class UserConfirmation
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=30,max=30)
     */
    public $confirmationToken;
}