<?php

session_start();

if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else $name = '';

if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else $email = '';

if (isset($_POST['message'])) {
        $message = $_POST['message'];
    } else $message = '';

?>

<!DOCTYPE html>
<html lang ="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACT</title>

    <!-- bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- bootstrap 5 Js CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

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
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">Despre noi</a>
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

        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="POST" action="php/contact.php">
                
                <h1 class="text-center display-4 pb-5">Contact</h1>

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
                    <label for="exampleInputName1" class="form-label">Nume complet</label>
                    <input type="text" class="form-control" value="<?=$name?>" name="name" id="exampleInputName1" aria-describedby="nameHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" value="<?=$email?>" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputMessage1" class="form-label">Mesaj</label>
                    <input type="text" class="form-control" value="<?=$message?>" name="message" id="exampleInputMessage1" aria-describedby="messageHelp">
                </div>
                <button type="submit" class="btn btn-primary">Trimite</button>
            </form>
        </div>
    </div>
</body>
</html>