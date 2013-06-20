<?php
ob_start();
$path = '../';
include_once('../header.php');
include_once('auth.php');
include_once('getParams.php');

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
var_dump($row);
exit;
            $row->save($db);

            header('Location: list.php?class=' . $class);
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