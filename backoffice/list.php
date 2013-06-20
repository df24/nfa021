<?php
$path = '../';
include_once('../header.php');
include_once('auth.php');
include_once('getParams.php');

$selected = array(
    'Actu' => null,
    'Commentaire' => null,
    'ActuRubrique' => null
);
$selected[$class] = 'active';

echo '<div class="center">';

echo <<<HTML
    <aside>
        <ul>
            <li class="{$selected['Actu']}"><a href="list.php?class=Actu">Gérer les actus</a></li>
            <li class="{$selected['Commentaire']}"><a href="list.php?class=Commentaire">Gérer les commentaires</a></li>
            <li class="{$selected['ActuRubrique']}"><a href="list.php?class=ActuRubrique">Gérer les rubriques</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </aside>
HTML;

echo '<section>';

$className = $class . 'Collection';

$collection = $className::get($db, array('iduser' => $user->getIdUser()));

echo '<a class="bouton" href="row.php?class=' . $class . '">' . $className::TXT_ADD . '</a>';

if (count($collection) != 0) {

    echo '<table>';

    echo '<tr>';
    echo $className::HTML_ENTETE;
    echo '<td></td><td></td>';
    echo '</tr>';

    foreach ($collection as $object) {
        echo '<tr>';
        echo $object->toHtmlTd($db);
        echo '<td><a href="row.php?class=' . $class . '&id=' . $object->getId() . '"><img src="../img/edit.png"></a></td><td><a href="del.php?class=' . $class . '&id=' . $object->getId() . '"><img class="btnDel" src="../img/del.png"></a></td>';
        echo '</tr>';
    }

    echo '</table>';

} else {

    echo '<p>Pas de ' . $class . ' pour l\'instant</p>';

}

echo '</section>';

echo '</div>';

include_once('../footer.php');