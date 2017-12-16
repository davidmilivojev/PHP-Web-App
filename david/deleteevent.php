<?php

if(!isset($_SESSION)) session_start();
if (!isset($_SESSION["username"])) header('Location: index.php');

$urlPOST = "http://localhost/david/services/obrisipredavanje";
   $curl_post_data = array(
        'id' => $_POST['id']
        );
   $curl = curl_init($urlPOST);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_POST, true);
   curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
   $response = curl_exec($curl);
   if ($response) header('Location: /david/event.php');

?>
