<?php
/*
Plugin Name: WI Games plugin for WordPress
Plugin URI: http://wi-games.ru/wordpress-plugin-install
Description: Integrates WI Games widget support to WordPress
Version: 1.0.2
Author: WI Games
Author URI: http://wi-games.com
*/

// registration link
define('WI_GAMES_REG_LINK', 'http://backend.wigames.net/register/');

// setup help link
define('WI_GAMES_SETUP_HELP_LINK', 'http://wi-games.ru/wordpress-plugin-install');

// F.A.Q. link
define('WI_GAMES_FAQ_LINK', 'http://wi-games.ru/faq');

require_once "UniversalClassLoader.php";
if (!defined(__DIR__)) {
    define('__DIR__', dirname(__FILE__));
}

$_loader = new UniversalClassLoader();
$_loader->registerPrefix('WIGames', __DIR__.'/src');
$_loader->register();

$_settings = new WIGames_Admin_Settings();
$_frontend = new WIGames_Frontend();