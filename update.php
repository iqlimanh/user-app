<?php 
$data = json_decode(file_get_contents("php://input"));
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "angularcode";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "UPDATE user SET 
email ='$data->email', user_id ='$data->user_id', username ='$data->username',
password ='$data->password', staff_id ='$data->staff_id' WHERE uid = $data->uid ";
// coba
$qry = $conn->query($sql);
$conn->close();
?>