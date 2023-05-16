<?php
require_once('config.php');
$query = "call removeHoadonByID(".$_POST['id'].");";
$res=$conn->query($query);
$tmp = $res->fetch_assoc();
echo $tmp['RES'];
mysqli_free_result($res);
?>