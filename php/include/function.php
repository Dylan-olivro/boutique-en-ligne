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
function ajout($select)
{
    array_push($_SESSION['panier']['id_article'], $select['id']);
    array_push($_SESSION['panier']['qte'], $select['qte']);
    array_push($_SESSION['panier']['prix'], $select['prix']);
}

// Permet de modifier la quantité d'un produit dans le panier pour les utilisateurs qui ne sont pas connecté
function modif_qte($ref_article, $op)
{
    /* On compte le nombre d'articles différents dans le panier */
    $nb_articles = count($_SESSION['panier']['id_article']);
    /* On initialise la variable de retour */
    $update = false;
    /* On parcoure le tableau de session pour modifier l'article précis. */
    for ($i = 0; $i < $nb_articles; $i++) {
        if ($ref_article == $_SESSION['panier']['id_article'][$i]) {
            if ($op == '+') {
                $_SESSION['panier']['qte'][$i] = $_SESSION['panier']['qte'][$i] + 1;
                $update = true;
            } elseif ($op == '-') {
                $_SESSION['panier']['qte'][$i] = $_SESSION['panier']['qte'][$i] - 1;
                $update = true;
            }
        }
    }
    return $update;
}
// Permet de supprimé un produit dans le panier pour les utilisateurs qui ne sont pas connecté
function supprim_article($ref_article, $reindex = true)
{
    $suppression = false;
    $aCleSuppr = array_keys($_SESSION['panier']['id_article'], $ref_article);

    /* sortie la clé a été trouvée */
    if (!empty($aCleSuppr)) {
        /* on traverse le panier pour supprimer ce qui doit l'être */
        foreach ($_SESSION['panier'] as $k => $v) {
            foreach ($aCleSuppr as $v1) {
                unset($_SESSION['panier'][$k][$v1]);    // remplace la ligne foireuse
            }
            /* si la réindexation est indispensable pour la suite de l'appli, faire ici: */
            if ($reindex == true) {
                $_SESSION['panier'][$k] = array_values($_SESSION['panier'][$k]);
            }
            $suppression = true;
        }
    } else {
        $suppression = "absent";
    }
    return $suppression;
}
// Permet de récupérer le montant total du panier pour les utilisateurs qui ne sont pas connecté
function montant_panier()
{
    /* On initialise le montant */
    $montant = 0;
    /* Comptage des articles du panier */
    $nb_articles = count($_SESSION['panier']['id_article']);
    /* On va calculer le total par article */
    for($i = 0; $i < $nb_articles; $i++)
    {
        $montant += $_SESSION['panier']['qte'][$i] * $_SESSION['panier']['prix'][$i];
    }
    /* On retourne le résultat */
    return $montant;
}