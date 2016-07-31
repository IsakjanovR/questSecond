

<div class="main">
    <form action="" method="post">
       <lable>From</lable> <input type="date" name="From">
        <lable>To</lable> <input type="date" name="To">
        <input type="submit">
    </form>

</div>
<?php
include "connect.php";


if (!empty($_POST)){
    $fromDate = $_POST['From'];
    $toDate = $_POST['To'];

    $query2 = mysqli_query($db_connect, "SELECT * FROM `payments` 
WHERE `finish_time` > '$fromDate 00:00:00' 
AND `finish_time` < '$toDate 00:00:00'");

    $query = mysqli_query($db_connect, "SELECT * FROM `payments`, `documents` 
WHERE payments.finish_time > '$fromDate 00:00:00' 
AND payments.finish_time < '$toDate 00:00:00' 
AND payments.id = documents.entity_id");
    $arr = array();
    while ($row = mysqli_fetch_assoc($query)) {
        $arr[] = $row['amount'];
    }
    $arr2 = array();
    while ($row2 = mysqli_fetch_assoc($query2)) {
        $arr2[] = $row2['amount'];
    };
    $sum = array_sum($arr);
    $sum2 = array_sum($arr2);
    $sum3 = $sum2 - $sum;
    $count1 = mysqli_num_rows($query);
    $count2 = mysqli_num_rows($query2);
    $count3 = $count2-$count1;


    echo "<div class='table'>
        <a>Количество заказов = {$count2} Сумма заказов = $sum2</a>
        <br>
        <a>Количество заказов с документами = {$count1} Сумма заказов = $sum </a>
        <br>
        <a>Количество заказов без документами = {$count3} Сумма заказов = $sum3 </a>

    </div>";
}


?>