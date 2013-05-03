<?php
include ('classes/User.php');

/*
 * environnement de développement
 */
if (getenv('APPLICATION_ENV') == 'devubuntu' || getenv('APPLICATION_ENV') == 'development') {
    ini_set('display_errors', 'on');
    include_once('Zend/Debug.php');
}

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
  <link rel="stylesheet" media="all" href="css/styles.css" />
  <link href="http://fonts.googleapis.com/css?family=Open+Sans" media="all" rel="stylesheet" type="text/css" >
  <meta charset="UTF-8">
  <title>Publiez vos actus !</title>
</head>
<body>
    <header>
        <?php
            if ($user instanceof User) {
                echo $user->getName() . ' - <a href="backoffice/back_actu_list.php">admin</a>';
            } else {
                echo '<a href="inscription.php">inscription</a> - <a href="backoffice/login.php">connexion</a>';
            }
        ?>
    </header>
    <div id="main">