<?php
include_once('../classes/User.php');
include_once('../classes/Db.php');
$db = new Db();

/*
 * analyse session php
 */
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    $user = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" media="all" href="../css/styles.css" />
  <link href="http://fonts.googleapis.com/css?family=Open+Sans" media="all" rel="stylesheet" type="text/css" >
  <meta charset="UTF-8">
  <title>Publiez vos actus !</title>
</head>
<body>
    <header>
        <?php
            if ($user instanceof User) {
                echo 'INTERFACE D\'ADMINISTRATION - ' . $user->getNom() . ' - <a href="logout.php">logout</a>';
            } else {
                header('Location: dommage.html');
                exit;
            }
        ?>
    </header>
    <div id="main">