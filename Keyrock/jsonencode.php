<?php 

$values = array (
    "Type" => array(
        "Recette"
        => array("type" => "Recipe", 
        "attributes" => array("recipeIngredient","recipeYield")),

        "Livre" 
        => array("type" => "Book", 
        "attributes" => array("bookEdition","bookFormat","illustrator")),

        "Evenement"
        => array("type" => "Event",
        "attributes" => array(""))
    )
);

$contenu_json =json_encode($values);


// Ouverture du fichier
$fichier = fopen("D:\\UwAmp\\www\\Keyrock\\type.json", "w+");

// Ecriture dans le fichier
fwrite($fichier, $contenu_json);

// Fermeture du fichier
fclose($fichier);
?>