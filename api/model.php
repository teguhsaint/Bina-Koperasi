<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


function koneksi()
{
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'db_koperasi';
    $koneksi = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    return $koneksi;
}

function insert_data($table_name, $data)
{
    $data_to_arrayread = implode(",", $data);
    $query = "INSERT INTO $table_name VALUES(NULL,$data_to_arrayread)";
    mysqli_query(koneksi(), $query);
}

function select_data($table_name)
{
    $query = "SELECT * FROM $table_name";
    $result = mysqli_query(koneksi(), $query);
    return $result;
}
function select_data_custom($querys)
{
    $query = $querys;
    $result = mysqli_query(koneksi(), $query);
    return $result;
}

function select_data_for_edit($table_name, $where, $where_value)
{
    $query = "SELECT * FROM $table_name WHERE $where=$where_value";
    $result = mysqli_query(koneksi(), $query);
    return $result;
}

function update_data($table_name, $where, $where_value, $set_data)
{
    $imp_data = implode(",", $set_data);

    $query = "UPDATE $table_name SET $imp_data WHERE $where=$where_value";

    mysqli_query(koneksi(), $query);
}

function delete_data($table_name, $where, $where_value)
{
    $query = "DELETE FROM $table_name WHERE $where=$where_value";

    mysqli_query(koneksi(), $query);
}

if (!empty($_POST['pr'])) {

    $perintah = $_POST['pr'];

    switch ($perintah) {
        case 'ambil_kodeterakhir':
            $kd = $_POST['kode_ao'];
            $que = "SELECT * FROM nasabah WHERE agt_kode LIKE '%" . $kd . "_%' ORDER bY agt_id DESC LIMIT 1;";
            $hasil = select_data_custom($que);

            $kode_terakhir = '';
            while ($a = mysqli_fetch_assoc($hasil)) {
                $kode_terakhir = $a['agt_kode'];
            }

            if ($kode_terakhir !== '') {
                echo json_encode($kd . '_' . explode("_", $kode_terakhir)[1] + 1);
            } else {
                $kode_terakhir = $kd . '_' . 1;
                echo json_encode($kode_terakhir);
            }


            break;
        case 'ambil_ao':
            $hasil = select_data('ao');
            $aokod = [];
            while ($a = mysqli_fetch_assoc($hasil)) {
                array_push($aokod, array('kode' => $a['kode_ao'], 'nama' => $a['nama_ao']));
            }

            echo json_encode($aokod);

            break;

        case 'statistik_nasabah_masuk':
            $hasil = select_data_custom('SELECT COUNT(agt_id) as jumlah_masuk, agt_tglmasuk as tgl FROM nasabah GROUP BY agt_tglmasuk;');
            $aokod = [];
            while ($a = mysqli_fetch_assoc($hasil)) {
                array_push($aokod, array('tgl' => $a['tgl'], 'jumlah' => $a['jumlah_masuk']));
            }

            echo json_encode($aokod);

            break;

        case 'statistik_nasabah_perresort':

            $hasil1  =  select_data('ao');
            $hsa = [];
            while ($data = mysqli_fetch_assoc($hasil1)) {
                $hasil2 = select_data_custom('SELECT COUNT(agt_id) as jaresort FROM nasabah WHERE agt_kode LIKE "%' . $data['kode_ao'] . '%";');

                while ($a = mysqli_fetch_assoc($hasil2)) {
                    array_push($hsa, array($data['kode_ao'] => $a['jaresort']));
                }
            }
            echo json_encode($hsa);

            break;
        default:
            # code...
            break;
    }
}
