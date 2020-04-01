<?php

namespace App\Core\TemplateEngines;

use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigDriver
 *
 * @package App\Core\TemplateEngines
 */
class TwigDriver implements TemplateEngineInterface
{
    /**
     * @const
     */
    const EXT = '.twig';

    /**
     * @var
     */
    private $twig;

    /**
     * @param string $viewsPath
     *
     * @return mixed|void
     */
    public function init(string $viewsPath)
    {
        $loader = new FilesystemLoader($viewsPath);
        $this->twig = new Environment($loader);
        $this->twig->addExtension(new IntlExtension());
    }

    /**
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    public function render(string $template, array $params): string
    {
        return  $this->twig->render($template . self::EXT, $params);
    }
}
