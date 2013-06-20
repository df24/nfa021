<?php
ob_start();
$path = '../';
include_once('../header.php');
include_once('auth.php');

$idUserToChange = (int) $_GET['iduser'];
$userToChange = UserCollection::getUser($db, $idUserToChange);

if ($_GET['actif'] == 'oui')
    $userToChange->setActif('oui');
else
    $userToChange->setActif('non');

//var_dump($userToChange); exit;

$userToChange->save($db);

header('Location: list.php?class=User');
ob_end_flush();