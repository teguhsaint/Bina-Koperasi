<?php
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Asia/Jakarta');
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
                        require_once '../conf/validasi.php';
                        $coba = new Test();
                        $coba->form(
                            $db,
                            $_POST['agt_kode'],
                            $_POST['agt_nama'],
                            $_POST['agt_nik'],
                            $_POST['agt_alamat'],
                            $_POST['agt_nohp']
                        );
                        
                        $hasil= $coba->get();
                        if (empty($hasil['msg'])) {
                            
                            $tempFile = $_FILES['file']['tmp_name'];
                            $targetPath = '../uploads/';
                            move_uploaded_file($tempFile, $targetPath . $namaAcak);
                            $kode = $hasil['kode'];
                        
                            $nama = $hasil['nama'];
                            $nik = $hasil['nik'];
                            $alamat = $hasil['alamat'];
                            $hp = $hasil['hp'];
                            $ktp = $db->real_escape_string(htmlspecialchars($namaAcak));
                            $tglmasuks = $db->real_escape_string(htmlspecialchars(date("Y-m-d")));

                            $sql = "INSERT INTO nasabah VALUES('', '$kode', '$nama', '$nik', '$alamat', '$hp', '$ktp','$tglmasuks')";
                            $result = $db->query($sql);
                            if ($db->affected_rows > 0) {
                                $respon['respon'] = 'data berhasil tersimpan';
                            } else {
                                $respon['respon'] = 'gagal menyimpan data';
                            }
                        } else {
                            $respon['respon'] = $hasil['msg'];
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

if (isset($_POST['aksi']) && $_POST['aksi'] == 'edit') {
    require_once 'connect.php';
   

    $id = $_POST['id'];
    $nama = $_POST['agt_nama'];
    $alamat = $_POST['agt_alamat'];
    $nohp = $_POST['agt_nohp'];
    $nik  = $_POST['agt_nik'];

    $sql = "update nasabah
        set agt_nama ='$nama',
            agt_alamat ='$alamat',
            agt_nohp ='$nohp',
            agt_nik  = '$nik'
        where agt_id ='$id'";
    $db->query($sql);
    if ($db->affected_rows > 0) {
        $respon['respon'] = 'data berhasil disimpan';
    } else {
        $respon['respon'] = 'tidak ada data yang di ubah';
    }

}
echo json_encode($respon);
