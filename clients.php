
<?php
include("manager.php");
?>
<?php
    $servername = "localhost";
    $database = "carRental";
    $user = "root";
    $password = '';
    $db = mysqli_connect($servername, $user, $password, $database);
    if (!$db){
        die("Connection failed: ". mysqli_connect_error());
    }
?>

<div class="row about">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <form method="POST" action="" id="form" style="left: 5%; top:0%; width: 1wh;">
            <h4>Регистрация клиента</h4>
        <label for ="lastname">Фамилия:</label>
        <input type="text" name="last_name" id="last_name" required class="form-control"> 
        <label for ="first_name">Имя:</label>
        <input type="text" name="first_name" id="first_name" required class="form-control"> 
        <label for ="father_name">Отчество:</label>
        <input type="text" name="father_name" id="father_name" required class="form-control"> 
        <label for ="passport">Серия и номер паспорта:</label>
        <input type="number" name="passport" id="passport" required class="form-control"> 
        <label for ="driver_lic">Номер водительского удостоверения:</label>
        <input type="number" name="driver_lic" id="driver_lic" required class="form-control"> 
        <label for ="phone_number">Номер телефона:</label>
        <input type="text" name="phone_number" id="phone_number" required class="form-control"> 
        <label for ="birth_date">Дата рождения:</label>
        <input type="date" name="birth_date" id="birth_date" required class="form-control"> 	
		<input type="submit" name="submit" value="Зарегистрировать" style="margin-top: 10px; background-color: #20B2AA" class="btn btn-primary">
        </form>
    </div>

    <?php
        if (isset($_POST['submit'])){
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $fatherName = $_POST['father_name'];
            $phoneNumber = $_POST['phone_number'];
            $passport = $_POST['passport'];
            $driverLicense = $_POST['driver_lic'];
            $birthDate = $_POST['birth_date'];

            $mysql = "INSERT INTO `clients`(`firstName`, `lastName`, `fatherName`, `phoneNumber`, `passport`, `driverLicense`, 
            `birthDate`) VALUES ('$firstName','$lastName','$fatherName','$phoneNumber','$passport','$driverLicense','$birthDate')";

            $result=mysqli_query($db,$mysql);

            if($result == TRUE)
            {
                echo "Данные успешно сохранены!";
                echo "<script> document.location.href = 'clients.php'</script>";
            }
            else{
                 echo "Ошибка";
            }


        }
    ?>
</div>

