<?php

/**
 * Plugin Name: Casino Cards Demo Plugin
 * Plugin URI: https://github.com/sergey-kh/
 * Description: Custom Casino Cards Demo Plugin.
 * Version: 1.0.0
 * Author: Serhii Barsukov
 * Author URI: https://github.com/sergey-kh/
 * License: All Rights Reserved
 *
 * This plugin is provided for review purposes only.
 * Any use, copying, modification or distribution is prohibited
 * without explicit written permission of the author.
 */

declare(strict_types=1);

namespace TestProject\CasinoCards;

defined('ABSPATH') || exit;

$autoload = __DIR__ . '/vendor/autoload.php';
if (is_readable($autoload)) {
    require_once $autoload;
}

if (class_exists(Bootstrap::class)) {
    register_activation_hook(__FILE__, [Bootstrap::class, 'activate']);
    register_deactivation_hook(__FILE__, [Bootstrap::class, 'deactivate']);

    Bootstrap::instance();
}
