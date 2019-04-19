<?php
session_start();

if ( !isset($_SESSION['username']) ) {
    header('location: http://127.0.0.1/Keyrock/connexion.php');
    exit();
}

echo "Vous êtes connectés !!";

?>