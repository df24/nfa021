<?php
$path = '../';
include_once('../header.php');
include_once('auth.php');
include_once('getParams.php');

echo '<div class="center">';

echo '<section>';

$className = $class . 'Collection';

$collection = $className::get($db, array('iduser' => $user->getIdUser()));

if (count($collection) != 0) {

    echo '<table>';
    foreach ($collection as $object) {
        echo $object->toHtmlTd();
    }
    echo '</table>';

} else {

    echo '<p>Pas de ' . $class . ' pour l\'instant</p>';

}

echo '</section>';


echo <<<HTML
    <aside>
        <ul>
            <li>Gérer les actus</li>
            <li>Gérer les commentaires</li>
            <li>Gérer les rubriques</li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
        Menu ajouter actu / gestion des rubriques
    </aside>
HTML;


echo '</div>';

include_once('../footer.php');