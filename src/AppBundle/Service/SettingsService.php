<?php

namespace AppBundle\Service;

class SettingsService extends DatabaseService
{
    public function get()
    {
        $entity = $this->getEntity('Settings')->findOneById(1);
        if ($entity) {
            $entity = $this->mapperFactory->getDomainModel($entity);
        }
        return $entity;
    }

}
