<?php
    session_start();

    include "db_conn.php";
    
    include "php/func-user.php";
    $users = get_nr_users($conn);

    include "php/func-admin.php";
    $admins = get_nr_admin($conn);

?>

<!DOCTYPE html>
<html lang ="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABOUT</title>

    <!-- bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- bootstrap 5 Js CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Useri',     <?php echo $users ?>],
            ['Admini',      <?php echo $admins ?>],
        ]);


        var options = {
          title: 'Utilizatori',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

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
            <div class="p-5 rounded shadow" style="max-width: 30rem; width: 100%">
                
                <h1 class="text-center display-4 pb-5">Despre noi</h1>

                <div class="mb-3">
                    <label class="form-label">Numar de vizitatori <?=$_SESSION['visitors']?></label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Numar administratori <?=$admins?></label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Numar de clienti <?=$users?></label>
                </div>

                <div id="piechart_3d"></div>
            </div>
        </div>
    </div>
</body>
</html>