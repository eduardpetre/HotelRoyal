<?php

function get_all_rooms($con){
    $sql = "SELECT * FROM rooms ORDER by id DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $rooms = $stmt->fetchAll();
    }else {
        $rooms = 0;
    }

    return $rooms;
}

function get_room($con, $id){
    $sql = "SELECT * FROM rooms WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0) {
        $room = $stmt->fetch();
    }else {
        $room = 0;
    }

    return $room;
}