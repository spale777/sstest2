<?php
/**
 * Created by PhpStorm.
 * User: Spale
 * Date: 7/14/2016
 * Time: 11:47 PM
 */
class PropertyAdmin extends ModelAdmin
{
    private static $menu_title = 'Properties';

    private static $url_segment = 'properties';

    private static $managed_models = [
        'Property',
    ];

    private static $menu_icon = 'mysite/icons/property.png';
}