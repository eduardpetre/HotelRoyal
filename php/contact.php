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

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

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
        CURLOPT_POSTFIELDS =>"{\"recipients\":[{\"email\":\"eduardpetredaw@gmail.com\"}],\"title\":\"Title\",\"html\":\"Body\"}",
        CURLOPT_HTTPHEADER => array(
            "x-trustifi-key: " . $_ENV['TRUSTIFI_KEY'],
            "x-trustifi-secret: " . $_ENV['TRUSTIFI_SECRET'],
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

    // $myemail = 'vasile-eduard.petre@s.unibuc.ro';
    // $to = $myemail;
    
    // $email_subject = "Contact form submission: $name";
    // $email_body = "You have received a new message. ".
    //             " Here are the details:\n Name: $name \n ".
    //             "Email: $email\n Message \n $message";
    
    // $headers = "From: $myemail\n";
    // $headers .= "Reply-To: $email";
    
    // mail($to,$email_subject,$email_body,$headers);

    //redirect to the 'thank you' page

} else {
    // Redirectionare la "../signup.php"
    header("Location: ../contact.php");
}