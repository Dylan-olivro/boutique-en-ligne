<?php
function isEmpty($a)
{
    return empty($a) ? true : false;
}

function isSame($a, $b)
{
    return $a == $b ? true : false;
}

function h($a)
{
    return htmlspecialchars($a);
}
function hd($a)
{
    return htmlspecialchars_decode(htmlspecialchars($a));
}

function isName($a)
{
    return preg_match("#^(\pL+[- ']?)*\pL$#ui", $a) ? true : false;
}

function isPostcode($a)
{
    return preg_match("~^[0-9]{5}$~", $a) ? true : false;
}
function isNumber($a)
{
    return preg_match("/^[0-9]*$/", $a) ? true : false;
}
function isStreet($a)
{
    return preg_match("~^[0-9]{4}$~", $a) ? true : false;
}

function isToBig($a)
{
    return mb_strlen($a) > 30 ? true : false;
}
function isToSmall($a)
{
    return mb_strlen($a) < 2 ? true : false;
}


    // function special_login($login)
    // {
    //     return preg_match("#^[a-z0-9]+$#", $login) ? true : false;
    // }