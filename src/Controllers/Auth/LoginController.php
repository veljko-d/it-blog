<?php

namespace App\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Controllers\AbstractController;

/**
 * Class LoginController
 *
 * @package App\Controllers\Auth
 */
class LoginController extends AbstractController
{
    /**
     * @return string
     */
    public function getForm(): string
    {
        return $this->render('auth/login', []);
    }

    /**
     * @param LoginAction $loginAction
     *
     * @return string
     * @throws \ReflectionException
     */
    public function login(LoginAction $loginAction)
    {
        $params = $loginAction->execute($this->request);

        if (isset($params['errors'])) {
            return $this->render('auth/login', $params);
        }

        $this->setStatusMessage('status', $params['status']);
        $this->redirect->home();
    }

    /**
     * @param LogoutAction $logoutAction
     */
    public function logout(LogoutAction $logoutAction)
    {
        $logoutAction->execute($this->request);

        $this->redirect->home();
    }
}
