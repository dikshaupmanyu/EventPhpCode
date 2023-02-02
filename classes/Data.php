<?php
require_once '../config.php';

//$sqlQuery = "SELECT student_id,student_name,marks,maths_mark FROM tbl_marks ORDER BY student_id";

$sqlQuery = "SELECT title,description,timeline,file_status FROM filetype ORDER BY id";

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