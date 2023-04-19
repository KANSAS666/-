<?php
include("manager.php");
include("dataBase.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<script>
  function calculateRental() {
    // Получаем значения выбранных элементов формы
    const client = document.getElementById("client").value;
    const car = document.getElementById("car").value;
    const start = document.getElementById("rental_start").value;
    const end = document.getElementById("rental_end").value;

    document.getElementById("client").value = client;
    document.getElementById("car").value = car;
    document.getElementById("rental_start").value = start;
    document.getElementById("rental_end").value = end;
  }
</script>

<div class="row about">
    <div class="col-lg-4 col-md-4 col-sm-12">


    <form method="POST" action="" id="form" style="left: 5%; top:0%; width: 1wh;">
            <h4>Регистрация договора</h4>
        <label for ="client">Номер водительского удостоверения клиента:</label> 
        <input type="number" name="driverLic" id="driverLic" require class="form-control" value="<?=$_POST["driverLic"]?>"> 

<label for="carClass">Класс машины:</label>
<select name="carClass" id="carClass" class="form-control" onchange="updateMarks()">

  <?php
  $sql_classes = "SELECT * FROM carClass";
  $result_classes = mysqli_query($db, $sql_classes);
  while($class = mysqli_fetch_object($result_classes)) {
    $selectedClass = ($_POST["carClass"] == $class->carClass_id) ? 'selected' : '';
    echo "<option value='$class->carClass_id' $selectedClass>$class->className</option>";
  }
  ?>
</select>

<label for="mark">Марка машины:</label>
<select name="mark" id="mark" class="form-control" onchange="updateModels()">

  <?php
  $selectedMark = isset($_POST['mark']) ? $_POST['mark'] : null;
  if (!empty($selectedMark)) {
    echo "<option value='$selectedMark' selected>$selectedMark</option>";
  }
  ?>
</select>
<label for="model">Модель машины:</label>
<select name="model" id="model" class="form-control">

<?php
  $selectedModelId = isset($_POST['model']) ? $_POST['model'] : null;
  if (!empty($selectedModelId)) {
    $sql_model = "SELECT model FROM cars WHERE car_id = $selectedModelId";
    $result_model = mysqli_query($db, $sql_model);
    $model = mysqli_fetch_object($result_model);
    echo "<option value='$selectedModelId' selected>$model->model</option>";
  }
  ?>
</select>

<script>
function updateMarks() {
  var selectedClass = document.getElementById("carClass").value;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("mark").innerHTML = this.responseText;
      updateModels();
    }
  };
  xhr.open("GET", "getMarks.php?carClass=" + selectedClass, true);
  xhr.send();
}

function updateModels() {
  var selectedMark = document.getElementById("mark").value;
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("model").innerHTML = this.responseText;
    }
  };
  xhr.open("GET", "getModels.php?mark=" + selectedMark, true);
  xhr.send();
}
</script>
            <label for="rental_start">Дата выдачи:</label>
		<input type="date" name="rental_start" id="rental_start" required class="form-control" value="<?=$_POST["rental_start"]?>">
		
		<label for="rental_end">Дата возврата:</label>
		<input type="date" name="rental_end" id="rental_end" required class="form-control" value="<?=$_POST["rental_end"]?>">
		
		<label for="rental_rate">Сумма залога:</label> <br>
		<input type="number" name="rental_rate" id="rental_rate" readonly> <br>
		
		<button type="submit" name="sum" style="margin-top: 10px; margin-bottom: 5px;background-color: #20B2AA" class="btn btn-primary">
    Рассчитать сумму аренды</button> <br>
      

        <label for="price">Общая сумма аренды:</label> <br>
		<input type="number" name="price" id="price" readonly> <br>
        <button type="submit" name="create_contract"style="margin-top: 10px; background-color: #20B2AA" class="btn btn-primary">Создать договор</button>
        </form>

    <?php
  if (isset($_POST['sum'])) {
    $start = $_POST['rental_start'];
    $end = $_POST['rental_end'];
    $car_id = $_POST['model'];
    $driverLic = $_POST['driverLic'];
    $sql_client = "SELECT ID_Client FROM clients WHERE driverLicense = '$driverLic'";
    $result_client = mysqli_query($db, $sql_client);
    $client = mysqli_fetch_object($result_client)->ID_Client;
    


    $rental_rate = 0;
    $deposit = 0;
    
    //????????????
    $sql = "SELECT carClass_id FROM cars WHERE car_id = $car_id";
    $result = mysqli_query($db, $sql);
    $carClass_id = mysqli_fetch_object($result)->carClass_id;

    // Получаем тариф за день из базы данных для указанного автомобиля
    $sql = "SELECT dailyTarif FROM cars WHERE car_id='$car_id'";
    $result_select = mysqli_query($db, $sql);
    if ($object = mysqli_fetch_object($result_select)) {
        $rental_rate = $object->dailyTarif;
    }

    // Рассчитываем сумму аренды
    $diff = strtotime($end) - strtotime($start);
    $days = floor($diff / (60 * 60 * 24));
    $rental_price = $days * $rental_rate;

    // Записываем сумму аренды в поле ввода на странице
    echo "<script>document.getElementById('price').value = $rental_price;</script>";

    // Получаем залог за автомобиль из базы данных
    $sql = "SELECT deposit FROM carClass WHERE carClass_id='$carClass_id'";
    $result_select = mysqli_query($db, $sql);
    if ($object = mysqli_fetch_object($result_select)) {
        $deposit = $object->deposit;
    }

    // Записываем залог в поле ввода на странице
    echo "<script>document.getElementById('rental_rate').value = $deposit;</script>";
   
}

?>
<?php

if(isset($_POST['create_contract'])) {
  // Получаем значения из формы
  $driveLic = $_POST['driverLic'];
  $id_client = "SELECT ID_Client FROM clients WHERE driverLicense = $driveLic";
  echo "<h1>$id_client</h1>";
  $result_client = mysqli_query($db, $id_client);
  $client = mysqli_fetch_object($result_client)->ID_Client;

  $car_id = $_POST['model'];

  $rental_start = $_POST['rental_start'];
  $rental_end = $_POST['rental_end'];
  //$rental_rate = $_POST['rental_rate'];
  $dep = $_POST['rental_rate'];
  $rental_price = $_POST['price'];

  // Формируем запрос для добавления данных в таблицу
  $sql = "INSERT INTO contract (ID_Client, car_id, startDate, endDate, price, Deposit)
   VALUES ('$client', '$car_id', '$rental_start', '$rental_end', '$rental_price', '$dep')";

  // Выполняем запрос
  if(mysqli_query($db, $sql)) {
    echo "Данные успешно добавлены в таблицу contract";
    echo "<script> document.location.href = 'contracts.php'</script>";
  } else {
    echo "Ошибка: " . mysqli_error($db);
  }

  $sql = "UPDATE cars SET Status = 1 WHERE car_id = $car_id";
  $result_update = mysqli_query($db, $sql);
  if ($result_update == FALSE)
  {
    echo "Ошибка: " .mysqli_error($db);
  }
}
?>

</div>
    <div class="col-lg-8 col-md-8 col-sm-12 desc">
      <div>
<form method="POST" action="" id="form" style="left: 5%; top: 0%; width: 1wh;">
        <h4>Сортировать по фамилии</h4>
        <div class="form-group">
            <input type="text" name="search_term" class="form-control" placeholder="Введите фамилию">
        </div>
        <button type="submit" name="search" class="btn btn-primary search-btn" style="background-color: #20B2AA">Искать</button>
        <button type="submit" name="show_all" class="btn btn-primary show-all-btn" style="background-color: #20B2AA">Показать всех</button> 
        <style>
        .search-btn, .show-all-btn {
  margin-bottom: 20px;
}
</style>
    </form>
</div>
    
        <div>
    
        <?php

$first = 0;
$kol = 5;
$page = 1;

if (isset($_GET['page'])){
    $page = $_GET['page'];
}else $page = 1;

$first = ($page * $kol) - $kol;

$sql = "SELECT COUNT(*) FROM contract";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_row($result); //
$total = $row[0]; //
$str_pag = ceil($total/$kol);
for ($i = 1; $i <= $str_pag; $i++){
    echo "<a href=contracts.php?page=".$i.">Страница ".$i."</a>"."|";
}

            $sql = "SELECT contract_id, startDate, endDate, price, Deposit, contract.car_id, contract.ID_Client, clients.firstName, clients.lastName,
            clients.fatherName, cars.mark, cars.model, cars.gosnomer FROM contract JOIN clients ON contract.ID_Client = clients.ID_Client
            JOIN cars ON contract.car_id = cars.car_id WHERE contract.endContractDate IS NULL LIMIT $first, $kol";
            //$result = mysqli_query($db, $sql);

            if (isset($_POST['search']))
            {
              $search_term = $_POST['search_term'];
              //echo "<h1>$search_term</h1>";

              $sql = "SELECT contract_id, startDate, endDate, price, Deposit, contract.car_id, contract.ID_Client, clients.firstName, clients.lastName,
        clients.fatherName, cars.mark, cars.model, cars.gosnomer 
        FROM contract 
        JOIN clients ON contract.ID_Client = clients.ID_Client
        JOIN cars ON contract.car_id = cars.car_id 
        WHERE contract.endContractDate IS NULL AND clients.lastName = '$search_term'";
        $result = mysqli_query($db, $sql);

            }
            if (isset($_POST['show_all'])){
              $sql = "SELECT contract_id, startDate, endDate, price, Deposit, contract.car_id, contract.ID_Client, clients.firstName, clients.lastName,
            clients.fatherName, cars.mark, cars.model, cars.gosnomer FROM contract JOIN clients ON contract.ID_Client = clients.ID_Client
            JOIN cars ON contract.car_id = cars.car_id WHERE contract.endContractDate IS NULL";
            }
            $result = mysqli_query($db, $sql);
            
            echo "<h4>Действующие договоры</h4>";
            echo "<table class='table table-bordered table-sm' style='background:#12c8be'>
            <tr class='table-primary' ><th style='background:#20B2AA'>№</th><th style='background:#20B2AA'>Клиент</th>
            <th style='background:#20B2AA'>Авто</th><th style='background:#20B2AA'>Госномер</th>
            <th style='background:#20B2AA'>Дата выдачи</th><th style='background:#20B2AA'>Дата возврата</th>
            <th style='background:#20B2AA'>Сумма залога</th><th style='background:#20B2AA'>Сумма аренды</th><th style='background:#20B2AA'></th>";

            while ($myrow=mysqli_fetch_array($result)){


                $clientN= $myrow['lastName'].' '.$myrow['firstName'].' '.$myrow['fatherName'];
                $carN = $myrow['mark'].' '.$myrow['model'];
                //$sumOfRenta=1100000;
                echo "<tr>";
                echo "<td>".$myrow['contract_id']."</td>";
                echo "<td>".$clientN."</td>";
                echo "<td>".$carN."</td>";
                echo "<td>".$myrow['gosnomer']."</td>";
                echo "<td>".$myrow['startDate']."</td>";
                echo "<td>".$myrow['endDate']."</td>";
                echo "<td>".$myrow['Deposit']."</td>";
                echo "<td>".$myrow['price']."</td>";


                echo "<td>

                <button type='button' name='submit' value='' class='btn btn-danger' data-toggle='modal' data-target='#myModal'
                     data-contract='".$myrow['contract_id']."' data-fio='".$clientN."' data-car_n='".$carN."'>
                        Закрыть договор
                    </button>
            </td>
            ";
           
                echo "</tr>";
            }
            echo "</table>" 
            ?>    
    </div>
          </div>
          </div>


    <!--  модальноe окнo -->
 <!--  модальноe окнo -->
 <div id="myModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <h4 class="modal-title">Закрытие договора</h4>
      </div>
      <!-- Основное содержимое модального окна -->
       <div class="modal-body">  
         <form  method="POST"  action="">
      
<?php

echo '<div class="form-group"><label for="fio">Клиент:</label><br><input type="text" id="fio" name="fio" readonly class="form-control"></div>';
echo '<div class="form-group"><label for="car_n">Машина:</label><input type="text" id="car_n" name="car_n" readonly class="form-control"></div>'; 
echo '<div class="form-group"><label for="contractEnd">Дата фактического возврата:</label><br><input type="date" id="contractEnd" name="contractEnd"
 class="form-control"></div>';
 echo '<div class="form-group"><label for="factDist">Фактический пробег:</label><br><input type="nubmer" id="factDist" name="factDist"
 class="form-control"></div>';

 echo '<br><input type="hidden" id="idContract" name="idContract">'; 

?>

</div>
<!-- Футер модального окна -->
<div class="modal-footer">
 <button type="button" class="close" data-dismiss="modal" 
aria-hidden="true">Отмена</button>
 <button type="submit" name="submit" class="btn btn-danger">Закрыть договор</button>
</form>
 </div>
</div>
</div>
 </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Вызов модального окна -->

<script>
$(document).ready(function(){
  $('#myModal').on('show.bs.modal', function (event) {
// кнопка, которая вызывает модаль
 var button = $(event.relatedTarget);
// получим  data-idEdu атрибут
  var idContract = button.data('contract');
// получим  data-fio атрибут
  var fio = button.data('fio');
  var car_n = button.data('car_n');
   // Здесь изменяем содержимое модали
  var modal = $(this);
 modal.find('.modal-title').text('Договор № ' + idContract);
 modal.find('.modal-body #fio').val(fio);
 modal.find('.modal-body #car_n').val(car_n);
 modal.find('.modal-body #idContract').val(idContract);
})
});


</script>

<?php
    if (ISSET($_POST['submit']))
    {
        $contractEnd = $_POST['contractEnd'];
        $idContract = $_POST['idContract'];
        $factDistance = $_POST['factDist'];
        //echo date("Y-m-d", strtotime($contractEnd) );
        echo "<h1>$contractEnd</h1> <br> <h1>$idContract</h1>" ;

        
        $sql="UPDATE contract SET endContractDate = '$contractEnd' WHERE contract_id = $idContract";
        $result = mysqli_query($db, $sql);
        if ($result == TRUE){
            echo "Данные успешно сохранены!";
            echo "<script> document.location.href = 'contracts.php'</script>";
        }
        else{
            echo "Ошибка". mysqli_error($db);
            
        }
        $sql = "UPDATE cars SET Status = 0, factDistance = $factDistance WHERE car_id = (SELECT car_id FROM contract WHERE contract_id = $idContract)";
        $result = mysqli_query($db, $sql);
        if ($result == FALSE){
          echo "Ошибка". mysqli_error($db);
        }
    }
?>

 <!-- jQuery (Cloudflare CDN) -->
 <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
 integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" 
 crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Bootstrap Bundle JS (Cloudflare CDN) -->
  <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.min.js"
   integrity="sha512-UR25UO94eTnCVwjbXozyeVd6ZqpaAE9naiEUBK/A+QDbfSTQFhPGj5lOR6d8tsgbBk84Ggb5A3EkjsOgPRPcKA==" 
   crossorigin="anonymous" referrerpolicy="no-referrer"></script>
