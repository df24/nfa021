<?php
$path = '../';
include_once('../header.php');
include_once('auth.php');
include_once('getParams.php');

$selected = array(
    'Actu'          => null,
    'Commentaire'   => null,
    'ActuRubrique'  => null,
    'Log'           => null,
    'User'          => null
);
$selected[$class] = 'active';

$classNoAdd = array('Log', 'Commentaire', 'User');

echo '<div class="center">';

if ($user->getEmail() != 'admin@df-info.com') {
    echo <<<HTML
        <aside>
            <ul class="navigation">
                <li class="{$selected['Actu']}"><a href="list.php?class=Actu">Gérer les actus</a></li>
                <li class="{$selected['Commentaire']}"><a href="list.php?class=Commentaire">Gérer les commentaires</a></li>
                <li class="{$selected['ActuRubrique']}"><a href="list.php?class=ActuRubrique">Gérer les rubriques</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </aside>
HTML;
} else {
    echo <<<HTML
        <aside>
            <ul class="navigation">
                <li class="{$selected['Log']}"><a href="list.php?class=Log">Voir les logs</a></li>
                <li class="{$selected['User']}"><a href="list.php?class=User">Gérer les utilisateurs</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </aside>
HTML;
}

echo '<section>';

$className = $class . 'Collection';

$collection = $className::get($db, array('iduser' => $user->getIdUser()));

if (!in_array($class, $classNoAdd))
    echo '<a class="bouton" href="row.php?class=' . $class . '">' . $className::TXT_ADD . '</a>';

if (count($collection) != 0) {

    echo '<table>';

    echo '<tr>';
    echo $className::HTML_ENTETE;
    if ($user->getEmail() != 'admin@df-info.com') {
        echo '<td></td><td></td>';
    }
    echo '</tr>';

    foreach ($collection as $object) {
        echo '<tr>';
        echo $object->toHtmlTd($db);
        if ($user->getEmail() != 'admin@df-info.com') {
            echo '<td><a href="row.php?class=' . $class . '&id=' . $object->getId() . '"><img src="../img/edit.png"></a></td><td><a href="del.php?class=' . $class . '&id=' . $object->getId() . '"><img class="btnDel" src="../img/del.png"></a></td>';
        }
        echo '</tr>';
    }

    echo '</table>';

} else {

    echo '<p>Pas de ' . $class . ' pour l\'instant</p>';

}

echo '</section>';

echo '</div>';

include_once('../footer.php');