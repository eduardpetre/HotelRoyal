<?php

function get_all_admins($con){
    $sql = "SELECT * FROM admin";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $admins = $stmt->fetchAll();
    }else {
        $admins = 0;
    }

    return $admins;
}

// Get admin by id

function get_admin($con, $id){
    $sql = "SELECT * FROM admin WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0) {
        $admin = $stmt->fetch();
    }else {
        $admin = 0;
    }

    return $admin;
}