<?php

namespace Tests\Unit\Controllers\Auth;

use App\Actions\Auth\RegisterAction;
use App\Controllers\Auth\RegisterController;
use Tests\Unit\ControllerTestCase;

/**
 * Class RegisterControllerTest
 *
 * @package Tests\Unit\Controllers\Auth
 */
class RegisterControllerTest extends ControllerTestCase
{
    /**
     * @return RegisterController
     */
    private function getController(): RegisterController
    {
        return new RegisterController(
            $this->request,
            $this->redirect,
            $this->sessionManager,
            $this->templateEngine
        );
    }

    /**
     * @test
     */
    public function testGetForm()
    {
        $registerController = $this->getController();

        $response = "Rendered template";

        $this->templateEngine->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('auth/register'),
                $this->arrayHasKey('isLogged')
            )
            ->will($this->returnValue($response));

        $result = $registerController->getForm();

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testRegisterReturnError()
    {
        $registerController = $this->getController();

        $registerAction = $this->createMock(RegisterAction::class);

        $response = "Rendered template";

        $registerAction->expects($this->once())
            ->method('execute')
            ->with($this->request)
            ->will($this->returnValue(['errors' => []]));

        $this->templateEngine->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('auth/register'),
                $this->arrayHasKey('errors')
            )
            ->will($this->returnValue($response));

        $result = $registerController->register($registerAction);

        $this->assertSame(
            $result,
            $response,
            'Response object is not the expected one.'
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testRegister()
    {
        $registerController = $this->getController();

        $registerAction = $this->createMock(RegisterAction::class);

        $registerAction->expects($this->once())
            ->method('execute')
            ->with($this->request)
            ->will($this->returnValue(['status' => []]));

        $this->templateEngine->expects($this->never())
            ->method('render');

        $this->redirect->expects($this->once())
            ->method('login');

        $registerController->register($registerAction);
    }
}
