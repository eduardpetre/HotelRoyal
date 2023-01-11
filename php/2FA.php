<?php

session_start();

if (isset($_POST['code'])){

    // fisierul pt conectarea bazei de date
    include "../db_conn.php";

    //fisierul pt validarea formularului
    include "func-validation.php";

    // Preluam datele din formular
    // si le memoram in variabile 
    $code = validate($_POST['code']);

    // validare simpla de formular
    $text = "cod".$code;
    $location = "../2FA.php";
    $ms = "error";
    is_empty($code, $text, $location, $ms, "");

    $email = $_SESSION['email'];
    $sql = "SELECT * FROM users
                WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);


    if ($stmt->rowCount() === 1){
        $user = $stmt->fetch();
        $user_id = $user['id'];
        $user_code = $user['code'];

        include "../PHPGangsta/GoogleAuthenticator.php";
        $ga = new PHPGangsta_GoogleAuthenticator();
        $checkResult = $ga->verifyCode($user_code, $_POST['code'], 2);

        if (!$checkResult){
            $sql2 = "DELETE FROM users 
                    WHERE id=?";
                
            $stmt2 = $conn->prepare($sql2);
            $res = $stmt2->execute([$user_id]);

            // error message
            $er="Codul introdus a fost gresit. Reia inregistrarea!";
            header("Location: ../signup.php?error=$er");
            exit;
        } else {
            // success message
            $sm="Contul a fost creat cu succes!";
            header("Location: ../2FA.php?success=$sm");
            exit;
        }
    }
} else {
    // Redirectionare la "../signup.php"
    header("Location: ../2FA.php");
}