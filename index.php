<?php

include_once('header.php');

echo '<div class="center">';

echo '<section>';

$params = null;
$user = null;
if (array_key_exists('iduser', $_GET)) {
    // le transtypage en int protège contre les injections de string
    $params['iduser'] = (int) substr($_GET['iduser'], 1);
    $sql = 'SELECT * FROM user WHERE iduser=' . $params['iduser'];
    $userRow = $db->getRow($sql);
    if (!is_null($userRow)) {
        $user = new User($userRow);
    }
}
/*
 * récupération des actus, filtre sur l'utilisateur si iduser dans la requête
 */
$actuCollection = ActuCollection::get($db, $params);

if(count($actuCollection) == 0) {
    echo 'Pas d\'actualités pour le moment.';
} else {
    echo '<p class="sectionTitre">Dernières actualités';
    if (!is_null($user)) {
        echo ' de ' . $user->getNom();
    }
    echo '</p>';
    foreach ($actuCollection as $actu) {
        echo '<article class="actu">';
        echo '<p class="actuInfos">le ' . $actu->getDateCreation()->format('d/m/Y') . ' par <a href="' . $actu->getIduser() . '">' . $actu->getUser($db)->getNom() . '</a></p>';
        echo '<p class="actuTitre">' . Util::crop($actu->getTitre(), 120) . '</p>';
        if (!is_null($actu->getContenu())) {
            echo '<p class="actuLink"><a class="fancybox" href="/actuDetail.php?idactu=' . $actu->getIdactu() . '">en savoir plus</a>';
        }
        echo '</article>';
    }
}

echo '</section>';

echo <<<HTML
    <aside>
        <ol>
            <li>Créez votre compte</li>
            <li>Obtenez votre URL</li>
            <li>Publiez vos actualités</li>
            <li>Partagez !!!</li>
        </ol>
        <a class="bouton">Inscrivez-vous</a>
    </aside>
HTML;

echo '</div>';

include_once('footer.php');