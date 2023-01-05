<?php
session_start();

// daca admin este conectat
if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {

    include "db_conn.php";

    include "php/func-category.php";
    $categories = get_all_categories($conn);

    if (isset($_GET['name'])) {
        $name = $_GET['name'];
    } else $name = '';

    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
    } else $category_id = 0;

    if (isset($_GET['description'])) {
        $description = $_GET['description'];
    } else $description = '';

    if (isset($_GET['price'])) {
        $price = $_GET['price'];
    } else $price = '';
?>


<!DOCTYPE html>
<html lang ="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>

    <!-- bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- bootstrap 5 Js CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Rezervare</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="add-room.php">Adauga camera</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add-category.php">Adauga categorie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Deconectare</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    
        <form action="php/add-room.php" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width:90$; max-width:50rem">
            <h1 class="text-center pb-5 display-4 fs-3">
                Adauga o noua camera
            </h1>

            <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?=htmlspecialchars($_GET['error']); ?>
            </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?=htmlspecialchars($_GET['success']); ?>
            </div>
            <?php } ?>

            <div class="mb-3">
                <label class="form-label">Numele camerei</label>
                <input type="text" class="form-control" value="<?=$name?>" name="room_name">
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria camerei</label>
                <select name="room_category" class="form-control">
                    <option value="0">
                        Selecteaza categoria
                    </option>

                    <?php 
                    
                    if($categories == 0) {
                        // Do nothing
                    } else{

                    foreach ($categories as $category) { 
                        
                        if($category_id == $category['id']) {
                    ?>
                        <option selected value="<?=$category['id']?>">
                            <?=$category['name']?>
                        </option>

                    <?php } else{ ?>

                        <option value="<?=$category['id']?>">
                            <?=$category['name']?>
                        </option>

                    <?php }} } ?>
                
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrierea camerei</label>
                <input type="text" class="form-control" value="<?=$description?>" name="room_description">
            </div>

            <div class="mb-3">
                <label class="form-label">Pretul camerei pe noapte</label>
                <input type="text" class="form-control" value="<?=$price?>" name="room_price">
            </div>

            <div class="mb-3">
                <label class="form-label">Poza camerei</label>
                <input type="file" class="form-control" name="room_picture">
            </div>

            <button type="submit" class="btn btn-primary">Adauga camera</button>
        
        </form>
    </div>

</body>
</html>


<?php } else{
    header("Location: login.php");
    exit;
} ?>