<?php

namespace Tests\Unit\Controllers;

use App\Controllers\NotFoundController;
use Tests\Unit\ControllerTestCase;

/**
 * Class NotFoundControllerTest
 *
 * @package Tests\Unit\Controllers
 */
class NotFoundControllerTest extends ControllerTestCase
{
    /**
     * @return NotFoundController
     */
    private function getController(): NotFoundController
    {
        return new NotFoundController(
            $this->request,
            $this->redirect,
            $this->sessionManager,
            $this->templateEngine
        );
    }

    /**
     * @test
     */
    public function testReturnNotFoundPage()
    {
        $notFoundController = $this->getController();

        $response = "Rendered template";

        $this->templateEngine->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('not-found'),
                $this->arrayHasKey('message')
            )
            ->will($this->returnValue($response));

        $result = $notFoundController->index();

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }
}
