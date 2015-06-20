<?php

namespace AppBundle\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->renderTemplate('home:index');
    }
}
