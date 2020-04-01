<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\LoginAction;
use App\Core\Request\Request;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\NotFoundException;
use Tests\Unit\Actions\AuthTestCase;

/**
 * Class LoginActionTest
 *
 * @package Tests\Unit\Actions\Auth
 */
class LoginActionTest extends AuthTestCase
{
    /**
     * @return LoginAction
     */
    private function getLoginAction(): LoginAction
    {
        return new LoginAction(
            $this->userModel,
            $this->logger,
            $this->hashGenerator
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoginValidationFail()
    {
        $loginAction = $this->getLoginAction();
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('email'))
            ->will($this->returnValue(['errors' => []]));

        $result = $loginAction->execute($request);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoginUserNotFound()
    {
        $loginAction = $this->getLoginAction();
        $request = $this->createMock(Request::class);

        $inputs = [
            'inputs' => [
                'email'    => 'dallas@example.com',
                'password' => 'dallas123',
            ]
        ];

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('email'))
            ->will($this->returnValue($inputs));

        $this->userModel->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(""),
                $this->equalTo('dallas@example.com')
            )
            ->will($this->throwException(new NotFoundException()));

        $request->expects($this->never())
            ->method('setCookie');

        $result = $loginAction->execute($request);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoginUserInvalidPassword()
    {
        $loginAction = $this->getLoginAction();
        $request = $this->createMock(Request::class);

        $inputs = [
            'inputs' => [
                'email'    => 'dallas@example.com',
                'password' => 'atlas123',
            ]
        ];

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('email'))
            ->will($this->returnValue($inputs));

        $this->userModel->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(""),
                $this->equalTo('dallas@example.com')
            )
            ->will($this->returnValue($this->buildUser()));

        $hash = '$2y$10$1SDZnKKH9yCHfWSSo1A6guCQ/JD4THnHziOFKU0pVbu2CPeDNFDHC';

        $this->hashGenerator->expects($this->once())
            ->method('verifyPassword')
            ->with(
                $this->equalTo('atlas123'),
                $this->equalTo($hash)
            )
            ->will($this->throwException(new InvalidPasswordException()));

        $request->expects($this->never())
            ->method('setCookie');

        $result = $loginAction->execute($request);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testLoginUser()
    {
        $loginAction = $this->getLoginAction();
        $request = $this->createMock(Request::class);

        $inputs = [
            'inputs' => [
                'email'    => 'dallas@example.com',
                'password' => 'dallas123',
            ]
        ];

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('email'))
            ->will($this->returnValue($inputs));

        $this->userModel->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo(""),
                $this->equalTo('dallas@example.com')
            )
            ->will($this->returnValue($this->buildUser()));

        $hash = '$2y$10$1SDZnKKH9yCHfWSSo1A6guCQ/JD4THnHziOFKU0pVbu2CPeDNFDHC';

        $this->hashGenerator->expects($this->once())
            ->method('verifyPassword')
            ->with(
                $this->equalTo('dallas123'),
                $this->equalTo($hash)
            )
            ->will($this->returnValue(true));

        $request->expects($this->once())
            ->method('setCookie')
            ->with(
                $this->equalTo('user_id'),
                $this->equalTo(3)
            );

        $result = $loginAction->execute($request);

        $this->assertArrayHasKey('status', $result);
    }
}
