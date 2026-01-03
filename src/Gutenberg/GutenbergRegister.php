<?php

namespace TestProject\CasinoCards\Gutenberg;

use TestProject\CasinoCards\Bootstrap;
use TestProject\CasinoCards\Config\PluginConfig;
use TestProject\CasinoCards\Gutenberg\Blocks\StatisticsCardBlock;
use TestProject\CasinoCards\Gutenberg\Blocks\BonusCardBlock;

/**
 * GutenbergRegister class
 */
class GutenbergRegister
{
    private const NAMESPACE = 'casino-cards';

    // TODO: add Alignment support
    private array $blocks = [
        'statistics-card' => [
            'render_callback' => StatisticsCardBlock::class,
            'attributes' => [
                'casinoId' => ['type' => 'string', 'default' => ''],
                'overrides' => ['type' => 'object', 'default' => []],
            ],
        ],
        'bonus-card' => [
            'render_callback' => BonusCardBlock::class,
            'attributes' => [
                'casinoId' => ['type' => 'string', 'default' => ''],
                'overrides' => ['type' => 'object', 'default' => []],
            ]
        ],
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        add_action('init', [$this, 'registerBlocks']);
        add_filter('block_categories_all', [$this, 'registerBlockCategory']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueueEditorScripts']);
        add_action('enqueue_block_assets', [$this, 'enqueueFrontScripts']);
    }

    /**
     * @return void
     */
    public function registerBlocks(): void
    {
        foreach ($this->blocks as $blockName => $blockConfig) {
            register_block_type(
                self::NAMESPACE . '/' . $blockName,
                [
                    'render_callback' => new $blockConfig['render_callback'](),
                    'attributes' => $blockConfig['attributes'] ?? [],
                    'supports' => $blockConfig['supports'] ?? [],
                    'editor_script' => self::NAMESPACE . '-block-script-editor',
                    'editor_style' => self::NAMESPACE . '-block-style-editor',
                    'style' => self::NAMESPACE . '-' . $blockName . '-style',
                ]
            );
        }
    }

    /**
     * @param array $categories
     * @return array
     */
    public function registerBlockCategory(array $categories): array
    {
        return array_merge(
            [
                [
                    'slug' => self::NAMESPACE . '-block-category',
                    'title' => __('Casino Cards plugin', PluginConfig::TEXT_DOMAIN),
                    'icon' => '',
                ],
            ],
            $categories
        );
    }

    /**
     * @return void
     */
    public function enqueueEditorScripts(): void
    {
        wp_enqueue_script(
            self::NAMESPACE . '-block-script-editor',
            Bootstrap::$pluginUrl . 'assets/dist/js/casino-cards-editor.min.js',
            [
                'wp-blocks',
                'wp-i18n',
                'wp-editor',
                'wp-components',
                'wp-block-editor',
                'wp-element',
            ],
            filemtime(Bootstrap::$pluginPath . 'assets/dist/js/casino-cards-editor.min.js')
        );

        wp_enqueue_style(
            self::NAMESPACE . '-block-style-editor',
            Bootstrap::$pluginUrl . 'assets/dist/css/casino-cards-editor.min.css',
            ['wp-edit-blocks'],
            filemtime(Bootstrap::$pluginPath . 'assets/dist/css/casino-cards-editor.min.css')
        );
    }

    /**
     * @return void
     */
    public function enqueueFrontScripts(): void
    {
        foreach (array_keys($this->blocks) as $blockName) {
            $rel = 'assets/dist/css/' . $blockName . '.min.css';
            wp_register_style(
                self::NAMESPACE . '-' . $blockName . '-style',
                Bootstrap::$pluginUrl . $rel,
                [],
                filemtime(Bootstrap::$pluginPath . $rel)
            );
        }
    }
}
