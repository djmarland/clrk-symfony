<?php

namespace AppBundle\Service;

class SettingsService extends Service
{
    public function get()
    {
        $result = $this->getQueryFactory()
            ->createSettingsQuery()
            ->get();
        if ($result) {
            return $result->getDomainModel();
        }
        return null;
    }

}
