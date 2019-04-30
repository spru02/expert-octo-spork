<?php
require('cryptage.php');
session_start();
$alert_class = "";
$alert2_class = "";
$text_alert = "";
$key = "azerty";

if (isset($_POST["username"])){
$url = 'http://35.204.123.64:3000/oauth2/token';
$data = array('grant_type' => 'password', 'username' => $_POST["username"], 'password' => $_POST["password"], 'client_id' => '0f4cbaab-7898-4ae5-a112-850137053a7a', 'client_secret' => 'ee7e01f0-ec7d-47e0-a408-7f54283d8ab1');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'ignore_errors' => true,
        'header'  => "Content-type: application/x-www-form-urlencoded",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);

$result = file_get_contents($url, true, $context);
if ($result === FALSE) { /* Handle error */ }

// var_dump($result);
// var_dump(json_decode($result, true));

$obj = json_decode($result, true);
if (isset ($obj["access_token"])){   
    $iv = iv();

    $_SESSION["username"]= $_POST["username"]; 
    $_SESSION["iv"]= $iv;
    $_SESSION["password"]= encrypt($iv,$password,$key);
    header('location: http://127.0.0.1/Keyrock/session.php');

}else{
    $alert_class= "uk-form-danger";
    $alert2_class= "uk-form-danger";
    $text_alert = "<h2> Email et/ou mot de passe inconnu* </h2>";
    // echo "La réponse ne contient pas access_token !";
};
}else{
    echo "*Remplissez les champs Identifiant et Mot de passe";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Récupération identifiant Keyrock </title>
    <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
    <!-- UIkit JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit-icons.min.js"></script>
</head>
<body>
<div class="uk-container">
    <div class="uk-margin">
        <h1 class="uk-heading-line uk-text-center"><span> Connexion avec Identifiant Keyrock </span></h1>
    </div>
    <br>
    <form method="post" action="" enctype="">
        <fieldset class="uk-dark uk-background-muted uk-padding">
                <div class="uk-margin">
                <div> <?= $text_alert?> </div>
        <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input class="uk-input <?= $alert_class ?>" name="username" type="text" placeholder="Identifiant">
        </div>
    </div>

    <div class="uk-margin">
        <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                <input class="uk-input <?= $alert2_class ?>" type="password" grant_type="password" name="password" placeholder="Mot de passe">
        </div>
    </div>
            <p uk-margin>
                <button type="submit" class="uk-button uk-button-secondary uk-button-large" id="submit">Envoyer</button>
            </p>
        </fieldset>
    </form>   
</div>
</div>
</body>
</html>
