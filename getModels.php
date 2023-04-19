<?php
include("dataBase.php");

$selected_mark = isset($_GET['mark']) ? $_GET['mark'] : null;
$sql_models = "SELECT car_id, model FROM cars WHERE Status = 0 AND mark = '$selected_mark'";
$result_models = mysqli_query($db, $sql_models);
while($model = mysqli_fetch_object($result_models)) {
  $selectedModel = ($_GET["selectedModel"] == $model->car_id) ? 'selected' : '';
  echo "<option value='$model->car_id' $selectedModel>$model->model</option>";
}
?>
