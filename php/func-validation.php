<?php

// functie pt validarea formularului

function is_empty($var, $text, $location, $ms, $data) {
    if(empty($var)) {
        // Error message
        $em = "Campul pentru " .$text. " este gol!";
        header("Location: $location?$ms=$em&$data");
        exit;
    }
    return 0;
}

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
 }