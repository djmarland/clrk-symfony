<?php

namespace AppBundle\Controller;

use AppBundle\Presenter\MasterPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController implements InitializableControllerInterface
{
    /**
     * @var User
     */
    protected $currentUser;

    /**
     * @var int
     */
    protected $currentPage = 1;

    /**
     * @var MasterPresenter
     */
    public $masterViewPresenter;

    /**
     * Setup common tasks for a controller
     * @param Request $request
     */
    public function initialize(Request $request)
    {
        $this->masterViewPresenter = new MasterPresenter();
        $this->getSettings();
    }

    private function getSettings()
    {
        // get the initial app settings
        $settings = $this->get('app.services.settings')->get();

        if ($settings === null) {
            // if settings failed due to missing database: 404
            throw new HttpException(404, 'Client does not exist');
        }

        // if app is not active, throw to "not ready" page
        if (!$settings->isActive()) {
            $message = ($settings->isSuspended()) ?
                'Account has been suspended' :
                'Account has not yet been initialised';
             throw new HttpException(202, $message);
        }

        $this->toView('settings', $settings);
    }

    protected function getCurrentPage($request)
    {
        $page = $request->get('page', 1);

        // must be an integer string
        if (
            strval(intval($page)) !== strval($page) ||
            $page < 1
        ) {
            $this->app->abort(404, 'No such page value');
        }
        return (int) $page;
    }

    /**
     * @param int $total Total Results
     * @param int $currentPage The current page value
     * @param int $perPage How many per page
     */
    protected function setPagination(
        $total,
        $currentPage,
        $perPage
    ) {

        $pagination = new PaginationPresenter(
            $total,
            $currentPage,
            $perPage
        );

        if (!$pagination->isValid()) {
            $this->app->abort(404, 'There are not this many pages');
        }

        $this->set('pagination', $pagination);
    }

    /**
     * Set values that make it to the view
     * @param $key
     * @param $value
     * @param bool  $inFeed
     * @return $this
     */
    public function toView(
        $key,
        $value,
        $inFeed = true
    ) {
        $this->masterViewPresenter->set($key, $value, $inFeed);
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     * @throws \AppBundle\Domain\Exception\DataNotSetException
     */
    public function fromView($key)
    {
        return $this->masterViewPresenter->get($key);
    }

    protected function renderTemplate($template)
    {
        $path = 'AppBundle:' . $template . '.html.twig';
        return $this->render($path, $this->masterViewPresenter->getData());
    }
}