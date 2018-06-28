<!DOCTYPE html>
    <head>  
        <meta charset="utf8"/>
        <title>Tp3_ Blog avec des commentaires</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>

        <h1>Mon dernier blog !</h1>

        <p>Derniers billets du blog :</p>


   



    <?php
// Connexion à la base de données
        try
        {
	        $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'laureenperrin', 'Gnite2932');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }

        // On récupère les 5 derniers billets
        $reponseDonneesBillets = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \' %d/%m/%Y à %Hh%imin%ss\') AS date_formated FROM billets ORDER BY  date_formated DESC LIMIT 0, 5');

        while ($listeBillets = $reponseDonneesBillets->fetch())
        {
    ?>

    <div class="news">
        <?php echo '<h3>' . htmlspecialchars($listeBillets['titre']) . ' le ' . '<em>' . htmlspecialchars($listeBillets['date_formated']) . '</em>' . '</h3>'?>
    
        <p>
            <?php echo htmlspecialchars($listeBillets['contenu']) . '</br>';?>
            <a href="commentaires.php?billet=<?php echo $listeBillets['id']; ?>"> <em>Commentaires</em></a>
        </p>

    </div>

    <?php
        } // Fin de la boucle des billets
    $reponseDonneesBillets->closeCursor();
    ?>
        

    </body>
    

</html>