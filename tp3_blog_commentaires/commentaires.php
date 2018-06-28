<!DOCTYPE html>
    <head>  
        <meta charset="utf8"/>
        <title>Tp3_ Blog avec des commentaires</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>

        <h1>Mon dernier blog !</h1>

        <p><a href="index.php">Retour à la liste des billets</a></p>
    
    <?php

    
        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'laureenperrin', 'Gnite2932');
    
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }


        $billetRecupere = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \' %d/%m/%Y à %Hh%imin%ss\') AS date_formated FROM billets WHERE ID=?');
        $billetRecupere->execute(array($_GET['billet']));
        $billet = $billetRecupere->fetch();
        
    ?>

    <div class="news">
        <?php echo '<h3>' . htmlspecialchars($billet['titre']) . ' le ' . '<em>' . htmlspecialchars($billet['date_formated']) . '</em>' . '</h3>'?>
    
        <p>
            <?php echo htmlspecialchars($billet['contenu']) . '</br>';?>
        </p>

    </div>

    <?php
        
    $billetRecupere->closeCursor();
    ?>

    <h2>Commentaires</h2>

    <?php
    
        $commentaireRecupere = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_formated FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');
        $commentaireRecupere->execute(array($_GET['billet']));

    while ($commentaires = $commentaireRecupere->fetch())
    {
    ?>
    
    <p>
        <?php echo '<strong>' . htmlspecialchars($commentaires['auteur']) . '</strong>' . ' le ' . $commentaires['date_commentaire_formated'] . '</br>' . htmlspecialchars($commentaires['commentaire']); ?>
    </p>

   
    <?php
    } 
        $commentaireRecupere->closeCursor();
    ?>
        

    </body>
    

</html>