<?php

if (! function_exists('urlIsActive')) {
    function urlIsActive(string $routeName)
    {
        return request()->route()->getName() === $routeName;
    }
}

if (! function_exists('urlContains')) {
    function urlContains(string $value)
    {
        return str_contains(request()->url(), $value);
    }
}
