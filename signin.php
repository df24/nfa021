<?php

include_once('header.php');

echo '<div class="center">';

echo '<section>';

if ($user instanceof User) {
    echo 'vous êtes déjà enregistré !';
} else {

    $data = array(
        'nom' => null,
        'email' => null,
        'pwd' => null
    );

    $error = array();

    if (!empty($_POST)) {
        /*
         * contrôle des données saisies
         */
        if ($_POST['nom'] != '') {
            if (!preg_match('/^[[:alpha:]]+$/', $_POST['nom'])) {
                $error['nom'] = 'Format incorrect pour le nom';
            }
            $data['nom'] = mysqli_real_escape_string($db->getLink(), $_POST['nom']);
        } else {
            $error['nom'] = 'Veuillez saisir votre nom';
        }

        if ($_POST['email'] != '') {
            // pattern trouvé sur developpez.com
            if (!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $_POST['email'])) {
                $error['email'] = 'Format incorrect pour le mail';
            }
            $data['email'] = mysqli_real_escape_string($db->getLink(), $_POST['email']);
        } else {
            $error['email'] = 'Veuillez saisir votre email';
        }

        if ($_POST['pwd'] != '') {
            if (!preg_match('/^[[:alnum:]]{4,6}$/', $_POST['pwd'])) {
                $error['pwd'] = 'Mot de passe : de 4 à 6 caractères alphanumériques';
            }
            $data['pwd'] = mysqli_real_escape_string($db->getLink(), $_POST['pwd']);
        } else {
            $error['pwd'] = 'Veuillez saisir votre mot de passe';
        }

        if (count($error) == 0) {
            $user = new User($data);
            $result = $user->save($db);
            if (is_array($result)) {
                if (array_key_exists(1062, $result))
                    echo '<p class="error">ERREUR : un compte existe déjà pour cette adresse email : ' . $data['email'];
                else
                    echo '<p class="error">ERREUR MYSQL CODE(S) : ' . implode(', ', array_keys ($result)) . '</p>';
            } else {
                $user->setIduser($result);
                $send = $user->sendConfirmationEmail();
                if ($send === true) {
                    echo '<p>Votre inscription a bien été prise en compte.</p><p>Afin d\'accéder à nos services, vous devez valider cette inscription en cliquant sur le lien qui vous a été envoyé à : '
                    . $data['email'] . '.</p><p>Vous pourrez ensuite publier vos actus en cliquant sur "connexion".</p><p>Merci</p>';
                } else {
                    echo '<p class="errro">' . $send . '</p>';
                }
            }
        }

    }

    if (!$user instanceof User) {
    echo <<<HTML
    <p>Créez votre compte en remplissant le formulaire ci-dessous.</p>
    <p>Vous recevrez un email vous permettant de valider votre inscription.</p>
            <form method="POST" id="signin">
                <label for="nom">votre nom</label>
                <input name="nom" type="text" value="{$data['nom']}">
HTML;
    if (array_key_exists('nom', $error)) {
        echo '<span class="error">' . $error['nom'] . '</span>';
    }
    echo <<<HTML
            <br>
                <label for="email">votre email</label>
                <input name="email" type="text" value="{$data['email']}">
HTML;
    if (array_key_exists('email', $error)) {
        echo '<span class="error">' . $error['email'] . '</span>';
    }
    echo <<<HTML
            <br>
                <label for="pwd">votre mot de passe</label>
                <input name="pwd" type="password">
HTML;
    if (array_key_exists('pwd', $error)) {
        echo '<span class="error">' . $error['pwd'] . '</span>';
    }
    echo <<<HTML
            <br>
                <input class="bouton" type="submit" value="ENREGISTRER">
            </form>
HTML;

    }

}

echo '</section>';

echo '</div>';

include_once('footer.php');