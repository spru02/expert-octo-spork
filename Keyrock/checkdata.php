<?php
session_start();
$valeur = 'schema:';
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
$finish_data = array();
foreach ($obj["@graph"] as $key => $ligne){
    foreach ($_POST as $key1 => $value) { 
        if($key1==$key and $key1 != "type"){
            array_push($finish_data, $ligne);
        }
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> DataSelected </title>
    <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
    <!-- UIkit JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit-icons.min.js"></script>
</head>

<form action="datamodels.php" method="post">
<table class="uk-table uk-table-hover uk-table-divider">
    <thead>
    <tr>
    <th colspan="6" class="uk-text-center">
            <h2>
            <?= $_POST["type"] ?> (avec ligne(s) sélectionnée(s) seulement)
            </h2>
        </th>
    </tr>
        <tr>
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
                         } ?></td>
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
                            } ?></td>
                        </tr>

                    <?php }?>
                </table>
            </td>
        </tr>
    <?php }?>
<input type="hidden" name="type" value="<?= $_POST["type"] ?>">   
<tr><td colspan="6"><button type="submit" id="submit" class="uk-button uk-button-secondary uk-button-medium uk-align-center" value="retour">Retour</button></td></tr>
</tbody> 
</table> 
</form>