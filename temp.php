<?php 

$date = "25-10-2016";
$newdate = strtotime('-3 day', strtotime($date));
$newdate = date("d-m-y", $newdate);
echo $newdate."<br>";
echo date("d-m-y");

?>