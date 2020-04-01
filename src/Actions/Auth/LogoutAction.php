<?php

namespace App\Actions\Auth;

use App\Core\Request\Request;

/**
 * Class LogoutAction
 *
 * @package App\Actions\Auth
 */
class LogoutAction
{
    /**
     * @param Request $request
     */
    public function execute(Request $request): void
    {
        $request->setCookie('user_id', "", time()-3600);
    }
}
