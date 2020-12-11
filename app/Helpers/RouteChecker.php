<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class RouteChecker
{
    public static function isHome()
    {
        return self::onlyName() == "home";
    }

    public static function onlyName()
    {
        $name = explode('.', Request::route() ? Request::route()->getName() : '');

        if(is_array($name)) {
            return last($name);
        }

        return $name;
    }

    public static function isAuth()
    {
        $name = self::onlyName();

        return ($name == "login") || ($name == "register");
    }

    public static function isItemRoute()
    {
        $name = explode('.', Request::route() ? Request::route()->getName() : '');

        if(isset($name[1]))
            return $name[1] == "dynamic";
        else
            return '';
    }
}
