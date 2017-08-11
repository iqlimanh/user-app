<?php 
$data = json_decode(file_get_contents("php://input"));
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "angularcode";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "INSERT INTO user (email, user_id, username, password, staff_id) VALUES ('$data->email', '$data->user_id', '$data->username', '$data->password', '$data->staff_id')";
$qry = $conn->query($sql);
$conn->close();
?>