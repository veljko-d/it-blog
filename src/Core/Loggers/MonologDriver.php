<?php

namespace App\Core\Loggers;

use	Monolog\Logger;
use	Monolog\Handler\StreamHandler;

/**
 * Class MonologDriver
 *
 * @package App\Core\Loggers
 */
class MonologDriver implements LoggerInterface
{
    /**
     * @var Logger
     */
    private $log;

    /**
     * @param string $appName
     * @param string $logFile
     *
     * @throws \Exception
     */
    public function init(string $appName, string $logFile)
    {
        $this->log = new Logger($appName);
        $this->log->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function debug(string $message): void
    {
        $this->log->debug($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function info(string $message): void
    {
        $this->log->info($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function notice(string $message): void
    {
        $this->log->notice($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function warning(string $message): void
    {
        $this->log->warning($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function error(string $message): void
    {
        $this->log->error($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function critical(string $message): void
    {
        $this->log->critical($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function alert(string $message): void
    {
        $this->log->alert($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function emergency(string $message): void
    {
        $this->log->emergency($message);
    }
}
