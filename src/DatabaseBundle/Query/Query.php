<?php

namespace DatabaseBundle\Query;

use DatabaseBundle\Mapper\MapperFactory;
use Doctrine\ORM\EntityManager;

class Query {

    protected $entityManager;

    protected $mapperFactory;

    public function __construct(
        EntityManager $entityManager,
        MapperFactory $mapperFactory
    ) {
        $this->entityManager = $entityManager;
        $this->mapperFactory = $mapperFactory;
    }

    public function getEntity($name)
    {
        return $this->entityManager
            ->getRepository('DatabaseBundle:' . $name);
    }

    protected function calculateOffset(
        $limit,
        $page
    ) {
        return ($limit * ($page-1));
    }

    public function getEmptyResult()
    {
        return $this->getResult([],0);
    }

    public function getResult($data, $total = null)
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        $queryResult = new QueryResult($data, $total);
        $domainModels = array();
        foreach ($queryResult->getItems() as $item) {
            $mapper = $this->mapperFactory->getMapper($item);
            $domainModels[] = $mapper->getDomainModel($item);
        }
        $queryResult->setDomainModels($domainModels);
        return $queryResult;
    }

    public function insert($domain)
    {
        $mapper = $this->mapperFactory->getMapper($domain);

        $entity = $mapper->getOrmEntity($domain);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity->getId();
    }
}