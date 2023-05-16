<?php
require_once('config.php');
$type = $_POST['type'];
$query = "SELECT count(id) AS count FROM hoadon WHERE Phuongthuc='".$type."'";
$res=$conn->query($query);
$tmp = $res->fetch_assoc();
$ret['count'] = $tmp['count'];
mysqli_free_result($res);

$query = "SELECT sum(Phidonhang) AS total FROM hoadon WHERE Phuongthuc='".$type."'";
$res=$conn->query($query);
$tmp = $res->fetch_assoc();
$ret['totalCost'] = $tmp['total'];
mysqli_free_result($res);

$query = "SELECT sum(Phigiaohang) AS total FROM hoadon WHERE Phuongthuc='".$type."'";
$res=$conn->query($query);
$tmp = $res->fetch_assoc();
$ret['totalShip'] = $tmp['total'];
mysqli_free_result($res);

echo json_encode($ret);
?>