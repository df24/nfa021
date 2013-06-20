<?php
ob_start();
$path = null;
include_once('header.php');
include_once('backoffice/auth.php');
include_once('backoffice/getParams.php');
if (array_key_exists('idactu', $_GET))
    $idactu = (int) $_GET['idactu'];
else
    throw new Exception('paramètre idActu manquant');

echo '<div class="center">';

echo '<section>';

    $className = 'Form' . $class;

    include_once($path . 'classes/' .$className . '.php');
    $form = new $className($db, $id);

    if (!empty($_POST)) {

        if ($form->isValid($_POST)) {

            $row = new $class($form->filter($db, $_POST));
            if (!is_null($id))
                $row->setId($id);

            $row->setIdUser($user->getIdUser());
            $row->setIdActu($idactu);
//var_dump($row);
//exit;
            $row->save($db);

            LogCollection::write($db, $user, $form->getType() . ' ' . $class);

            header('Location: index.php');
            exit;

        } else {

            $form->populate($_POST);

        }

    } else {

        if (!is_null($id)) {

            $mapperClassName = $class . 'Collection';
            $row = $mapperClassName::getRow($db, $id);
            $form->populate($row);

        }

    }

    echo '<p class="sectionTitre">';
    echo $form->getTitre();
    echo '</p>';
    echo $form->getForm();

echo '</section>';

echo '</div>';

include_once($path . 'footer.php');
ob_end_flush();