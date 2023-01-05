<?php

session_start();

if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    if (isset($_POST['category_name'])) {

        $name = $_POST['category_name'];
        
        if(empty($name)){
            $em = "Campul pentru numele categoriei este gol!";
            header("Location: ../add-category.php?error=$em");
            exit;
        } else {
            // Insert into database
            $sql = "INSERT INTO categories (name) 
                    VALUES (?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name]);
        
            if ($res) {
                // succes message
                $sm = "Categoria a fost adaugata cu succes!";
                header("Location: ../add-category.php?success=$sm");
                exit;
            }else {
                // error message
                $em = "Ceva nu este in regula!";
                header("Location: ../add-category.php?error=$em");
                exit;
            }
        }

    } else {
        header("Location: ../admin.php");
        exit;
    }

} else{
    header("Location: ../login.php");
    exit;
}