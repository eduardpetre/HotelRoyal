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

            // get room from database
            $sql2 = "SELECT * FROM rooms
                    WHERE id=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$id]);
            $room = $stmt2->fetch();

            if ($stmt2->rowCount() > 0){
                
                // delete room from database
                $sql = "DELETE FROM rooms
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                if ($res) {

                    // delete current room_picture
                    $picture = $room['picture'];
                    $curr_picture_path = "../uploads/picture/$picture";

                    unlink($curr_picture_path);

                    // success message
                    $sm = "Cartea a fost stearsa cu succes!";
                    header("Location: ../admin.php?success=$sm");
                    exit;
                } else {
                    // error message
                    $em = "Ceva nu este in regula!";
                    header("Location: ../admin.php?error=$em");
                    exit;
                }

            } else {
                $em = "Eroare!";
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