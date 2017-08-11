<?php 
//require_once 'dbConnect.php';
$con = mysqli_connect("localhost", "root", "", "angularcode");
$query = "SELECT * FROM user";
$result = mysqli_query($con, $query);
$arr = array();
$numb = 0;
if(mysqli_num_rows($result) != 0){
    while ($row = mysqli_fetch_assoc($result)) {
        $arr[] = $row;
        $numb++;
    }
}
echo $json_info = json_encode($arr);
?>