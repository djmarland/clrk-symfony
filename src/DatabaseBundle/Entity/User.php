<?php
namespace DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\HasLifecycleCallbacks()
* @ORM\Table(name="users")
*/
class User extends Entity
{
    /**
    * @ORM\Column(name="name", type="string", length=255)
    */
    public $name;
}
