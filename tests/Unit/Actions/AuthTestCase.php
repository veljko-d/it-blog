<?php

namespace Tests\Unit\Actions;

use App\Core\Loggers\MonologDriver;
use App\Domain\User;
use App\Models\User\UserModelInterface;
use App\Utils\HashGenerator;
use ReflectionClass;
use Tests\AbstractTestCase;

/**
 * Class AuthTestCase
 *
 * @package Tests\Unit\Actions
 */
abstract class AuthTestCase extends AbstractTestCase
{
    /**
     * @var
     */
    protected $logger;

    /**
     * @var
     */
    protected $userModel;

    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $hashGenerator;

    /**
     * @setUp
     */
    public function setUp(): void
    {
        $this->logger = $this->createMock(MonologDriver::class);
        $this->userModel = $this->createMock(UserModelInterface::class);
        $this->user = $this->createMock(User::class);
        $this->hashGenerator = $this->createMock(HashGenerator::class);
    }

    /**
     * @return User
     * @throws \ReflectionException
     */
    protected function buildUser(): User
    {
        $user = new User();

        $user = $user->create(
            'Dallas',
            'dallas',
            'dallas@example.com',
            '$2y$10$1SDZnKKH9yCHfWSSo1A6guCQ/JD4THnHziOFKU0pVbu2CPeDNFDHC'
        );

        $reflectionClass = new ReflectionClass(User::class);

        $property = $reflectionClass->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($user, 3);

        return $user;
    }
}
