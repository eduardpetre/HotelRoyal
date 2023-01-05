<?php

// server name
$sName = "eu-cdbr-west-03.cleardb.net";
// user name
$uName = "b58ba2155ca05d";
// password
$pass = "9b87ce75";

// database name
$db_name = "heroku_9259e79e8b40d66";


// facem conexiunea dintre server si data de baze 
// folosing PHP Data Objects (PDO)

try {
    $conn = new PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_9259e79e8b40d66', $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed: ". $e->getMessage();
}