<?php 
session_start();

include "db_conn.php";

include "php/func-room.php";
$rooms = get_all_rooms($conn);

include "php/func-category.php";
$categories = get_all_categories($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hotel Royal</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		    <div class="container-fluid">
		        <a class="navbar-brand" href="index.php">Hotel Royal</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Rezervare</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Despre noi</a>
                        </li>
                        <li class="nav-item">
                        
                        <?php if (isset($_SESSION['user_id'])) {?>
                            <a class="nav-link" href="admin.php">Admin</a>
                        <?php } else if (isset($_SESSION['user2_id'])) {?>
                            <a class="nav-link" href="logout.php">Deconectare</a>
                        <?php } else {?>
                            <a class="nav-link" href="login.php">Login</a>
                        <?php }?>

                        </li>
                    </ul>
                </div>
		    </div>
		</nav>

		<div class="d-flex pt-3">

			<?php if ($rooms == 0){ ?>
				<div class="alert alert-warning text-center p-5" role="alert" style="width:70%; margin-right:10%">
                    Nu exista camere in baza de date
		        </div>
			<?php }else{ ?>

			<div class="room-list d-flex flex-wrap">
				<?php foreach ($rooms as $room) { ?>
				<div class="card m-1">
					<img src="uploads/picture/<?=$room['picture']?>" class="card-img-top">
					<div class="card-body">
						<h5 class="card-title"> <?=$room['name']?></h5>
						<p class="card-text">
							<?=$room['description']?>
							<br><br><i><b>Capacitate:
								<?php foreach($categories as $category){ 
									if ($category['id'] == $room['category_id']) {
										echo $category['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
                            <i><b>
                                <?php 
                                if (isset($_GET['check-in']) && 
                                    isset($_GET['check-out'])) {
                                        
                                        if (date_create($_GET['check-out']) < date_create($_GET['check-in'])) {
                                ?>        
                                            Perioada indispoinibila!

                                <?php   } else {


                                        $diff = date_diff(date_create($_GET['check-out']),date_create($_GET['check-in']));
                                        $newPrice = $room['price']*$diff->days;
                                ?>    
                                        Pret: 
                                        <?=$newPrice?> lei,

                                        <?php if($diff->days > 1) { ?> 
                                            <?=$diff->days?> nopti
                                        <?php } else { ?>
                                            1 noapte
                                        <?php } ?>    
                                    
                                <?php }} else { ?>
                                    Pret: 
                                    <?=$room['price']?>
                                    lei, 1 noapte
                                <?php } ?>
							<br></b></i>
						</p>

                        <a href="php/pdf-generator.php" class="btn btn-success" style="width: 100%;">Rezerva acum!</a>

					</div>
				</div>
				<?php } ?>
			</div>
		    <?php } ?>
            
            <div class="search">
                <div class="search-list">
                    <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="GET" action="index.php">
                        <div class="mb-3">
                            <label class="form-label">Data check-in</label>
                            <input type="date" class="form-control" value="<?=date("Y-m-d", strtotime("+0 day"))?>" min="<?=date("Y-m-d", strtotime("+0 day"))?>" name="check-in">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data check-out</label>
                            <input type="date" class="form-control" value="<?=date("Y-m-d", strtotime("+1 day"))?>" min="<?=date("Y-m-d", strtotime("+1 day"))?>" name="check-out">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%">Cauta</button>
                    </form>

                    <div class="list-group rounded shadow">
                        <?php if ($categories == 0){
                            // do nothing
                        } else { ?>
                            <a href="#" class="list-group-item list-group-item-action active">Category</a>
                            <?php foreach ($categories as $category ) { ?>
                        
                            <a href="category.php?id=<?=$category['id']?>" class="list-group-item list-group-item-action">
                                <?=$category['name']?>
                            </a>
                        <?php } } ?>
                    </div>
                </div>
            </div>

		</div>
	</div>
</body>
</html>