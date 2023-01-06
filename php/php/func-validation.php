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