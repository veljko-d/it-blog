<?php

namespace App\Controllers\Auth;

use App\Actions\Auth\RegisterAction;
use App\Controllers\AbstractController;

/**
 * Class RegisterController
 *
 * @package App\Controllers\Auth
 */
class RegisterController extends AbstractController
{
    /**
     * @return string
     */
    public function getForm(): string
    {
        return $this->render('auth/register', []);
    }

    /**
     * @param RegisterAction $registerAction
     *
     * @return string
     * @throws \ReflectionException
     */
    public function register(RegisterAction $registerAction)
    {
        $params = $registerAction->execute($this->request);

        if (isset($params['errors'])) {
            return $this->render('auth/register', $params);
        }

        $this->setStatusMessage('status', $params['status']);
        $this->redirect->login();
    }
}
