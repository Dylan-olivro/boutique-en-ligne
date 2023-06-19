<?php

function isSame($a, $b)
{
    return $a == $b ? true : false;
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
    return preg_match("~^[0-9]{1,4}$~", $a) ? true : false;
}

function isToBig($a)
{
    return mb_strlen($a) > 30 ? true : false;
}
function isToSmall($a)
{
    return mb_strlen($a) < 2 ? true : false;
}

function isLetter($a)
{
    return preg_match("/^\pL+([- ']\pL+)*$/u", $a) ? true : false;
}

function returnPriceHT(float $priceTTC)
{
    $tva = 20 / 100;
    $priceHT = $priceTTC / (1 + $tva);
    $roundPriceHT = number_format($priceHT, 2, '.', "");
    return (float)$roundPriceHT;
}
function returnAmountTVA(float $priceTTC, float $priceHT)
{
    $amountTVA =  $priceTTC - $priceHT;
    $roundAmountTVA = number_format($amountTVA, 2, '.', "");
    return (float)$roundAmountTVA;
}

function CoupePhrase($txt, $long = 50)
{
    if (strlen($txt) <= $long)
        return $txt;
    $txt = substr($txt, 0, $long);
    return substr($txt, 0, strrpos($txt, ' ')) . '...';
}

function isNumberWithDecimal($a)
{
    return  preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $a) ? true : false;
}
