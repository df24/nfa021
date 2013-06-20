<?php

include_once('header.php');

echo '<div class="center">';

echo '<section>';

$params = null;
$publisher = null;
if (array_key_exists('iduser', $_GET)) {
    // le transtypage en int protège contre les injections de string
    $params['iduser'] = (int) $_GET['iduser'];
    $sql = 'SELECT * FROM user WHERE iduser=' . $params['iduser'];
    $userRow = $db->getRow($sql);
    if (!is_null($userRow)) {
        $publisher = new User($userRow);
    }
}


$params['etat'] = 'valid';
$params['dateConsultation'] = new DateTime();
if (array_key_exists('idActuRubrique', $_GET))
    $params['idactuRubrique'] = (int) $_GET['idActuRubrique'];
$actuCollection = ActuCollection::get($db, $params);

if(count($actuCollection) == 0) {
    echo '<p>Cliquez sur "backoffice" en haut à droite</p>';
    echo 'Pas d\'actualités pour le moment.';
} else {
    echo '<p class="sectionTitre">Dernières actualités';
    if (!is_null($publisher)) {
        echo ' de ' . $publisher->getNom();
    }
    echo '</p>';
    foreach ($actuCollection as $actu) {
        echo '<article class="actu">';
        echo '<p class="actuInfos">le ' . $actu->getDateCreation()->format('d/m/Y') . ' par <a href="index.php?iduser=' . $actu->getIduser() . '">' . $actu->getUser($db)->getNom() . '</a></p>';
        echo '<p class="actuInfos">rubrique <a href="index.php?idActuRubrique=' . $actu->getRubrique($db)->getId() . '">' . $actu->getRubrique($db)->getLibelle() . '</a></p>';
        echo '<p class="actuTitre">' . Util::crop($actu->getTitre(), 120) . '</p>';
        if (!is_null($actu->getContenu())) {
            echo '<p class="actuLink"><a class="fancybox" href="/actuDetail.php?idactu=' . $actu->getIdactu() . '">en savoir plus</a>';
        }
        if (count($actu->getCommentaires($db)) != 0) {
            echo '<p class="actuLink"><a class="fancybox" href="/commentaireDetail.php?idactu=' . $actu->getIdactu() . '">lire les commentaires</a>';
        }
        if ($user instanceof User) {
            echo '<p class="actuLink"><a href="/actuCommentaire.php?class=Commentaire&idactu=' . $actu->getIdactu() . '">ajouter un commentaire</a>';
        }
        echo '</article>';
    }
}

echo '</section>';

if (!($user instanceof User)) {
    echo <<<HTML
        <aside>
            <ol>
                <li>Créez votre compte</li>
                <li>Obtenez votre URL</li>
                <li>Publiez vos actualités</li>
                <li>Partagez !!!</li>
            </ol>
            <a class="bouton" href="signin.php">Inscrivez-vous</a>
        </aside>
HTML;
}

echo '</div>';

include_once('footer.php');