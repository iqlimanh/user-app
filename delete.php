<?php
$data = json_decode(file_get_contents("php://input"));
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "angularcode";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "DELETE FROM user WHERE uid = $data->uid ";
$result = $conn->query($sql);
$conn->close();
?>