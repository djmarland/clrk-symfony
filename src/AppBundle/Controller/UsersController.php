<?php

namespace AppBundle\Controller;

class UsersController extends Controller
{
    public function listAction()
    {
        $perPage = 2;
        $currentPage = $this->getCurrentPage();

        $result = $this->get('app.services.users')
            ->findAndCountLatest($perPage, $currentPage);

        $this->toView('users', $result->getDomainModels());
        $this->toView('total', $result->getTotal());

        $this->setPagination(
            $result->getTotal(),
            $currentPage,
            $perPage
        );

        return $this->renderTemplate('users:list');
    }
}
