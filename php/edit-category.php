<?php

session_start();

if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    if (isset($_POST['category_name']) &&
        isset($_POST['category_id'])) {

        $id = $_POST['category_id'];
        $name = $_POST['category_name'];

        if(empty($name)){
            $em = "Campul pentru numele categoriei este gol!";
            header("Location: ../edit-category.php?error=$em&id=$id");
            exit;
        } else {
            // Insert into database
            $sql = "UPDATE categories 
                    SET name=?  
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name, $id]);
        
            if ($res) {
                // success message
                $sm = "Categoria a fost editata cu succes!";
                header("Location: ../edit-category.php?success=$sm&id=$id");
                exit;
            }else {
                // error message
                $em = "Ceva nu este in regula!";
                header("Location: ../edit-category.php?error=$em&id=$id");
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