<?php
session_start();

$url2 ='http://127.0.0.1/Keyrock/type.json';
$result2 = file_get_contents($url2);
$obj2 = json_decode($result2, true);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> DataModels </title>
    <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
    <!-- UIkit JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit-icons.min.js"></script>
    <!-- JS -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="http://127.0.0.1/Keyrock/datamodel.js"></script>
</head>
<body>
<div class="uk-container">
    <div class="uk-margin">
        <h2 class="uk-heading-line uk-heading-bullet"><span> DataModels/Sélectionner </span></h2>
    </div>
    <?php if(!isset($_POST["type"])) { ?>
    <form action="tableau.php" method="post">
    <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-select">Référence</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="form-horizontal-select" name="reference">
                <option>Schema.org</option>
                <option>FIWARE</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-select" >MyType</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="select_type" name="mytype">
            <option value="0"></option>
            <?php 
    foreach($obj2["Type"]  as $valeuroption => $valeurreference){ ?>

        <option value="<?= $valeurreference["type"] ?>" text="<?= $valeurreference["type"] ?>"><?=$valeuroption?></option>

    <?php } ?>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">Type</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="type_text" type="text" name="type" placeholder="Entrez votre Type">
        </div>
    </div>
    <button type="submit" class="uk-button uk-button-secondary uk-button-medium uk-align-center" id="submit">Envoyer</button>
    </form>
<?php } ?>  
</div> 
</body>
</html>