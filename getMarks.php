<?php
include("dataBase.php");

$selected_class = isset($_GET['carClass']) ? $_GET['carClass'] : null;
$sql_marks = "SELECT DISTINCT mark FROM cars WHERE Status = 0 AND carClass_id = $selected_class";
$result_marks = mysqli_query($db, $sql_marks);
while($mark = mysqli_fetch_object($result_marks)) {
  echo "<option value='$mark->mark'>$mark->mark</option>";
}
?>


