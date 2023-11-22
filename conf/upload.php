<?php
header("Content-Type: application/json; charset=UTF-8");
$respon = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['agt_kode'])) {
        $respon['respon']='kode wajib diisi';
    } elseif (!isset($_POST['agt_nama'])) {
        
        $respon['respon']='nama wajib diisi';
    } elseif (!isset($_POST['agt_nik'])) {
        $respon['respon']='nik wajib diisi';
    } elseif (!isset($_POST['agt_alamat'])) {
        $respon['respon']='alamat wajib diisi';
    } elseif (!isset($_POST['agt_nohp'])) {
        $respon['respon']='nomer telepon wajib diisi';
    } else {
        if (!empty($_FILES['file']['name'])) {
            if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $validate = ['jpg', 'png'];
                $nama = explode('.', $_FILES['file']['name']);
                $file_extension = strtolower(end($nama));
                if (in_array($file_extension, $validate)) {
                    if ($_FILES['file']['size'] < 10 * 1024 * 1024) {
                        $namaAcak = md5(uniqid(mt_rand(), true)) . '.' . $file_extension;

                        require_once 'connect.php';
                        
                        $tempFile = $_FILES['file']['tmp_name'];
                        $targetPath = '../uploads/';
                        move_uploaded_file($tempFile, $targetPath . $namaAcak);
                        $kode = $db->real_escape_string(htmlspecialchars($_POST['agt_kode']));
                        $nama = $db->real_escape_string(htmlspecialchars($_POST['agt_nama']));
                        $nik = $db->real_escape_string(htmlspecialchars($_POST['agt_nik']));
                        $alamat = $db->real_escape_string(htmlspecialchars($_POST['agt_alamat']));
                        $hp = $db->real_escape_string(htmlspecialchars($_POST['agt_nohp']));
                        $ktp = $db->real_escape_string(htmlspecialchars($namaAcak));
                        $tglmasuks = $db->real_escape_string(htmlspecialchars(date('Y-m-d')));

                        $sql = "INSERT INTO nasabah VALUES('', '$kode', '$nama', '$nik', '$alamat', '$hp', '$ktp','$tglmasuks')";
                        $result = $db->query($sql);
                        if ($result) {
                            $respon['respon'] = 'data berhasil tersimpan';
                        } else {
                            $respon['respon'] = 'gagal menyimpan data';
                        }
                        
                    } else {
                        $respon['respon'] = 'ukuran maksimal 5 mb';
                    }
                } else {
                    $respon['respon'] = 'extensi file tidak sesuai';
                }
            } else {
                $respon['respon'] = 'upload gagal';
            }
        } else {
            $respon['respon'] = 'ktp wajib diisi';
        }
    
    }
} else {
    $respon['respon'] = 'method tidak sesuai';
}
echo json_encode($respon);
