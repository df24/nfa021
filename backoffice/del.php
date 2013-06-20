<?php
$path = '../';
include_once('../header.php');
include_once('auth.php');
include_once('getParams.php');

if (!is_null($id)) {

    $className = $class . 'Collection';
    include_once($path . 'classes/' . $className . '.php');
    $className::del($db, $id);
    LogCollection::write($db, $user, 'suppression ' . $class);

}

header('Location: list.php?class=' . $class);
exit;