<?php
// Effectuer ici la requête qui insère le message
//Déclarer les variables utilisées et les sécuriser contre faille xss :
        try
{
    $bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'laureenperrin', 'Gnite2932');
    
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


$reqInfoChat = $bdd->prepare('INSERT INTO minichat(pseudo, message) VALUES(?, ?)');
$reqInfoChat->execute(array($_POST['pseudo'], $_POST['message']));

$reqInfoChat->closeCursor(); // Termine le traitement de la requête

// Puis rediriger vers minichat.php comme ceci :
header('Location: minichat.php');
?>