<?php
        
        ?>

<!DOCTYPE html>
    <head>  
        <meta charset="utf8"/>
        <title>Tp2_minichat</title>

    </head>

    <body>

        <form action="minichat_post.php" method="post">
            <p><label>Pseudo : <input type="text" name="pseudo" required="required"/></label></p>
            <p><label>Message : <input type="textarea" name="message" required=required/></p>
            <input type="submit" value="Envoyer"/>
        </form>
    
    <?php
        try
{
    $bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'laureenperrin', 'Gnite2932');
    
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


$reponseContenuChat = $bdd->query('SELECT pseudo, message FROM minichat ORDER BY ID DESC LIMIT 0, 10');

while ($messagesAffiches = $reponseContenuChat->fetch())
{
    echo '<p><strong>' . htmlspecialchars($messagesAffiches['pseudo']) . '</strong> : ' . htmlspecialchars($messagesAffiches['message']) . '</p>';
}

$reponseContenuChat->closeCursor();



?>
        

    </body>
    

</html>