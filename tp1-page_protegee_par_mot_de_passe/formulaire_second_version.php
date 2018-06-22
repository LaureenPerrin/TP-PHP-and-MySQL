<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Premier tp php - page protégée par mot de passe</title>
    </head>
    
    <body>
        
        <?php
        $passwordNasa = $_POST['passwordNasa'];
        
        if (!isset($passwordNasa))
        {
        echo '<form action="formulaire_second_version.php" method="post">
            <p>
                <label>Saisissez le mot de passe s\'il vous plaît :<input type="password" name="passwordNasa"/></label>
                <input type="submit" value="Valider"/>
            </p>
        </form>';
        }
        else if (isset($passwordNasa) AND $passwordNasa != "kangourou")
        {
            echo '<p>Mot de passe incorrect, veuillez recommencer !</p>';
        }
        else 
        {
            echo '<p>Voici la liste des codes d\'accès au serveur central :</p>' . 
            "<ul> <li>026598967485</li><li>365898478596</li><li>025698478593</li><li>641285798651</li></ul>";
        }

        ?>
    </body>  

</html>