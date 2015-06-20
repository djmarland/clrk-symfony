<?php

namespace AppBundle\Service;

class SettingsService extends Service
{
    public function get()
    {
        $entity = $this->getEntity('Settings')->findOneById(1);
        if ($entity) {
            $entity = $this->mapperFactory->getDomainModel($entity);
        }
        return $entity;
//        $query = $this->getDatabaseQueryFactory()->createQuery('Settings');
//        $result = $query->get();
//        if ($result === null) {
//            return null; // no settings exist
//        }
//        return $result->getDomainModel();
    }

    public function save($settings)
    {
        $query = $this->getDatabaseQueryFactory()->createQuery('Settings');
        $result = $query->save($settings);
        return $result;
    }
}
