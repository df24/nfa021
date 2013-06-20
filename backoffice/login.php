<?php
$path = '../';
include_once('../header.php');

echo '<div class="center">';

echo '<section>';

if (!$user instanceof User) {

    if (!empty($_POST) && $_POST['login'] != '' && $_POST['pwd'] != '') {

        $login = mysqli_real_escape_string($db->getLink(), $_POST['login']);
        $pwd   = mysqli_real_escape_string($db->getLink(), $_POST['pwd']);

        // connexion
        $sql = 'SELECT iduser, nom, email, actif FROM user WHERE email=\'' . $login . '\' AND pwd=\'' . $pwd . '\' AND actif=\'oui\'';
        $userRow = $db->getRow($sql);
        if (!is_null($userRow)) {
            
            $user = new User($userRow);
            $_SESSION['user'] = $user;

            header('Location: /');
            exit;

        } else {
            echo '<p>Authentification échouée ou compte désactivé</p>';
        }

    } else {

        echo <<<HTML
        <p>Connectez-vous pour publier vos actus :</p>
        <form method="POST" id="login">
            <label for="login">Nom d'utilisateur</label>
            <input name="login" type="text">
        <br>
            <label for="pwd">Mot de passe</label>
            <input name="pwd" type="password">
        <br>
            <input class="bouton" type="submit" value="CONNEXION">
        </form>
HTML;

    }

} else {

    echo 'Déjà connecté !';

}

echo '</section>';

echo '</div>';

include_once('../footer.php');