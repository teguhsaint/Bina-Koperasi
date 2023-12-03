<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 


require_once 'connect.php';
$id = $_POST['id'];
$sql = "select * from nasabah where agt_id = '$id'";
$res =$db->query($sql);

$data = [];

while ($a = $res->fetch_assoc()) {
    $data['data'] = $a;
}
echo json_encode($data);
