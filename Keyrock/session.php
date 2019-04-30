<?php
session_start();
if (isset($_POST['deco'])){
    session_destroy();
}

if ((!isset($_SESSION['username']))){
    header('location: http://127.0.0.1/Keyrock/connexion.php');
    exit();
}

echo "Vous êtes connectés !!";

?>
<html>
<head>
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
        <!-- UIkit JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit-icons.min.js"></script>
</head>
<div class="uk-container"> 
<form method="post" action="">
<input type="submit" name="deco" class="uk-button uk-button-secondary uk-button-large" value="Déconnexion">
</form>
</div>
</html>