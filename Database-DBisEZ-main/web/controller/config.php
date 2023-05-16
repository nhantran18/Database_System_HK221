<?php
  $servername = "localhost:3306";
  $username = "root";
  $password = "";
  $dbname = "ass_db";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>