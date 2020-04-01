<?php

namespace Tests\Unit\Controllers;

use App\Controllers\HomeController;
use Tests\Unit\ControllerTestCase;

/**
 * Class HomeControllerTest
 *
 * @package Tests\Unit\Controllers
 */
class HomeControllerTest extends ControllerTestCase
{
    /**
     * @return HomeController
     */
    private function getController(): HomeController
    {
        return new HomeController(
            $this->request,
            $this->redirect,
            $this->sessionManager,
            $this->templateEngine
        );
    }

    /**
     * @test
     */
    public function testReturnHomePage()
    {
        $homeController = $this->getController();

        $response = "Rendered template";

        $this->templateEngine->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('home'),
                $this->anything()
            )
            ->will($this->returnValue($response));

        $result = $homeController->index();

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }
}
