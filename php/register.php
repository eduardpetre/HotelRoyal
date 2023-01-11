<?php

session_start();

if (isset($_POST['name']) && 
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['repassword'])){

    // fisierul pt conectarea bazei de date
    include "../db_conn.php";

    //fisierul pt validarea formularului
    include "func-validation.php";

    // Preluam datele din formular
    // si le memoram in variabile 
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $repassword = validate($_POST['repassword']);

    $user_data = 'email='.$email.'&name='.$name;

    // validare simpla de formular
    $text = "nume";
    $location = "../signup.php";
    $ms = "error";
    is_empty($name, $text, $location, $ms, $user_data);

    $text = "email";
    $location = "../signup.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, $user_data);

    $text = "parola";
    $location = "../signup.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, $user_data);

    $text = "REparola";
    $location = "../signup.php";
    $ms = "error";
    is_empty($repassword, $text, $location, $ms, $user_data);

    if ($password !== $repassword){
        header("Location: ../signup.php?error=Parolele nu corespund&$user_data");
        exit;
    } else {
        // hashing the password
        $password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "SELECT * FROM users
                WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        
        // daca emailul exista
        if ($stmt->rowCount() === 1) {
            header("Location: ../signup.php?error=Exista deja un cont cu acelasi email!&$user_data");
            exit;
        } else {

            include "../PHPGangsta/GoogleAuthenticator.php";
            $ga = new PHPGangsta_GoogleAuthenticator();
            $secret = $ga->createSecret();

            $to = $email;
            
            $email_subject = "2FA Hotel Royal";
            $email_body = "Codul pentru contul creat este: ".$secret;

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
                CURLOPT_POSTFIELDS =>"{\"recipients\":[{\"email\":\"$email\"}],\"title\":\"$email_subject\",\"html\":\"$email_body\"}",
                CURLOPT_HTTPHEADER => array(
                    "x-trustifi-key: " . "fff6f53b014b6dc008eb3fb85d1c1510c261f1c1ccc3e41c",
                    "x-trustifi-secret: " . "75127a9442b372a32c3d7faf3f547ab7",
                    "content-type: application/json"
                )
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $sql2 = "INSERT INTO users(name, email, password, code) 
                    VALUES(?,?,?,?)";
            
            $stmt2 = $conn->prepare($sql2);
            $res = $stmt2->execute([$name, $email, $password, $secret]);

            if ($res) {
                // success message
                $_SESSION['email'] = $email;
                header("Location: ../2FA.php?success=Introduceti codul de verificare");
                exit;
            }else {
                // error message
                $em = "Ceva nu este in regula!";
                header("Location: ../signup.php?error=$em");
                exit;
            }
        }
    }

} else {
    // Redirectionare la "../signup.php"
    header("Location: ../signup.php");
}