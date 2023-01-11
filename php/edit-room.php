<?php

session_start();

if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    include "func-validation.php";

    include "func-file-upload.php";

    if (isset($_POST['room_id']) &&
        isset($_POST['room_name']) && 
        isset($_POST['room_category']) &&
        isset($_POST['room_description']) &&
        isset($_POST['room_price']) &&
        isset($_FILES['room_picture']) &&
        isset($_POST['current_picture'])) {

        $id = $_POST['room_id'];
        $name = validate($_POST['room_name']);
        $category = $_POST['room_category'];
        $description = validate($_POST['room_description']);
        $price = validate($_POST['room_price']);
        $current_picture = $_POST['current_picture'];


        // simple form validation
        $text = "numele camerei";
        $location = "../edit-room.php";
        $ms = "id=$id&error";
        is_empty($name, $text, $location, $ms, "");

        $text = "categoria camerei";
        $location = "../edit-room.php";
        $ms = "id=$id&error";
        is_empty($category, $text, $location, $ms, "");

        $text = "descrierea camerei";
        $location = "../edit-room.php";
        $ms = "id=$id&error";
        is_empty($description, $text, $location, $ms, "");

        $text = "pretul camerei";
        $location = "../edit-room.php";
        $ms = "id=$id&error";
        is_empty($price, $text, $location, $ms, "");
        
        if (!empty($_FILES['room_picture']['name'])){
            
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "picture";
            $room_picture = upload_file($_FILES['room_picture'], $allowed_image_exs, $path);

            if($room_picture['status'] == "error") {
                $em = $room_picture['data'];
                header("Location: ../edit-room.php?error=$em&id=$id");
                exit;
            } else {
                
                // delete current room picture path
                $curr_path_room_picture = "../uploads/picture/$current_picture";
                unlink($curr_path_room_picture);
                
                $room_picture_URL = $room_picture['data'];

                $sql = "UPDATE rooms
                        SET name=?,
                            category_id=?,
                            description=?,
                            price=?,
                            picture=?
                        WHERE id=?";

                $stmt = $conn->prepare($sql);
                $res = $stmt->execute([$name, $category, $description, $price, $room_picture_URL, $id]);

                if ($res) {
                    // success message
                    $sm = "Camera a fost editata cu succes!";
                    header("Location: ../edit-room.php?success=$sm&id=$id");
                    exit;
                } else {
                    // error message
                    $em = "Ceva nu este in regula!";
                    header("Location: ../edit-room.php?error=$em&id=$id");
                    exit;
                }
            }

        } else {
            $sql = "UPDATE rooms
                    SET name=?,
                        category_id=?,
                        description=?,
                        price=?
                    WHERE id=?";

            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name, $category, $description, $price, $id]);

            if ($res) {
                // success message
                $sm = "Camera a fost editata cu succes!";
                header("Location: ../edit-room.php?success=$sm&id=$id");
                exit;
            } else {
                // error message
                $em = "Ceva nu este in regula!";
                header("Location: ../edit-room.php?error=$em&id=$id");
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