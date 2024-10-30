<?php
/**
 * Trigger this file on Plugin uininstall
 * 
 * @package LieuCityPlugin
 */

if(!defined('WP_UNINSTALL_PLUGIN')){       //_pt: necessario per evitare intromissioni
    die;
 }
//clear shortcodes
remove_shortcode('lieucity');
// Clear Deatabase sotred data
delete_option( "lieucity_login_info" );






