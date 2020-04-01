<?php

namespace App\Controllers;

use App\Core\Redirect;
use App\Core\Request\Request;
use App\Core\SessionManager;
use App\Core\TemplateEngines\TemplateEngineInterface;

/**
 * Class AbstractController
 *
 * @package App\Controllers
 */
abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Redirect
     */
    protected $redirect;

    /**
     * @var SessionManager
     */
    protected $sessionManager;

    /**
     * @var TemplateEngineInterface
     */
    protected $templateEngine;

    /**
     * @var
     */
    protected $userId;

    /**
     * AbstractController constructor.
     *
     * @param Request                 $request
     * @param Redirect                $redirect
     * @param SessionManager          $sessionManager
     * @param TemplateEngineInterface $templateEngine
     */
    public function __construct(
        Request $request,
        Redirect $redirect,
        SessionManager $sessionManager,
        TemplateEngineInterface $templateEngine
    ) {
        $this->request = $request;
        $this->redirect = $redirect;
        $this->sessionManager = $sessionManager;
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    private function loggedUserId(): int
    {
        return $this->request->getCookies()->getInteger('user_id');
    }

    /**
     * @param string $name
     * @param        $value
     */
    protected function setStatusMessage(string $name, $value)
    {
        $this->sessionManager->startSession();
        $this->sessionManager->set($name, $value);
    }

    /**
     * @return mixed
     */
    public function getStatusMessage()
    {
        $this->sessionManager->startSession();
        $message = $this->sessionManager->get('status');
        $this->sessionManager->unset('status');

        return $message;
    }

    /**
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function render(string $template, array $params): string
    {
        $params = array_merge($this->initialParams(), $params);

        return $this->templateEngine->render($template, $params);
    }

    /**
     * @return array
     */
    public function initialParams()
    {
        $initialParams = [
            'isLogged'     => (bool) $this->loggedUserId(),
            'loggedUserId' => $this->loggedUserId(),
        ];

        if ($message = $this->getStatusMessage()) {
            $initialParams['status'] = $message;
        }

        return $initialParams;
    }
}
