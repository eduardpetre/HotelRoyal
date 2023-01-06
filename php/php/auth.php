<?php

session_start();

if (isset($_POST['email']) && 
    isset($_POST['password'])) {

    // fisierul pt conectarea bazei de date
    include "../db_conn.php";

    //fisierul pt validarea formularului
    include "func-validation.php";

    // Preluam datele din formular
    // si le memoram in variabile 

    $email = $_POST['email'];
    $password = $_POST['password'];

    // validare simpla de formular

    $text = "email";
    $location = "../login.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "parola";
    $location = "../login.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, "");

    // cautare email in admin
    $sql = "SELECT * FROM admin
            WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    // daca emailul exista in admin
    if ($stmt->rowCount() === 1) {
        
        $user = $stmt->fetch();
        $user_id = $user['id'];
        $user_email = $user['email'];
        $user_password = $user['password'];

        if ($email === $user_email) {
            if(password_verify($password, $user_password)) {
                $_SESSION['user_id'] = $user_id;
    			$_SESSION['user_email'] = $user_email;
    			header("Location: ../admin.php"); 
            } else {
                // eroare
                $em = "Email sau parola incorecte";
                header("Location: ../login.php?error=$em");
            }
        
        }
    } else {
        // cautare email in users
        $sql2 = "SELECT * FROM users
               WHERE email=?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([$email]);

        // daca emailul exista in users
        if ($stmt2->rowCount() === 1) {

            $user2 = $stmt2->fetch();
            $user2_id = $user2['id'];
            $user2_email = $user2['email'];
            $user2_password = $user2['password'];

            if ($email === $user2_email) {
                if(password_verify($password, $user2_password)) {
                    $_SESSION['user2_id'] = $user2_id;
                    $_SESSION['user2_email'] = $user2_email;
                    header("Location: ../index.php");
                    
                } else {
                    // eroare
                    $em = "Email sau parola incorecte";
                    header("Location: ../login.php?error=$em");
                }
            }
        } else {
            // eroare
            $em = "Email sau parola incorecte";
            header("Location: ../login.php?error=$em");
        }
    } 

} else {
    // Redirectionare la "../login.php"
    header("Location: ../login.php");
}