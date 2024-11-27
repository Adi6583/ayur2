<?php
$conn = mysqli_connect("localhost", "root", "", "ayurveda2");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>