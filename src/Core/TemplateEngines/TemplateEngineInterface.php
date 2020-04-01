<?php

namespace App\Core\TemplateEngines;

/**
 * Interface TemplateEngineInterface
 *
 * @package App\Core\TemplateEngines
 */
interface TemplateEngineInterface
{
    /**
     * @param string $viewsPath
     *
     * @return mixed
     */
    public function init(string $viewsPath);
}
