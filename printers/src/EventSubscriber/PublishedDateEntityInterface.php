<?php
/**
 * Created by IntelliJ IDEA.
 * User: tikken
 * Date: 3/8/20
 * Time: 1:10 PM
 */

namespace App\EventSubscriber;


interface PublishedDateEntityInterface
{
    public function setPublished(\DateTimeInterface $published):PublishedDateEntityInterface;
}