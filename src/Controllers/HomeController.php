<?php

namespace App\Controllers;

/**
 * Class HomeController
 *
 * @package App\Controllers
 */
class HomeController extends AbstractController
{
    /**
     * @echo string
     */
	public function index()
    {
        return $this->render('home', []);
	}
}
