<?php
session_start();
$valeur = 'schema:';
if(isset($_POST["type"])){
$url ='https://schema.org/'.$_POST["type"].'.jsonld';
$options = array(
    'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded",       
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

$obj = json_decode($result, true);
$valeur = $valeur.$_POST["type"];
$idx = "";
$finish_data = array();
foreach ($obj["@graph"] as $idx=>$ligne) 
{ 
    if(array_key_exists("schema:domainIncludes", $ligne))
    {
    
        if( $ligne["schema:domainIncludes"] == $valeur){
            $finish_data[$idx] = $ligne;
        }else{
        foreach ($ligne["schema:domainIncludes"] as $ligne2)
            {
                
                if(is_array($ligne2))
                {
                    if(in_array($valeur, $ligne2))
                    { 
                        $finish_data[$idx] = $ligne;
                    }
                }
                }if($ligne2 == $valeur){
                    $finish_data[$idx] = $ligne;
                }
            }
        }
    }
}
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
</head>
<body>
<div class="uk-container">
    <div class="uk-margin">
        <h2 class="uk-heading-line uk-heading-bullet"><span> DataModels/Sélectionner </span></h2>
    </div>
    <form action="" method="post">
    <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-select">Référence</label>
        <div class="uk-form-controls">
            <select class="uk-select" id="form-horizontal-select">
                <option>Schema.org</option>
                <option>FIWARE</option>
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="form-horizontal-text">Type</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="form-horizontal-text" type="text" name="type" placeholder="Entrez votre Type puis Entrée">
        </div>
    </div>
    </form>
</div> 
<?php
if(isset($_POST["type"])){ 
?>
<form action="checkdata.php" method="post">
<table class="uk-table uk-table-hover uk-table-divider">
    <thead>
    <tr>
    <th colspan="7" class="uk-text-center">
            <h2>
                <?= $_POST["type"] ?>
            </h2>
        </th>
    </tr>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Type</th>
            <th>Comment</th>
            <th>Label</th>
            <th>Domain Includes</th>
            <th>Range Includes</th>           
        </tr>
    </thead>
    <tbody>
<hr>
<?php
    foreach ($finish_data as $idx => $ligne)
            { ?>
    <tr>
        <td>
            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                <label><input class="uk-checkbox" type="checkbox" value="<?= $idx ?>" name="<?= $idx ?>"></label>
            </div>
        </td>
        <td><?= $ligne["@id"] ?></td>
        <td><?= $ligne["@type"] ?></td>
        <td><?= $ligne["rdfs:comment"] ?></td>
        <td>
        <table>
                    <tr>
                        <th>Language & Value</th>
                    </tr> 
                <tr>
                <td>
    <?php if(is_array($ligne["rdfs:label"])){
            foreach ($ligne["rdfs:label"] as $data) {            
                    echo $data; ?>
<br>    
    <?php   }
            }else{    
                echo $ligne["rdfs:label"];
            }
        ?>
            </td>
            </tr>  
        </table>
        </td>
            <td>
                <table>
                        <tr>
                            <th>ID</th>
                        </tr> 
    <?php foreach ($ligne["schema:domainIncludes"] as $donnee)
    { ?> 
                    <tr>
                        <td><?php if( count($ligne["schema:domainIncludes"]) == 1 ){
                            echo $donnee;
                        }else{
                            echo $donnee["@id"];
                         } ?>
                        </td>
                    </tr>
    <?php } ?>
                </table>
        </td><td>
                <table>
                        <tr>
                            <th>ID</th>
                        </tr> 
                    <?php foreach ($ligne["schema:rangeIncludes"] as $data2)
                    { ?> 
                        <tr>
                            <td><?php if( count($ligne["schema:rangeIncludes"]) == 1 ){
                                echo $data2;
                            }else{
                                echo $data2["@id"];
                            } ?>
                            </td>
                        </tr>

                    <?php }?>
                </table>
            </td>
        </tr>
    <?php }?>
</tbody> 
</table> 
<input type="hidden" name="type" value="<?= $_POST["type"] ?>">
<tr><td><button type="submit" class="uk-button uk-button-secondary uk-button-medium uk-align-center" id="submit">Envoyer la/les ligne(s) sélectionnée(s)</button></td></tr>
<?php }?>
</form>
</body>
</html>