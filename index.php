<?php
/*
 * front controller, initialisation de l'application
 * routage
 * instanciation des objets
 * vues
 */

/*
 * environnement de développement
 */
if (getenv('APPLICATION_ENV') == 'devubuntu' || getenv('APPLICATION_ENV') == 'development') {

    ini_set('display_errors', 'on');
    include_once('Zend/Debug.php');

}

/*
 * analyse de la requête
 */
Zend_Debug::dump($_GET);
Zend_Debug::dump($_POST);
Zend_Debug::dump($_REQUEST);
exit;
