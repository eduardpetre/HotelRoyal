<?php

session_start();

if (isset($_POST['name']) && 
    isset($_POST['email']) &&
    isset($_POST['message'])) {

    // fisierul pt conectarea bazei de date
    include "../db_conn.php";

    //fisierul pt validarea formularului
    include "func-validation.php";

    // Preluam datele din formular
    // si le memoram in variabile 

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $message = validate($_POST['message']);

    $user_data = 'email='.$email.'&name='.$name;

    // validare simpla de formular
    $text = "nume";
    $location = "../contact.php";
    $ms = "error";
    is_empty($name, $text, $location, $ms, $user_data);

    $text = "email";
    $location = "../contact.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, $user_data);

    $text = "mesaj";
    $location = "../contact.php";
    $ms = "error";
    is_empty($message, $text, $location, $ms, $user_data);


    $myemail = 'eduardpetredaw@gmail.com';    
    $email_subject = "Contact form submission: $name";
    $email_body = "You have received a new message. ".
                " Here are the details:<br> Name: $name <br> ".
                "Email: $email<br> Message <br> $message";

    // mail($to,$email_subject,$email_body,$headers);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $_ENV['TRUSTIFI_URL'] . "/api/i/v1/email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\"recipients\":[{\"email\":\"$myemail\"}],\"title\":\"$email_subject\",\"html\":\"$email_body\"}",
        CURLOPT_HTTPHEADER => array(
            "x-trustifi-key: " . "fff6f53b014b6dc008eb3fb85d1c1510c261f1c1ccc3e41c",
            "x-trustifi-secret: " . "75127a9442b372a32c3d7faf3f547ab7",
            "content-type: application/json"
        )
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
        $sm = "Mesajul a fost trimis cu succes!";
        header("Location: ../contact.php?success=$sm");
        exit;
    }

} else {
    // Redirectionare la "../contact.php"
    header("Location: ../contact.php");
}