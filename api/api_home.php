<?php

header('Access-Control-Allow-Origin: *');
include 'model.php';

$command = $_GET['command'];
switch ($command) {
    case 'statistik_resort':
        echo json_encode(statistik_resort());
        break;
    case 'statistik_nasabah_masuk':
        echo json_encode(statitik_nasabah_masuk());
        break;
    case 'timeline':
        echo timeline();
        break;
    case 'pinjaman_singkat':
        echo get_pinjaman_singkat();
        break;
    case 'get_nasabah':
        echo get_nasabah();
        break;
    default:
        # code...
        break;
}

function converttanggal($tanggal)
{
    $date = date_create($tanggal);
    return date_format($date, "d M y");
}

function timeline()
{

    $hasil = select_data_custom('SELECT * FROM nasabah ORDER BY agt_id DESC LIMIT 5');
    $html = '';

    while ($nasa = mysqli_fetch_assoc($hasil)) {
        $html .= "
        <li class='timeline-item'>
        <strong><a href='javascript:void(0)' class='text-decoration-none text-body'>" . $nasa['agt_nama'] . "</a></strong>
        <span class='float-end text-success text-sm'>";
        $html .= "" . $nasa['agt_tglmasuk'] . "";
        $html .= "</span>
        <p class='text-muted'>" .  $nasa['agt_alamat'] . "</p>
        </li>";
    }
    return $html;
}

function get_pinjaman_singkat()
{

    $hasil = select_data_custom('SELECT * FROM nasabah JOIN pinjaman ON nasabah.agt_kode= pinjaman.kode_anggota ORDER BY pinjaman.id_pinjam DESC LIMIT 5;');
    $html = '';
    $no = 0;
    while ($nasa = mysqli_fetch_assoc($hasil)) {
        $no++;
        $html .= "
        <tr>
        <th>" . $no . "</th>
        <th>" . converttanggal($nasa['tanggal']) . "</th>
        <th><a href='javascript:void(0)' class='text-decoration-none'>" . $nasa['agt_nama'] . "</a></th>
        <th>" . $nasa['agt_kode'] . "</th>
        <th>Rp." . number_format($nasa['jumlah'], 0) . "</th>
      </tr>
        ";
    }

    return $html;
}


function statitik_nasabah_masuk()
{
    $hasil = select_data_custom('SELECT COUNT(agt_id) as jumlah_masuk, agt_tglmasuk as tgl FROM nasabah GROUP BY agt_tglmasuk;');
    $aokod = [];
    function pecahtgl($tgls)
    {
        $date = date_create($tgls);
        $forms = date_format($date, 'j M y');
        return $forms;
    }
    while ($a = mysqli_fetch_assoc($hasil)) {
        array_push($aokod, array('tgl' => pecahtgl($a['tgl']), 'jumlah' => $a['jumlah_masuk']));
    }

    return $aokod;
}

function statistik_resort()
{
    $hasil1  =  select_data('ao');
    $hsa = [];
    while ($data = mysqli_fetch_assoc($hasil1)) {
        $hasil2 = select_data_custom('SELECT COUNT(agt_id) as jaresort FROM nasabah WHERE agt_kode LIKE "%' . $data['kode_ao'] . '%";');

        while ($a = mysqli_fetch_assoc($hasil2)) {
            array_push($hsa, array($data['kode_ao'] =>  $a['jaresort']));
        }
    }
    return $hsa;
}

function get_nasabah()
{

    $hasil = select_data_custom('SELECT * FROM nasabah JOIN ao ON SUBSTRING_INDEX(nasabah.agt_kode,"_",1) = ao.kode_ao');
    $html = '';
    $no = 0;
    while ($nasa = mysqli_fetch_assoc($hasil)) {
        $no++;
        $html .= "
        <tr onclick='ambil_nasabah(this)' data_id='".$nasa['agt_kode']."' data_nama='" . $nasa['agt_nama'] . "'>
        <th>" . $no . "</th>
        <th>" . $nasa['agt_kode'] . "</th>
        <th>" . $nasa['agt_nama'] . "</th>
        <th>" . $nasa['agt_nohp'] . "</th>
      </tr>
        ";
    }
    return $html;
}
