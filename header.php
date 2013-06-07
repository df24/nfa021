<?php
include_once('classes/Util.php');
include_once('classes/Db.php');
include_once('classes/User.php');
include_once('classes/Actu.php');
include_once('classes/ActuCollection.php');
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
  <link rel="stylesheet" media="all" href="css/styles.css" />
  <link rel="stylesheet" media="all" href="css/form.css" />
  <link href="http://fonts.googleapis.com/css?family=Open+Sans" media="all" rel="stylesheet" type="text/css" >
  <meta charset="UTF-8">
  <title>Publiez vos actus !</title>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <link rel="stylesheet" href="/fancybox/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
  <script type="text/javascript" src="/fancybox/jquery.fancybox.pack.js?v=2.1.4"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox({
                type:'ajax'
            });
        });
    </script>
</head>
<body>
    <header>
        <div class="center">
        <?php
            if ($user instanceof User) {
                echo $user->getName() . ' - <a href="backoffice/back_actu_list.php">admin</a>';
            } else {
                echo '<div id="logo"><a href="/">PUBLIEZ VOS ACTUS</a></div>';
                echo '<div id="links"><a href="signin.php">inscription</a> - <a href="backoffice/login.php">connexion</a></div>';
            }
        ?>
        </div>
    </header>