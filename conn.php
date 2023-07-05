<?php
$conn = new mysqli('localhost','root','','newspaper');
if($conn->connect_error){
    die("connection failed".$conn->connect_error);
}
?>