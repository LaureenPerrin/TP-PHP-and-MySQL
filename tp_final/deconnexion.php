<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();
 
echo '<h3>Vous êtes maintenant déconnecté, à bientôt !</h3>';
