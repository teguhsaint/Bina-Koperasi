<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$respon=[];


// require_once 'connect.php';

// $sql = "update nasabah set agt_nama ='$nama'
// agt_alamat = '$alamat'
// agt_nohp = '$nohp' where id = '$id'" ;
// $result = $db->query($sql);
// if ($result) {
//     $respon['respon']= 'p';
// }
 

// $id = $_POST['id'];
// $nama = $_POST['agt_nama'];
// $alamat = $_POST['agt_alamat'];
// $nohp = $_POST['agt_nohp'];


$respon['respon'] = $_POST;



echo json_encode($respon);
