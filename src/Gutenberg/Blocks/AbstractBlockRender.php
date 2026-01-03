<?php

namespace TestProject\CasinoCards\Gutenberg\Blocks;

use TestProject\CasinoCards\Bootstrap;

/**
 * AbstractBlockRender
 *
 */
abstract class AbstractBlockRender
{
    /**
     * @param array $attributes
     * @return string
     */
    public function __invoke(array $attributes): string
    {
        return $this->render($attributes);
    }

    /**
     * @param array $attributes
     * @return string
     */
    abstract protected function render(array $attributes): string;

    /**
     * TODO: Implement class for all templates in plugin
     *
     * @param string $relativePath
     * @param array $vars
     * @return string
     */
    protected function renderTemplate(string $relativePath, array $vars = []): string
    {
        $template = Bootstrap::$pluginPath . 'templates/' . ltrim($relativePath, '/');
        if (! is_readable($template)) {
            return '';
        }

        extract($vars, EXTR_SKIP);

        ob_start();
        include $template;

        return (string) ob_get_clean();
    }
}
