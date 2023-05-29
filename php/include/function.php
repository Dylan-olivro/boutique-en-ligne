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

function special_login($login)
{
    return preg_match("#^[a-z0-9]+$#", $login) ? true : false;
}
