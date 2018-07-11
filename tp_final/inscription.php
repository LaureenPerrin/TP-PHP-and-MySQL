<?php 
session_start();

?>
<!DOCTYPE HTML>

<head>
    <meta charset="utf8" />
    <title>tp final cour php et mysql</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

    <h1>Bienvenue sur mon premier forum avec ses espaces membres !</h1>

    <p>Je vous invite à vous inscrire pour commencer à poster des commentaires sur le seul sujet créé pour le moment, mon travail,
        afin de me donner votre avis.</p>

    <div class="formulaire">
        <form action="inscription.php" method="post">
            <label for="pseudo"> Pseudo :
                <input type="text" name="pseudo" id="pseudo" required="required" />
            </label>
            <label for="password1"> Mot de passe :
                <input type="password" name="pass" id="password1" required="required" />
            </label>
            <label for="password2"> Retapez le mot de passe :
                <input type="password" name="pass2" id="password2" required="required" />
            </label>
            <label for="email"> Adresse email :
                <input type="email" name="email" id="email" required="required" />
            </label>
            <input type="submit" value="S'inscrire" id="bouton" />
        </form>
    </div>

    <?php 
 
 if (isset($_POST['pseudo']) and isset($_POST['pass']) and isset($_POST['pass2']) and isset($_POST['email'])) {
     session_destroy();
     // Connexion à la base de données
     try {
         $bdd = new PDO('mysql:host=localhost;dbname=membres;charset=utf8', 'laureenperrin', 'Gnite2932', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     } catch (Exception $e) {
         die('Erreur : ' .$e -> getMessage());
     }
 
     //décaration variables récupérées avec formulaire :
     $pseudoRenseigne = htmlspecialchars($_POST['pseudo']);
     
     
     $pass_hache = htmlspecialchars($_POST['pass']);
     $pass_hache2 = htmlspecialchars($_POST['pass2']);
     $email = htmlspecialchars($_POST['email']);
 
     //Récupération pseudo renseigné dans bdd si il existe :
     $donneePseudos = $bdd->query("SELECT * FROM membres WHERE pseudo='". $pseudoRenseigne ."'");
     $pseudoBdd= $donneePseudos->fetch();
 
     
     if ($pseudoRenseigne != $pseudoBdd['pseudo']) {
         if ($pass_hache == $pass_hache2) {
             if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)) {
                 $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(?, ?, ?, CURDATE())');
                 // Hachage du mot de passe lors de l'insertion :
                 $req->execute(array($pseudoRenseigne,password_hash($pass_hache, PASSWORD_DEFAULT),$email));
                 header('Location: forum.php');
                 $req->closeCursor();
             } else {
                 echo '<p>L\'adresse ' . $email . ' n\'est pas valide, recommencez !</p>';
             }
         } else {
             echo "<p>Les deux mots de passe ne sont pas identiques, veuillez les saisir de nouveau.</p>";
         }
     } else {
         echo "<p>Veuillez saisir un autre pseudo s'il vous plaît car celui ci est déà utilisé.</p>";
     }
 }
 ?>


    <p class="titreMembre">Déjà membre ?</p>
    <div class="formulaire">
        <form action="inscription.php" method="post">
            <label for="pseudoMembre"> Pseudo :
                <input type="text" name="pseudoMembre" value="<?php if (isset($_SESSION['pseudo'])) {
     echo $_SESSION['pseudo'];
 }?>" id="pseudo" required="required" />
            </label>
            <label for="passwordMembre"> Mot de passe :
                <input type="password" name="passMembre" id="passwordMembre" required="required" />
            </label>
            <input type="submit" value="Se connecter" id="bouton" />
        </form>
    </div>

    <?php 

if (isset($_POST['pseudoMembre']) and isset($_POST['passMembre'])) {

    // Connexion à la base de données
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=membres;charset=utf8', 'laureenperrin', 'Gnite2932', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' .$e -> getMessage());
    }

    $pseudoMembre = htmlspecialchars($_POST['pseudoMembre']);
    $passMembre = htmlspecialchars($_POST['passMembre']);

    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
    $req->execute(array(
    'pseudo' => $pseudoMembre));
    $resultat = $req->fetch();

    // Comparaison du pass envoyé via le formulaire avec la base
    $isPasswordCorrect = password_verify($passMembre, $resultat['pass']);

    if (!$resultat) {
        echo 'Mauvais identifiant ou mot de passe !';
    } else {
        if ($isPasswordCorrect) {
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['pseudo'] = $pseudoMembre;
            header('Location: forum.php');
        } else {
            echo 'Mauvais identifiant ou mot de passe !';
        }
    }
}

?>

</body>

</html>