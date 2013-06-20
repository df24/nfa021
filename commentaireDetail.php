<style>
    .titre {
        font-size:0.9em;
        font-style: italic;
    }
    td, th {
        font-size: 0.8em;
        vertical-align: top;
        padding:10px;
    }
    th {
        background-color: #f1fec5;
    }
</style>
<?php
include_once('classes/Db.php');
include_once('classes/Util.php');
include_once('classes/User.php');
include_once('classes/Actu.php');
include_once('classes/ActuCollection.php');
include_once('classes/Commentaire.php');
include_once('classes/CommentaireCollection.php');
$db = new Db();

$erreur = false;

if (array_key_exists('idactu', $_GET)) {
    $id = (int) $_GET['idactu'];
    $actu = ActuCollection::getActu($db, $id);
    echo '<p class="titre">ACTU : ' . Util::crop($actu->getTitre(), 140) . '</p>';
    echo '<table>';
    echo '<tr><th>date</th><th>commentaire</th><th>utilisateur</th></tr>';
    foreach ($actu->getCommentaires($db) as $commentaire) {
        echo '<tr>' . $commentaire->toHtmlTdSimple($db) . '</td>';
    }
    echo '</table>';
} else {
    $erreur = true;
}

if ($erreur) {
    echo 'ERREUR';
}