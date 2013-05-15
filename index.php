<?php

include_once('header.php');

echo '<section>';

$params = null;
if (array_key_exists('iduser', $_GET)) {
    // le transtypage en int protège contre les injections de string
    $params['iduser'] = (int) substr($_GET['iduser'], 1);
}
/*
 * récupération des actus, filtre sur l'utilisateur si iduser dans la requête
 */
$actuCollection = ActuCollection::get($db, $params);

if(count($actuCollection) == 0) {
    echo 'Pas d\'actualités pour le moment.';
} else {
    echo '<p class="sectionTitre">Dernières actualités</p>';
    foreach ($actuCollection as $actu) {
        echo '<article class="actu">';
        echo '<p class="actuTitre">' . $actu->getTitre() . '</p>';
        if (!is_null($actu->getAccroche())) {
            echo '<p class="actuAccroche">' . $actu->getAccroche() . '</p>';
        }
        echo '<p class="actuInfos">le ' . $actu->getDateCreation()->format('d/m/Y') . ' par ' . $actu->getUser($db)->getNom() . '</p>';
        echo '</article>';
    }
}

echo '</section>';

echo <<<HTML
    <aside>
        <div id="cadre">
        <ol>
            <li>Créez votre compte utilisateur</li>
            <li>Obtenez votre URL</li>
            <li>Publiez vos actualités</li>
            <li>Partagez !!!</li>
        </ol>
        <a class="bouton">Inscrivez-vous</a>
        </div>
    </aside>
HTML;

include_once('footer.php');