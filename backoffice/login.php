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
        <a href="../inscription.php">inscription</a> - <a href="login.php">connexion</a>
    </header>
    <div id="main">
<?php
include_once('../classes/User.php');
include_once('../classes/Db.php');
$db = new Db();
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    $user = false;
}

if (!$user) {

    if (!empty($_POST) && $_POST['login'] != '' && $_POST['pwd'] != '') {

        $login = mysql_real_escape_string($_POST['login']);
        $pwd   = mysql_real_escape_string($_POST['pwd']);

        // connexion
        $sql = 'SELECT nom, email, actif FROM user WHERE email=\'' . $login . '\' AND pwd=\'' . $pwd . '\' AND actif=\'oui\'';
        $userRow = $db->getRow($sql);
        if (!is_null($userRow)) {

            $user = new User($userRow);
            $_SESSION['user'] = $user;

            header('Location: back_actu_list.php');
            exit;

        } else {
            echo '<p>Authentification échouée ou compte désactivé</p>';
        }

    } else {

        echo <<<HTML
        <form method="POST" id="login">
            <label for="login">Nom d'utilisateur</label>
            <input name="login" type="text">
        <br>
            <label for="pwd">Mot de passe</label>
            <input name="pwd" type="password">
        <br>
            <input type="submit" value="CONNEXION">
        </form>
HTML;

    }

} else {

    echo 'Déjà connecté !';

}

include_once('../footer.php');