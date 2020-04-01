<?php

namespace App\Actions\Auth;

use App\Core\Loggers\LoggerInterface;
use App\Core\Request\Request;
use App\Exceptions\DbException;
use App\Exceptions\InvalidPasswordException;
use App\Exceptions\NotFoundException;
use App\Models\User\UserModelInterface;
use App\Utils\HashGenerator;

/**
 * Class LoginAction
 *
 * @package App\Actions\Auth
 */
class LoginAction
{
    /**
     * @var array
     */
    private $validationFields = [
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
    ];

    /**
     * @var UserModelInterface
     */
    private $userModel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var HashGenerator
     */
    private $hashGenerator;

    /**
     * LoginAction constructor.
     *
     * @param UserModelInterface $userModel
     * @param LoggerInterface    $logger
     * @param HashGenerator      $hashGenerator
     */
    public function __construct(
        UserModelInterface $userModel,
        LoggerInterface $logger,
        HashGenerator $hashGenerator
    ) {
        $this->userModel = $userModel;
        $this->logger = $logger;
        $this->hashGenerator = $hashGenerator;
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

        $email = $data['inputs']['email'];
        $password = $data['inputs']['password'];

        try {
            return $this->login($request, $email, $password);
        } catch (DbException $e) {
            $this->logger->error('Error: ' . $e->getMessage());
            return ['errors' => ['errors' => 'Error logging user']];
        } catch (NotFoundException $e) {
            return ['errors' => ['errors' => "User with an email '$email' not found"]];
        } catch (InvalidPasswordException $e) {
            return ['errors' => ['errors' => $e->getMessage()]];
        }
    }

    /**
     * @param Request $request
     * @param string  $email
     * @param string  $password
     *
     * @return array
     * @throws InvalidPasswordException
     */
    private function login(Request $request, string $email, string $password)
    {
        $user = $this->userModel->get("", $email);
        $this->hashGenerator->verifyPassword($password, $user->getPassword());
        $request->setCookie('user_id', $user->getId());

        return ['status' => "Welcome, {$user->getName()}!"];
    }
}
