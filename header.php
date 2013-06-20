<?php
if (!isset($path))
    $path = null;

include_once($path . 'classes/Util.php');
include_once($path . 'classes/Db.php');
include_once($path . 'classes/User.php');
include_once($path . 'classes/UserCollection.php');
include_once($path . 'classes/Actu.php');
include_once($path . 'classes/ActuCollection.php');
include_once($path . 'classes/ActuRubrique.php');
include_once($path . 'classes/ActuRubriqueCollection.php');
include_once($path . 'classes/Commentaire.php');
include_once($path . 'classes/CommentaireCollection.php');
include_once($path . 'classes/Log.php');
include_once($path . 'classes/LogCollection.php');
$db = new Db();
/*
 * analyse session php
 */
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    if ($user->getEmail() == 'admin@df-info.com')
        $defaultClass = 'Log';
    else
        $defaultClass = 'Actu';
} else {
    $user = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" media="all" href="<?php echo $path; ?>css/styles.css" />
  <link rel="stylesheet" media="all" href="<?php echo $path; ?>css/form.css" />
  <?php
  if (isset($path)) {
      echo '<link rel="stylesheet" media="all" href="' . $path . 'css/backoffice.css" />';
  }
  ?>
  <link href="http://fonts.googleapis.com/css?family=Open+Sans" media="all" rel="stylesheet" type="text/css" >
  <meta charset="UTF-8">
  <title>Publiez vos actus !</title>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  <link rel="stylesheet" href="<?php echo $path; ?>/fancybox/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
  <script type="text/javascript" src="<?php echo $path; ?>/fancybox/jquery.fancybox.pack.js?v=2.1.4"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox({
                type:'ajax'
            });
            $('.btnDel').on('click', function(){
                if (!confirm('Supprimer ?')) {
                    return false;
                }

            });
        });
    </script>
</head>
<body>
    <header>
        <div class="center">
        <?php
            if ($user instanceof User) {
                echo '<div id="logo"><a href="' . $path . '/">PUBLIEZ VOS ACTUS</a></div>';
                echo '<div id="links">' . $user->getNom() . ' - <a href="' . $path . 'backoffice/list.php?class=' . $defaultClass . '">backoffice</a></div>';
            } else {
                echo '<div id="logo"><a href="' . $path . '/">PUBLIEZ VOS ACTUS</a></div>';
                echo '<div id="links"><a href="' . $path . 'signin.php">inscription</a> - <a href="' . $path . 'backoffice/login.php">connexion</a></div>';
            }
        ?>
        </div>
    </header>