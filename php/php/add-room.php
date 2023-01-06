<?php

session_start();

if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    include "func-validation.php";

    include "func-file-upload.php";

    if (isset($_POST['room_name']) && 
        isset($_POST['room_category']) &&
        isset($_POST['room_description']) &&
        isset($_POST['room_price']) &&
        isset($_FILES['room_picture'])) {

        $name = $_POST['room_name'];
        $category = $_POST['room_category'];
        $description = $_POST['room_description'];
        $price = $_POST['room_price'];

        // making URL data format
        $user_input = 'name=' .$name.'&category_id='.$category.'&description='.$description.'&price='.$price;

        // simple form validation
        $text = "numele camerei";
        $location = "../add-room.php";
        $ms = "error";
        is_empty($name, $text, $location, $ms, $user_input);

        $text = "categoria camerei";
        $location = "../add-room.php";
        $ms = "error";
        is_empty($category, $text, $location, $ms, $user_input);

        $text = "descrierea camerei";
        $location = "../add-room.php";
        $ms = "error";
        is_empty($description, $text, $location, $ms, $user_input);

        $text = "pretul camerei";
        $location = "../add-room.php";
        $ms = "error";
        is_empty($price, $text, $location, $ms, $user_input);

        $allowed_image_exs = array("jpg", "jpeg", "png");
        $path = "picture";
        $room_picture = upload_file($_FILES['room_picture'], $allowed_image_exs, $path);

        if($room_picture['status'] == "error") {
            $em = $room_picture['data'];
            header("Location: ../add-room.php?error=$em&$user_input");
            exit;
        } else {

            $room_picture_URL = $room_picture['data'];
            
            $sql = "INSERT INTO rooms (name, category_id, description, price, picture)
                    VALUES (?,?,?,?,?)";
            
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$name, $category, $description, $price, $room_picture_URL]);
        
            if ($res) {
                // success message
                $sm = "Camera a fost adaugata cu succes!";
                header("Location: ../add-room.php?success=$sm");
                exit;
            }else {
                // error message
                $em = "Ceva nu este in regula!";
                header("Location: ../add-room.php?error=$em");
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