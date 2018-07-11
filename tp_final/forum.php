<?php session_start();
?>
<!DOCTYPE HTML>

<head>
    <meta charset="utf8" />
    <title>tp final cour php et mysql</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

    <h1>Le Forum</h1>
    <?php 
       if (isset($_SESSION['pseudo'])) {
           echo '<p>Bonjour ' . $_SESSION['pseudo'] . ' !</p>' . '</br>' . '<p>N\'hésitez pas à laisser de nouveaux commentaires !</p>';
       } else {
           echo 'Bonjour !' .
           '<p>Vous êtes ici pour laisser vos commentaires qui me permettrons de devenir plus performante et meilleure dans mon futur
        métier donc merci de me donner de votre temps et de vos conseils.</p>';
       }

    ?>



    <div class="formulaire">
        <form action="forum.php" method="post">
            <label>Ajouter un commentaire :
                <input type="textarea" name="message" />
            </label>
            <input type="submit" value="Ajouter" />
        </form>
    </div>
    <form action="deconnexion.php" methode="post">
        <input id="deconnexion" type="submit" value="Déconnexion" />
    </form>
    <?php 

    if (isset($_POST['message'])) {

        
    // Connexion à la base de données
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=commentaires;charset=utf8', 'laureenperrin', 'Gnite2932', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            die('Erreur : ' .$e -> getMessage());
        }
        //déclaration variable utilisées :
        $message = htmlspecialchars($_POST['message']);

        $messageReq = $bdd->prepare('INSERT INTO commentaires(pseudo, commentaire, date_commentaire) VALUES(?, ?, CURDATE())');
        $messageReq->execute(array($_SESSION['pseudo'], $message));
        $messageReq->closeCursor();

        $messageForum = $bdd->query('SELECT pseudo, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y\') AS date_formated FROM commentaires');
        while ($messageAffiche = $messageForum->fetch()) {
            echo '<h3>' . $messageAffiche['pseudo'] . ' le ' . '<em>' . $messageAffiche['date_formated'] . '</em>' . ' :' . '</h3>'. '<p>' . htmlspecialchars($messageAffiche['commentaire']) . '</p>' .'</br>';
        }
        $messageForum->closeCursor();
    }
        
        
    ?>

</body>

</html>