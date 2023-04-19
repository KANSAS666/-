
<?php
include("accountant.php");
include("dataBase.php");
?>

<div class="row about">
    <div class="col-lg-4 col-md-4 col-sm-12">
        <form method="POST" action="" id="form" style="left: 5%; top:0%; width: 1wh;">
            <h4>Добавить машину</h4>
            <label for="carClass">Класс машины:</label>
<select name="carClass" id="carClass" required class="form-control">
  <?php
  $sql_classes = "SELECT * FROM carClass";
  $result_classes = mysqli_query($db, $sql_classes);
  while($class = mysqli_fetch_object($result_classes)) {
    $selectedClass = ($_POST["carClass"] == $class->carClass_id) ? 'selected' : '';
    echo "<option value='$class->carClass_id' $selectedClass>$class->className</option>";
  }
  ?>
</select>
<label for="carMark">Марка машины:</label>
<input type="text" name="carMark" id="carMark" required class="form-control">

<label for="carModel">Модель машины:</label>
<input type="text" name="carModel" id="carModel" required class="form-control">

<label for="carSits">Количество мест:</label>
<input type="number" name="carSits" id="carSits" required class="form-control">

<label for="carDoors">Количество дверей:</label>
<input type="number" name="carDoors" id="carDoors" required class="form-control">

<label for="carNumber">Госномер:</label>
<input type="text" name="carNumber" id="carNumber" required class="form-control">

<label for="carCondition">Наличие кондиционера:</label>
<input type="checkbox" name="carCondition" id="carCondition"> <br>
<label for="transmission">Тип коробки передач</label>
<select name="transmission" id="transmission" required class="form-control">

<option value="АКПП">АКПП</option>
<option value="МКПП">МКПП</option>
</select>
<label for="carTarif">Тариф за сутки:</label>
<input type="number" name="carTarif" id="carTarif" required class="form-control">




            <button type="submit" name="submit" class='btn btn-primary' style="margin-top: 10px; background-color: #20B2AA">Добавить</button>
        </form>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 desc">
        <?php
          
          $sql = "SELECT carClass.className, cars.mark, cars.model, cars.gosnomer, cars.factDistance, cars.dailyTarif
          FROM cars
          INNER JOIN carClass ON cars.carClass_id = carClass.carClass_id";
          $result = mysqli_query($db, $sql);
          if (!$result) {
            die('Ошибка выполнения запроса: ' . mysqli_error($db));
          }
         
            echo "<h4>Информация об автомобилях</h4>";
            echo "<table class='table table-bordered table-sm' style='background: #12c8be'>
            <tr class='table-primary' style='background-color:#20B2AA'><th style='background:#20B2AA'>Класс</th><th style='background:#20B2AA'>Марка</th>
            <th style='background:#20B2AA'>Модель</th><th style='background:#20B2AA'>Госномер</th>
            <th style='background:#20B2AA'>Фактический пробег</th><th style='background:#20B2AA'>Тариф за сутки</th>";

            while ($myrow=mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>".$myrow['className']."</td>";
                echo "<td>".$myrow['mark']."</td>";
                echo "<td>".$myrow['model']."</td>";
                echo "<td>".$myrow['gosnomer']."</td>";
                echo "<td>".$myrow['factDistance']."</td>";
                echo "<td>".$myrow['dailyTarif']."</td>";              
                echo "</tr>";
            }
            echo "</table>"
        ?>
    </div>
</div>


<?php
if (isset($_POST['submit']))
{
    
    $class = $_POST["carClass"];
    $mark = $_POST["carMark"];
    $model = $_POST["carModel"];
    $sits = $_POST["carSits"];
    $doors = $_POST["carDoors"];
    $number = $_POST["carNumber"];

    //$condition = $_POST["carCondition"];
    $condition = isset($_POST["carCondition"]) ? 1 : 0;
    $transmission = $_POST["transmission"];
    $tarif = $_POST["carTarif"];
    

    $sql="INSERT INTO `cars`(`mark`, `model`, `carClass_id`, `numSeats`, `numDoors`,
     `gosnomer`, `hasAirConditioner`, `transmission`, `dailyTarif`)
    VALUES ('$mark', '$model', $class, $sits, $doors,'$number', '$condition', '$transmission', $tarif)";

    $result=mysqli_query($db, $sql);
    if ($result == TRUE)
    {
        echo "Данные успешно сохранены!";
        echo "<script> document.location.href = 'Cars.php'</script>";

    }
    else
    {
        echo "Ошибка". mysqli_error($db);
    }
    
    
}
?>

