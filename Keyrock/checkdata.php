<?php
session_start();
$valeur = 'schema:';
$url = $_POST["url"];
$options = array(
    'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded",       
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

$obj = json_decode($result, true);
foreach ($obj["@graph"] as $key){
    foreach ($_POST as $key1 => $value) { 
        var_dump($value);
}
}

?>