<?php

namespace AppBundle\Service;

class UsersService extends Service
{
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

    public function save($settings)
    {
        $query = $this->getDatabaseQueryFactory()->createQuery('Settings');
        $result = $query->save($settings);
        return $result;
    }
}
