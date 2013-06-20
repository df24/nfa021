<?php
/*
 * récupération des paramètres nécessaire au backoffice :
 * sur quelle classe travaillons-nous ?
 * si il y a un identifiant en GET, on est en edit ou delete
 */
if (!array_key_exists('class', $_GET))
    throw new Exception('paramètre class manquant');

$class = ucfirst(trim($_GET['class']));

if (!preg_match('/[[:alpha:]]/i', $class))
    throw new Exception('paramètre class incorrect');

if (array_key_exists('id', $_GET))
    $id = (int) $_GET['id'];
else
    $id = null;