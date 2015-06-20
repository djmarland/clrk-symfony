<?php

namespace AppBundle\Domain\Entity;

use AppBundle\Domain\ValueObject\Email;
use AppBundle\Domain\ValueObject\ID;
use AppBundle\Domain\ValueObject\Password;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * For describe users of the system
 */
class User extends Entity implements UserInterface
{
    const KEY_PREFIX = 'U';

    /**
     * @param ID $id
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param $name
     * @param Email $email
     * @param $passwordDigest
     * @param bool $passwordExpired
     * @param bool $isAdmin
     */
    public function __construct(
        ID $id,
        DateTime $createdAt,
        DateTime $updatedAt,
        $name,
        Email $email,
        $passwordDigest,
        $passwordExpired = false,
        $isAdmin = false
    ) {
        parent::__construct(
            $id,
            $createdAt,
            $updatedAt
        );

        $this->name = $name;
        $this->email = $email;
        $this->passwordExpired = $passwordExpired;
        $this->passwordDigest = $passwordDigest;
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if ($name != $this->name) {
            // @todo - validate not empty
            $this->name = $name;
            $this->updated();
        }
    }

    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(Email $email)
    {
        if ((string) $email != (string) $this->email) {
            // @todo - validate not empty

            // @todo - reset the user to unconfirmed
            $this->email = $email;
            $this->updated();
        }
    }

    /**
     * @var integer
     */
    private $passwordDigest;

    /**
     * @return integer
     */
    public function getPasswordDigest()
    {
        return $this->passwordDigest;
    }

    /**
     * @param $newPassword
     */
    public function setPasswordDigest($newPassword)
    {
        $this->passwordDigest = $newPassword;
    }

    /*
    public function passwordMatches($match)
    {
        $matches =  password_verify($match, $this->passwordDigest);
       // if ($matches && password_needs_rehash($this->passwordDigest, PASSWORD_DEFAULT)) {
            //$password = new Password($match);
            //$this->setPasswordDigest($password);
            // @todo - save this'll need to move into the login controller to work
        // as it needs access to the service
       // }
        return $matches;
    }
    */

    /**
     * @var boolean
     */
    private $passwordExpired = false;

    /**
     * @return boolean
     */
    public function passwordHasExpired()
    {
        return $this->passwordExpired;
    }

    public function expirePassword()
    {
        $this->passwordExpired = true;
    }

    public function renewPassword()
    {
        $this->passwordExpired = false;
    }

    /**
     * @var boolean
     */
    private $isAdmin = false;

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    public function makeAdmin()
    {
        $this->isAdmin = true;
        $this->updated();
    }

    public function revokeAdmin()
    {
        $this->isAdmin = false;
        $this->updated();
    }


    public function getUsername()
    {
        return (string) $this->getEmail();
    }

    public function getPassword()
    {
        return (string) $this->getPasswordDigest();
    }

    public function getSalt()
    {
        return null; // no salt
    }

    public function getRoles()
    {
        return []; // no roles yet
    }

    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
        return ($this->getUsername() == $user->getUsername());
    }
}
