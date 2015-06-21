<?php

namespace AppBundle\Service;

use AppBundle\Domain\Entity\User;
use AppBundle\Domain\ValueObject\ID;
use AppBundle\Domain\ValueObject\Key;

class UsersService extends DatabaseService
{

    /**
     * @param User $user
     * @return User
     */
    public function createNewUser(
        User $user
    ) {
        $id = $this->insert($user);
        $user->setId(new ID($id));
        return $user;
    }

    /**
     * @param $limit
     * @param $page
     * @return ServiceResult
     */
    public function findAndCountLatest(
        $limit,
        $page = 1
    ) {
        // count them first (cheaper if zero)
        $count = $this->countAll();
        if ($count == 0) {
            return $this->getEmptyResult();
        }

        // find the latest
        $result = $this->findLatest($limit, $page);
        $result->setTotal($count);
        return $result;
    }

    public function countAll()
    {
        $entity = $this->getEntity('User');
        $qb = $entity->createQueryBuilder('user');
        $qb->select('count(user.id)');
        $count = (int) $qb->getQuery()->getSingleScalarResult();
        return $count;
    }

    public function findLatest(
        $limit,
        $page = 1
    ) {
        $offset = $this->calculateOffset($limit, $page);
        $entity = $this->getEntity('User');

        $sort = ['created_at' => 'DESC'];

        $data = $entity->findBy(
            [],
            $sort,
            $limit,
            $offset
        );

        if (!$data) {
            $data = array();
        }
        return $this->getResult($data);
    }

    /**
     * @param ID $id
     * @return \AppBundle\Domain\Entity\User|null
     */
    public function findById(ID $id)
    {
        $entity = $this->getEntity('User')->findOneById((string) $id);
        if ($entity) {
            return $this->mapperFactory->getDomainModel($entity);
        }
        return null;
    }

    public function findByKey(Key $key)
    {
        $id = $key->getId();
        return $this->findById($id);
    }

    /**
     * @param $email
     * @return \AppBundle\Domain\Entity\User|null
     */
    public function findByEmail($email)
    {
        $entity = $this->getEntity('User')
            ->findOneBy([
                'email' => $email
            ]);
        if ($entity) {
            return $this->mapperFactory->getDomainModel($entity);
        }
        return null;
    }
}
