<?php

namespace App\Actions\Auth;

use App\Core\Loggers\LoggerInterface;
use App\Core\Request\Request;
use App\Domain\User;
use App\Exceptions\DbException;
use App\Exceptions\NotFoundException;
use App\Models\User\UserModelInterface;
use App\Utils\HashGenerator;
use App\Utils\Slug\Slug;

/**
 * Class RegisterAction
 *
 * @package App\Actions\Auth
 */
class RegisterAction
{
    /**
     * @var array
     */
    private $validationFields = [
        'name' => [
            'required' => true,
            'min'      => 2,
            'max'      => 255,
        ],
        'email' => [
            'required' => true,
            'type'     => 'email',
            'max'      => 255,
        ],
        'password' => [
            'required' => true,
            'min'      => 6,
            'max'      => 255,
        ],
        'password_confirmation' => [
            'required' => true,
            'min'      => 6,
            'max'      => 255,
            'same'     => 'password',
        ],
    ];

    /**
     * @var UserModelInterface
     */
    private $userModel;

    /**
     * @var User
     */
    private $user;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var HashGenerator
     */
    private $hashGenerator;

    /**
     * @var Slug
     */
    private $slug;

    /**
     * RegisterAction constructor.
     *
     * @param UserModelInterface $userModel
     * @param User               $user
     * @param LoggerInterface    $logger
     * @param HashGenerator      $hashGenerator
     * @param Slug               $slug
     */
    public function __construct(
        UserModelInterface $userModel,
        User $user,
        LoggerInterface $logger,
        HashGenerator $hashGenerator,
        Slug $slug
    ) {
        $this->userModel = $userModel;
        $this->user = $user;
        $this->logger = $logger;
        $this->hashGenerator = $hashGenerator;
        $this->slug = $slug;
        $this->slug->setModel($this->userModel);
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \ReflectionException
     */
    public function execute(Request $request)
    {
        try {
            $data = $request->validate($this->validationFields);
        } catch (NotFoundException $e) {
            die($e->getMessage());
        }

        if (isset($data['errors'])) {
            return ['errors' => $data['errors']];
        }

        try {
            return $this->store($data['inputs']);
        } catch (DbException $e) {
            $this->logger->error('Error: ' . $e->getMessage());
            return ['errors' => ['errors' => 'Error: Failed to register user']];
        }
    }

    /**
     * @param array $inputs
     *
     * @return array
     */
    private function store(array $inputs)
    {
        $userInstance = $this->createUser($inputs);
        $this->userModel->store($userInstance);

        return ['status' => 'You have successfully registered!'];
    }

    /**
     * @param array $inputs
     *
     * @return User
     */
    private function createUser(array $inputs): User
    {
        return $this->user->create(
            $inputs['name'],
            $this->slug->getSlug($inputs['name']),
            $inputs['email'],
            $this->hashGenerator->hash($inputs['password'])
        );
    }
}
