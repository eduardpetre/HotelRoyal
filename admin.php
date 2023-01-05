<?php
session_start();

// daca admin este conectat
if(isset($_SESSION['user_id']) &&
   isset($_SESSION['user_email'])) {


    include "db_conn.php";

    include "php/func-room.php";
    $rooms = get_all_rooms($conn);

    include "php/func-category.php";
    $categories = get_all_categories($conn);

?>


<!DOCTYPE html>
<html lang ="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>

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
                            <a class="nav-link" href="add-room.php">Adauga camera</a>
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

        <div class="mt-5"></div>
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

        <?php  if ($rooms == 0) { ?>
        	<div class="alert alert-warning text-center p-5" role="alert">
			    Nu exista camere in baza de date
		    </div>
        <?php } else {?>

        <h4 class="mt-5">Toate camerele</h4>
        <table class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nume</th>
                    <th>Categorie</th>
                    <th>Descriere</th>
                    <th>Pret/noapte</th>
                    <th>Actiune</th>
            </thead>
            <tbody>
                <?php 
                $i = 0;
                foreach ($rooms as $room) { 
                $i++;
                ?>

                <tr>
                    <td><?=$i?></td>
                    <td>
                        <img width="200" src="uploads/picture/<?=$room['picture']?>" alt="">
                        
                        <a class="link-dark d-block text-center" href="#">
                            <?=$room['name']?>
                        </a>
                    </td>
                    <td>
                        <?php if ($categories == 0) {
                            echo "Undefined";
                        }else {
                            foreach ($categories as $category) {
                                if ($category['id'] == $room['category_id']){
                                    echo $category['name'];
                                }
                            }
                        }
                        ?>
                    </td>
                    <td><?=$room['description']?></td>
                    <td><?=$room['price']?></td>
                    <td>
                        <a href="edit-room.php?id=<?=$room['id']?>" class="btn btn-warning">Edit</a>
                        <a href="php/delete-room.php?id=<?=$room['id']?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                
                <?php } ?>
            
            </tbody>
        </table>

        <?php }?>

        <?php if ($categories == 0) { ?>
            <div class="alert alert-warning text-center p-5" role="alert">
			    Nu exista categorii in baza de date
		    </div>
        <?php }else {?>
        
        <h4 class="mt-5"> All Categories</h4>
        
        <table class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Categories</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $j = 0;
                foreach ($categories as $category) {
                $j++;
                ?>
                <tr>
                    <td><?=$j?></td>
                    <td><?=$category['name']?></td>
                    <td>
                        <a href="edit-category.php?id=<?=$category['id']?>" class="btn btn-warning">Edit</a>
                        <a href="php/delete-category.php?id=<?=$category['id']?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
        </table>

        <?php } ?>

    </div>

</body>
</html>


<?php } else{
    header("Location: login.php");
    exit;
} ?>