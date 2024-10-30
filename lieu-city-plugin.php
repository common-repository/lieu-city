<?php

/**
 * Plugin Name: lieu-city 
 * Plugin URI:
 * Description: Includi facilmente la realtà virtuale sul tuo sito web.
 * Author: lieu-city
 * Author URI: https://lieu.city/
 * Version: 1.0.0
 * Text Domain: lieu-city-plugin
 */

if(!defined('ABSPATH')) {       //_pt: necessario per evitare intromissioni
    die('Nothing to see here');
}

require_once plugin_dir_path( __FILE__ ) . 'inc/config-form.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/plugin-activate.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/plugin-deactivate.php';

$lieuconfigform = new LieuCityPlugin\lieu_Configform();
$lieuconfigform->register(); //_pt: lo mettiamo qua e non nel costruttore per evitare azioni con autotrigger nel construttore 

register_activation_hook( __FILE__, array('LieuCityPlugin\lieu_PluginActivate', 'activate') );
register_deactivation_hook( __FILE__, array('LieuCityPlugin\lieu_PluginDeactivate','deactivate') );