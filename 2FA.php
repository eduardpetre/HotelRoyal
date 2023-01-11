<?php
if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else $name = '';

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    } else $email = '';

?>

<!DOCTYPE html>
<html lang ="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODE</title>

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
                    </ul>
                </div>
		    </div>
		</nav>

        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="POST" action="php/2FA.php">
                
                <h1 class="text-center display-4 pb-5">Inregistrare</h1>

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
                    <label for="exampleInputCode1" class="form-label">Cod verificare</label>
                    <input type="text" class="form-control" name="code" id="exampleInputCode1" aria-describedby="codeHelp">
                </div>
                <button type="submit" class="btn btn-primary">Trimite</button>
            </form>
        </div>
    </div>
</body>
</html>