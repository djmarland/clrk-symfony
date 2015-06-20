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
}