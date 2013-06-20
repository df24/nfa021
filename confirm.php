<?php
if (!array_key_exists('idUser', $_GET))
    header("Location: error.phtml");

include_once('classes/User.php');
include_once('classes/Db.php');
$db = new Db();

$idUser = (int) $_GET['idUser'];

$sql = "UPDATE user SET actif='oui' WHERE iduser=" . $idUser;
$result = $db->query($sql);

$id = mysqli_insert_id($db->getLink());
$sql = "INSERT INTO actuRubrique (libelle, iduser) VALUES('mes actus', '$idUser')";
$result = $db->query($sql);

if (!is_array($result))
    header("Location: backoffice/login.php");
else {

    include_once('header.php');

    echo '<div class="center">';

    echo '<section>';
    echo '<p class="error">Validation impossible</p>';
    echo '<p class="error">ERREUR MYSQL CODE(S) : ' . implode(', ', array_keys ($result)) . '</p>';
    echo '<p class="error">' .$sql . '</p>';

    echo '</section>';

    echo '</div>';

    include_once('footer.php');

}