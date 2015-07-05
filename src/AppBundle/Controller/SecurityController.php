<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $message = null;

        if ($error) {
            $message = $error->getMessage();
        }

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $this->toView('lastEmail', $lastUsername);
        $this->toView('loginError', $error);
        $this->toView('loginErrorMessage', $message);

        return $this->renderTemplate('security:login');
    }
}