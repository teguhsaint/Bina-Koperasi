<?php
header('Content-Type: application/json;');
class Model
{
    public $koneksi;
    public $tabel;
    public $respon;
    public $errors = [];
    public $result = [];

    public function __construct(
        $db_host,
        $db_user,
        $db_password,
        $db_name,
        $tabel
    ) {
        try {
            $this->koneksi = mysqli_connect(
                $db_host,
                $db_user,
                $db_password,
                $db_name
            );
            $this->tabel = $tabel;
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
             $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
    }

    public function findAll()
    {
        try {
            $tabel = $this->tabel;
            $query = "select * from $tabel";
        
            $hasil = mysqli_query($this->koneksi, $query);
        
            $item = [];
            while ($a = mysqli_fetch_assoc($hasil)) {
                $item[] = $a;
            }
            $this->respon = ['status' => 'ok',
                        'data' => $item];
        
            echo json_encode($this->respon);
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
             $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
    }
    public function find($kolom, $operator, $nilai)
    {
        try {
            if ($operator == 'eq') {
                $op = "='$nilai'";
            }
            if ($operator == 'lk') {
                $op = "like'$nilai'";
            }
            if ($operator == 'lks') {
                $op = "like'%$nilai%'";
            }
            $tabel = $this->tabel;
            $query = "select * from $tabel where $kolom $op";
            $hasil = mysqli_query($this->koneksi, $query);

            $item = [];
            while ($a = mysqli_fetch_assoc($hasil)) {
                $item[] = $a;
            }
            $this->respon = ['status' => 'ok',
                             'data' => $item];
    
            echo json_encode($this->respon);
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
             $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
    }
    public function input($post)
    {
        try {
            // unset($post['perintah']);
            $data = "";
            foreach ($post as $key => $value) {
                $data .= ",'" . $value . "'";
            }
            $data = substr($data, 1);
            $tabel = $this->tabel;
            $sql = "insert into $tabel values (NULL,$data)";
            $hasil =  mysqli_query($this->koneksi, $sql);
            if ($hasil) {
                if (mysqli_affected_rows($this->koneksi)) {
                    $this->respon = ['status' => 'ok',
                    'message' => 'berhasil'];
                } else {
                    $this->respon = ['status' => 'gagal',
                    'message' => mysqli_error($this->koneksi)];
                }
            } else {
                $this->respon = ['status' => 'gagal',
                'message' => mysqli_error($this->koneksi)];
            }
    
            echo json_encode($this->respon);
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
            $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
        
    }
    
    public function edit($id, $post, $kolom)
    {
        try {
            if (!empty($post[$kolom])) {
                unset($post[$kolom]);
            }
            $data = "";
            foreach ($post as $key => $value) {
                $data .= "," .$key . "=" . "'".$value."'";
                $data = ltrim($data, ',');
    
            }
            $tabel = $this->tabel;
            $sql = "update $tabel set $data where $kolom = '$id'";
            mysqli_query($this->koneksi, $sql);
            if (mysqli_affected_rows($this->koneksi) > 0) {
                $this->respon= ['status'=>'ok','messege'=>'berhasil'];
            }
            echo json_encode($this->respon);
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
            $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
    }
    public function hapus($id, $kolom)
    {
        try {
            $tabel = $this->tabel;
            $sql = "delete from $tabel where $kolom = '$id'";
    
            mysqli_query($this->koneksi, $sql);
            if (mysqli_affected_rows($this->koneksi)) {
                $this->respon= ['status'=>'ok',
                               'messege'=>'berhasil'];
            }
            echo json_encode($this->respon);
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
            $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
    }
    public function upload($file, $post, $path)
    {
        try {
            // unset($post['perintah']);
            $data = "";
            foreach ($post as $key => $value) {
                $data .= ",'" . $value . "'";
            }
            $data = substr($data, 1);
            $tabel = $this->tabel;
            $nama = explode('.', $file['file']['name']);
            $extension = strtolower(end($nama));
            $namaAcak = md5(uniqid(mt_rand()));
            $namaFile = $namaAcak.".".$extension;
            $sql = "insert into $tabel values (NULL,$data,'$namaFile')";
            move_uploaded_file(
                $file['file']['tmp_name'],
                $path.$namaFile
            );
            $hasil =  mysqli_query($this->koneksi, $sql);
            if ($hasil) {
                if (mysqli_affected_rows($this->koneksi)) {
                    $this->respon = ['status' => 'ok',
                    'message' => 'berhasil'];
                } else {
                    $this->respon = ['status' => 'gagal',
                     'message' => mysqli_error($this->koneksi)];
                }
            } else {
                $this->respon = ['status' => 'gagal',
                'message' => mysqli_error($this->koneksi)];
            }
    
            echo json_encode($this->respon);
        } catch (Exception $e) {
            $error = ['status' => 'gagal', 'message' =>
             $e->getMessage(),"trace"=>$e->getTrace()];
            echo json_encode($error);
        }
    }
    public function ambilKodeTerakir($kode_agt)
    {
        $sql = "SELECT max(substring(nasabah.agt_kode,6,2))
                as kodeterakir FROM 
               `nasabah` WHERE nasabah.agt_kode LIKE '%$kode_agt%'";
        $hasil = mysqli_query($this->koneksi, $sql);
        $result = mysqli_fetch_assoc($hasil);
        
        if (mysqli_num_rows($hasil) < 1) {
            $kodeHasil = $kode_agt."_".$result['kodeterakir'].'1';
        } else {
            $kode_agt = explode("_", $kode_agt);
            $kodeterakir=$result['kodeterakir'];
            $kodeHasil = $kode_agt[0]."_".$kodeterakir+1;
        }

        echo json_encode($kodeHasil);
    }
    public function ambilKodePinjaman($kode_agt)
    {
        $sql = "select agt_kode from nasabah where
                agt_kode = '$kode_agt'";
        $hasil = mysqli_query($this->koneksi, $sql);
        $result = mysqli_fetch_assoc($hasil);

        $hapusAo = explode("AO", $result['agt_kode']);
        $hapusunderscore = explode("_", $hapusAo[1]);

        $pinjaman = "select kode_pj from pinjaman where
                     kode_anggota = '$kode_agt'";
        $hasilPinjaman = mysqli_query($this->koneksi, $pinjaman);

        if (mysqli_num_rows($hasilPinjaman) < 1) {
            
            $hasil = "A".intval($hapusunderscore[0]).
            intval($hapusunderscore[1])."-"."1";
        } else {
            $hasil = "A".intval($hapusunderscore[0]).
            intval($hapusunderscore[1])."-"+1;

        }
        
        echo json_encode($hasil);
        
    }
}

// penggunaan
$request = $_SERVER['REQUEST_METHOD'];
$test = new Model("localhost", "root", "", "db_koperasi", "tabungan");

switch ($request) {
    case 'GET':
        $ambilParam = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
        switch ($ambilParam[0]) {
            case 'allnasabah':
                $test->findAll();
                break;
            case 'cari':
                $test->find($ambilParam[1], $ambilParam[2], $ambilParam[3]);
                break;
            case 'ambilkode':
                $test = new Model("localhost", "root", "", "db_koperasi", "nasabah");
                $test->ambilKodeTerakir($ambilParam[1]);
                break;
            case 'ambilkodepinjaman':
                $test->ambilKodePinjaman($ambilParam[1]);
                break;
        }
        break;
    case 'POST':
        $ambilParam = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
        $perintah = $ambilParam[0];
        if ($perintah == 'input') {
            $test->input($_POST);
        } elseif ($perintah == 'upload') {
            $test = new Model("localhost", "root", "", "db_koperasi", "nasabah");
            $test->upload($_FILES, $_POST, 'upload/');
        }
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $PUT);
        
        $test->edit($PUT['id_tbg'], $PUT, "id_tbg");
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $DELETE);
        $test->hapus($DELETE['id_tbg'], $DELETE['kolom']);
        break;
}
