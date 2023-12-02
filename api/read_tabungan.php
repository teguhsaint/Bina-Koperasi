<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "model.php";

if(!empty($_GET['ambil'])){

    $ambil_apa= $_GET['ambil'];

   switch ($ambil_apa) {
    case 'tabungan':
            $hasil = select_data('tabungan_nasabah');
            $item = [];

            while ($a = mysqli_fetch_assoc($hasil)) {
                $item[] = $a;
            }

            $response = ['status' => 'ojid', 'data' => $item];
            echo json_encode($response);

        break;
    case 'value':
            $hasil = select_data('ao');
            $item = [];

            while ($a = mysqli_fetch_assoc($hasil)) {
                $item[] = $a;
            }

            $response = ['status' => 'ojid', 'data' => $item];
            echo json_encode($response);
        break;
    default:
        # code...
        break;
   }


}
?>

