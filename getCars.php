<?php
include("dataBase.php");

$selected_class = isset($_GET['carClass']) ? $_GET['carClass'] : null;
$sql_cars = "SELECT cars.car_id, cars.carClass_id, cars.mark, cars.model, carClass.className AS className FROM cars INNER JOIN 
  carClass ON cars.carClass_id = carClass.carClass_id WHERE cars.Status = 0 AND cars.carClass_id = $selected_class";
$result_cars = mysqli_query($db, $sql_cars);
while($car = mysqli_fetch_object($result_cars)) {
    $carName = $car->mark . ' ' . $car->model;
    $selectedCar = ($_GET["selectedCar"] == $car->car_id) ? 'selected' : ''; // проверяем, выбрана ли машина
    if ($selectedCar == '' && isset($_GET['selectedCar']) && $_GET['selectedCar'] == $car->car_id) {
      $selectedCar = 'selected'; // устанавливаем выбранную машину
    }
    echo "<option value='$car->car_id' $selectedCar>$carName</option>";
  }
?>