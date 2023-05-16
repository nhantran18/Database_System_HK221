<?php
require_once('config.php');
$idToGet = $_POST['id'];
if($idToGet==0){
    $query = "SELECT * FROM hoadon";
    $res=$conn->query($query);
    $tmp = $res->fetch_all(MYSQLI_ASSOC);
    echo json_encode($tmp);
    mysqli_free_result($res);
}
else{
    $query = "SELECT * FROM hoadon WHERE ID=".$idToGet;
    $res=$conn->query($query);
    $tmp = $res->fetch_assoc();
    $tmp = array($tmp);
    echo json_encode($tmp);
    mysqli_free_result($res);
}
?>