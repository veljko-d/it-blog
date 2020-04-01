<?php

namespace App\Core\Loggers;

/**
 * Interface LoggerInterface
 *
 * @package App\Core\TemplateEngines
 */
interface LoggerInterface
{
    /**
     * @param string $appName
     * @param string $logFile
     *
     * @return mixed
     */
    public function init(string $appName, string $logFile);
}
