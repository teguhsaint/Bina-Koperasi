<?php
if ($_POST) {
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $validate = ['jpg','png'];
        $nama = explode('.', $_FILES['file']['name']);
        if (in_array(end($nama), $validate)) {
        
            $namaAcak = md5(uniqid(mt_rand(), true)).'.'.end($nama);

            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath = 'uploads/';
            move_uploaded_file($tempFile, $namaAcak);
            $kode =  $_POST['agt_kode'];
            $nama = $_POST['agt_nama'];
            $nik =  $_POST['agt_nik'];
            $alamat =$_POST['agt_alamat'];
            $hp =   $_POST['agt_nohp'];
            $ktp    = $namaAcak;
        } else {
            http_response_code(400);
            //bad request
        }
        require_once 'connect.php';
         
        $sql = "INSERT INTO nasabah VALUES('','$kode','$nama','$nik','$alamat','$hp','$ktp')";
        $result=$db->query($sql);
        if ($result) {
            echo json_encode('data tersimpan');
        } else {
            http_response_code(500);
            //internal server error
        }
        
    } else {
        http_response_code(500);
        //internal server error
    }
} else {
    http_response_code(405);
    //methode not allowed
}
