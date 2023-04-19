<?php
    session_start();
    include('accountant.php');
    include('dataBase.php');

    echo "<div class='row about'>
            <div class='col-lg-4 col-md-4 col-sm-12'>
                <form method='POST' action=''>
                    <label for='rb1'>Выбор отчета: </label>
                    <div class='form-check'>
                        <input class='form-check-input' type='radio' name='report' value='1' id='report'>
                        <label class='form-check-label' for='rb1'> Отчет по завершенным договорам</label>
                    </div>
                    <div class='form-check'>
                    <input class='form-check-input' type='radio' name='report' value='2' id='report'>
                    <label class='form-check-label' for='rb1'> Отчет по действующим договорам  </label>
                    </div>
                <button type='submit' name='submit' class='btn btn-primary' style='background-color: #20B2AA'>Просмотр</button>
                </form>
            </div>
            <div class = 'col-lg-8 col-md-8 col-sm-12 desc'>
        "
?>

<?php
    if (isset($_POST['submit']))
    {
        $n = $_POST['report'];

        if($n==1){


$sql = "SELECT contract.price, carClass.className, CONCAT(cars.mark, ' ', cars.model) AS carModel, COUNT(contract.contract_id) 
AS kol, SUM(IF(contract.endContractDate > contract.endDate, contract.price + 
(DATEDIFF(contract.endContractDate, contract.endDate) * cars.dailyTarif), contract.price)) AS summ
FROM contract 
INNER JOIN cars ON contract.car_id = cars.car_id 
INNER JOIN carClass ON cars.carClass_id = carClass.carClass_id 
WHERE contract.endContractDate IS NOT NULL
GROUP BY contract.price, carClass.className, CONCAT(cars.mark, ' ', cars.model) 
ORDER BY COUNT(contract.contract_id) DESC";


            $result = mysqli_query($db, $sql);
            echo "<h4>Отчет по завершенным договорам</h4>";


            echo "<table class='table table-bordered table-sm' style='background: #12c8be'>
                <tr class='table-primary' style='background-color:#20B2AA'><th style='background:#20B2AA'>Класс авто</th><th style='background:#20B2AA'>
                Марка и модель</th><th style='background:#20B2AA'>Количество договоров</th>
                <th style='background:#20B2AA'>Общая сумма</th>
            ";
            $sum = 0;
            $count = 0;
            
            while ($myrow=mysqli_fetch_array($result))
            {
                $sum += $myrow['summ'];
                $count += $myrow['kol'];
                echo "<tr>";
                echo "<td>".$myrow['className']."</td>";
                echo "<td>".$myrow['carModel']."</td>";
                echo "<td>".$myrow['kol']."</td>";
                echo "<td>".$myrow['summ']."</td>";
                echo "<tr>";

            }

            echo "<tr>";
            echo "<td><b>Итого:</b></td><td></td>
                  <td><b>$count</b></td><td><b>$sum</b></td>";
            echo "</td>";
            echo "</table>";
            echo "</div>";
        }

        elseif($n==2){

$sql = "SELECT carClass.className, CONCAT(cars.mark, ' ', cars.model) AS carModel, COUNT(*) AS kol, SUM(contract.price) AS summ 
FROM contract 
INNER JOIN cars ON contract.car_id = cars.car_id 
INNER JOIN carClass ON cars.carClass_id = carClass.carClass_id 
WHERE contract.endContractDate IS NULL
GROUP BY cars.car_id, carClass.className, CONCAT(cars.mark, ' ', cars.model) 
ORDER BY COUNT(*) DESC";



            $result = mysqli_query($db, $sql);
            echo "<h4>Отчет по действующим договорам</h4>";


            echo "<table class='table table-bordered table-sm' style='background:#12c8be'>
                <tr class='table-primary'><th style='background:#20B2AA'>Класс авто</th><th style='background:#20B2AA'>Марка и модель</th>
                <th style='background:#20B2AA'>Количество договоров</th>
                <th style='background:#20B2AA'>Общая сумма</th>
            ";
            $sum = 0;
            $count = 0;

            while ($myrow=mysqli_fetch_array($result))
            {
                $sum += $myrow['summ'];
                $count += $myrow['kol'];
                echo "<tr>";
                echo "<td>".$myrow['className']."</td>";
                echo "<td>".$myrow['carModel']."</td>";
                echo "<td>".$myrow['kol']."</td>";
                echo "<td>".$myrow['summ']."</td>";
                echo "<tr>";

            }

            echo "<tr>";
            echo "<td><b>Итого:</b></td><td></td>
                  <td><b>$count</b></td><td><b>$sum</b></td>";
            echo "</td>";
            echo "</table>";

        }

    }

?>