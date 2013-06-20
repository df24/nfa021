<?php
include_once('classes/Db.php');
include_once('classes/User.php');
include_once('classes/Actu.php');
include_once('classes/Util.php');
$db = new Db();

$erreur = false;

if (array_key_exists('idactu', $_GET)) {
    $id = (int) $_GET['idactu'];
    $sql = 'SELECT * from actu WHERE idactu=' . $id;
    $row = $db->getRow($sql);
    if (!is_null($row)) {
        $actu = new Actu($row);

        echo '<p class="actuInfos">le ' . $actu->getDateCreation()->format('d/m/Y') . ' par <a href="' . $actu->getIduser() . '">' . $actu->getUser($db)->getNom() . '</a></p>';
        echo '<p style="width:650px;">' . $actu->getContenu() . '</p>';

    } else {
        $erreur = true;
    }
} else {
    $erreur = true;
}

if ($erreur) {
    echo 'ERREUR';
}