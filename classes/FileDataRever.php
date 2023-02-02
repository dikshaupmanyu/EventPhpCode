<?php
require_once '../config.php';
 extract($_POST);
$date1 = $_GET['date'];
$date2 = $_GET['date1'];
//echo $date1;
// $date2 = $_POST['endDate'];
//echo $date2;

//$sqlQuery = "SELECT student_id,student_name,marks,maths_mark FROM tbl_marks ORDER BY student_id";

//$sqlQuery = "SELECT title,description,timeline,file_status FROM filetype ORDER BY id";

$sqlQuery = "SELECT * FROM filetype WHERE createdDate BETWEEN '{$date2}' AND '{$date1}'";
// AND file_status = "Pending"';
//echo $sqlQuery;
$result = mysqli_query($conn,$sqlQuery);

// $query = "SELECT title,description,timeline,file_status FROM filetype WHERE file_status == 'Pending'";
// $resultquery = mysqli_query($conn,$query);

// $rowtotal = mysqli_num_rows($resultquery);

$data = array();
foreach ($result as $row) {
  $data[] = $row;
}
echo json_encode($data);
?>