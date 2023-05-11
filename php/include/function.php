<?php
function login($login)
{
    if (!empty($login)) {
        return true;
    } else {
        echo 'Champ Login vide';
    }
}
function email($email)
{
    if (!empty($email)) {
        return true;
    } else {
        echo 'Champ Email vide';
    }
}
function password($password)
{
    if (!empty($password)) {
        return true;
    } else {
        echo 'Champ Password vide';
    }
}
function confirm_password($confim_password)
{
    if (!empty($confim_password)) {
        return true;
    } else {
        echo 'Champ Confirm password vide';
    }
}
function firstname($firstname)
{
    if (!empty($firstname)) {
        return true;
    } else {
        echo 'champ firstname vide';
    }
}
function lastname($lastname)
{
    if (!empty($lastname)) {
        return true;
    } else {
        echo 'champ lastname vide';
    }
}
function same_password($password, $confim_password)
{
    if ($password == $confim_password) {
        return true;
    } else {
        echo 'password differents';
    }
}
function special_login($login)
{
    if (preg_match("#^[a-z0-9]+$#", $login)) {
        return true;
    } else {
        echo 'caracteres speciaux';
    }
}
