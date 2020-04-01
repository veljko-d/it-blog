<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\RegisterAction;
use App\Core\Request\Request;
use App\Domain\User;
use App\Exceptions\DbException;
use App\Utils\Slug\Slug;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\Actions\AuthTestCase;

/**
 * Class RegisterActionTest
 *
 * @package Tests\Unit\Actions\Auth
 */
class RegisterActionTest extends AuthTestCase
{
    /**
     * @var Slug|MockObject
     */
    protected $slug;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->slug = $this->createMock(Slug::class);
    }

    /**
     * @return RegisterAction
     */
    private function getRegisterAction(): RegisterAction
    {
        return new RegisterAction(
            $this->userModel,
            $this->user,
            $this->logger,
            $this->hashGenerator,
            $this->slug
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testRegisterValidationFail()
    {
        $registerAction = $this->getRegisterAction();
        $request = $this->createMock(Request::class);

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('email'))
            ->will($this->returnValue(['errors' => []]));

        $result = $registerAction->execute($request);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testRegisterError()
    {
        $registerAction = $this->getRegisterAction();
        $user = $this->buildUser();
        $request = $this->createMock(Request::class);

        $this->validateAndGetUser($request, $user);

        $this->userModel->expects($this->once())
            ->method('store')
            ->with($this->equalTo($user))
            ->will($this->throwException(new DbException()));

        $this->logger->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Error:'));

        $result = $registerAction->execute($request);

        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testRegister()
    {
        $registerAction = $this->getRegisterAction();
        $user = $this->buildUser();
        $request = $this->createMock(Request::class);

        $this->validateAndGetUser($request, $user);

        $this->userModel->expects($this->once())
            ->method('store')
            ->with($this->equalTo($user));

        $result = $registerAction->execute($request);

        $this->assertArrayHasKey('status', $result);
    }

    /**
     * @param Request $request
     * @param User    $user
     */
    private function validateAndGetUser(Request $request, User $user)
    {
        $inputs = [
            'inputs' => [
                'name'     => 'Dallas',
                'email'    => 'dallas@example.com',
                'password' => 'dallas123',
            ]
        ];

        $request->expects($this->once())
            ->method('validate')
            ->with($this->arrayHasKey('email'))
            ->will($this->returnValue($inputs));

        $this->slug->expects($this->once())
            ->method('getSlug')
            ->with($this->equalTo('Dallas'))
            ->will($this->returnValue('dallas'));

        $hash = '$2y$10$1SDZnKKH9yCHfWSSo1A6guCQ/JD4THnHziOFKU0pVbu2CPeDNFDHC';

        $this->hashGenerator->expects($this->once())
            ->method('hash')
            ->with($this->equalTo('dallas123'))
            ->will($this->returnValue($hash));

        $this->user->expects($this->once())
            ->method('create')
            ->with(
                $this->equalTo('Dallas'),
                $this->equalTo('dallas'),
                $this->equalTo('dallas@example.com'),
                $this->equalTo($hash)
            )
            ->will($this->returnValue($user));
    }
}
