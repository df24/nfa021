<?php
include_once('../classes/User.php');
include_once('../classes/Log.php');
include_once('../classes/LogCollection.php');
include_once('../classes/Db.php');
$db = new Db();
session_start();
if (isset($_SESSION['user']))
    $user = $_SESSION['user'];
LogCollection::write($db, $user, 'logout');

foreach ($_SESSION as $key => $value)
    unset($_SESSION);
session_destroy();
header('Location: ../index.php');
exit;