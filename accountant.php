<?php
session_start();
include("dataBase.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style2.css">
    <title>Личный кабинет бухгалтера</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg brown_panel" style="background: #20B2AA;">
        <a class="navbar-brand" href="#">Личный кабинет бухгалтера</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-4">
            <li class="nav-item">
                <a class="nav-link" href="Cars.php">Автомобили</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Reports.php">Отчеты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Выход</a>
            </li>
        </ul>
    </div>
    </nav>

    
    
</body>
</html>