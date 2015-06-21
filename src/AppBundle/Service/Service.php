<?php

namespace AppBundle\Service;

use AppBundle\Mapper\MapperFactory;
use Doctrine\ORM\EntityManager;

abstract class Service
{
    /**
     * @param EntityManager $entityManager
     * @param MapperFactory $mapperFactory
     */
    public function __construct(
        EntityManager $entityManager,
        MapperFactory $mapperFactory
    ) {
        $this->setEntityManager($entityManager);
        $this->setMapperFactory($mapperFactory);
    }

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    protected function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntity($name)
    {
        return $this->getEntityManager()
            ->getRepository('DatabaseBundle:' . $name);
    }

    /**
     * @var MapperFactory
     */
    public $mapperFactory;

    /**
     * @return MapperFactory
     */
    protected function getMapperFactory()
    {
        return $this->mapperFactory;
    }

    /**
     * @param MapperFactory $mapperFactory
     */
    protected function setMapperFactory(MapperFactory $mapperFactory)
    {
        $this->mapperFactory = $mapperFactory;
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

        $queryResult = new ServiceResult($data, $total);
        $domainModels = array();
        foreach ($queryResult->getItems() as $item) {
            $mapper = $this->mapperFactory->getMapper($item);
            $domainModels[] = $mapper->getDomainModel($item);
        }
        $queryResult->setDomainModels($domainModels);
        return $queryResult;
    }
}
