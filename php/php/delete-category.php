<?php

session_start();

if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        // simple form validation
        if(empty($id)){
            $em = "Ceva nu este in regula!";
            header("Location: ../admin.php?error=$em");
            exit;
        } else {
            // delete category from database
            $sql = "DELETE FROM categories
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$id]);

            if ($res) {
                // success message
                $sm = "Categoria a fost stearsa cu succes!";
                header("Location: ../admin.php?success=$sm");
                exit;
            } else {
                // error message
                $em = "Ceva nu este in regula!";
                header("Location: ../admin.php?error=$em");
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