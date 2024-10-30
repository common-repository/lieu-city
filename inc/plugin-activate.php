<?php
/**
 * @package LieuCityPlugin
 */

namespace LieuCityPlugin;

class lieu_PluginActivate
{
    public static function activate()
    {
        flush_rewrite_rules( );
    }
}