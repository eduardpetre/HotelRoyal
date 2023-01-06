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

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

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
            $sql2 = "INSERT INTO users(name, email, password) 
                    VALUES(?,?,?)";
            
            $stmt2 = $conn->prepare($sql2);
            $res = $stmt2->execute([$name, $email, $password]);

            if ($res) {
                // success message
                $sm = "Contul a fost creat cu succes!";
                header("Location: ../signup.php?success=$sm");
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