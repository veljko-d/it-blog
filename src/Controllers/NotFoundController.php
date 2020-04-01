<?php

namespace App\Controllers;

/**
 * Class NotFoundController
 *
 * @package App\Controllers
 */
class NotFoundController extends AbstractController
{
    /**
     * @echo string
     */
	public function index()
    {
        $params = ['message' => 'Page not found!'];

        return $this->render('not-found', $params);
	}
}
