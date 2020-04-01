<?php

namespace Tests\Unit;

use App\Core\Redirect;
use App\Core\Request\Request;
use App\Core\SessionManager;
use App\Core\TemplateEngines\TwigDriver;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\AbstractTestCase;

/**
 * Class ControllerTestCase
 *
 * @package Tests\Unit
 */
abstract class ControllerTestCase extends AbstractTestCase
{
    /**
     * @var Request|MockObject
     */
    protected $request;

    /**
     * @var Redirect|MockObject
     */
    protected $redirect;

    /**
     * @var SessionManager|MockObject
     */
    protected $sessionManager;

    /**
     * @var TwigDriver|MockObject
     */
    protected $templateEngine;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->request = $this->createMock(Request::class);
        $this->redirect = $this->createMock(Redirect::class);
        $this->sessionManager = $this->createMock(SessionManager::class);
        $this->templateEngine = $this->createMock(TwigDriver::class);
    }
}
