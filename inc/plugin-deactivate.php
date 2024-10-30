<?php
/**
 * @package LieuCityPlugin
 */
namespace LieuCityPlugin;

class lieu_PluginDeactivate
{
    public static function deactivate()
    {
        remove_shortcode('lieucity');
        delete_option( "lieucity_login_info" );
        flush_rewrite_rules( );
    }
 }