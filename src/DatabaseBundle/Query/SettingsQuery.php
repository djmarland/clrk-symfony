<?php
namespace DatabaseBundle\Query;

class SettingsQuery extends Query
{
    public function get()
    {
        $entity = $this->getEntity('Settings')->findOneById(1);
        if ($entity) {
            $result = new QueryResult($entity);
            $result->setDomainModels([
                $this->mapperFactory->getDomainModel($entity)
            ]);
            return $result;
        }
        return null;
    }
}
