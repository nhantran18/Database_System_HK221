<?php
require_once('config.php');
$query = "CALL updateHoadonByID(?,?,?,?)";
$stmt = $conn->prepare($query);

$selected_id=intval($_POST['selected_id']);
$phuongthuc=$_POST['phuongthuc'];
$phigiaohang = intval($_POST['phigiaohang']);
$IDdonhang = intval($_POST['IDdonhang']);

$stmt->bind_param('isii',$selected_id,$phuongthuc,$phigiaohang,$IDdonhang);
$stmt->execute();

$result = $stmt->get_result();
$tmp = $result->fetch_assoc();
echo $tmp["RES"];
?>