<?php
namespace AppBundle\Security;

use AppBundle\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface
{
    private $usersService;

    public function __construct($usersService)
    {
        $this->usersService = $usersService;
    }


    public function loadUserByUsername($email)
    {
        $result = $this->usersService->findByEmail($email);

        $user = $result->getDomainModel();

        if (null === $user) {
            $message = sprintf(
                'Unable to find an active admin AppBundle:User object identified by "%s".',
                $email
            );
            throw new UsernameNotFoundException($message);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername((string) $user->getEmail());
    }

    public function supportsClass($class)
    {
        return $class === 'App\Domain\Entity\User';
    }
}