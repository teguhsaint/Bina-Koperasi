<?php

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: *");

require_once 'connect.php';

$result = [];

$id = $_POST['id'];
if (isset($id)) {
    if (intval($id)) {
        $sql = "delete from nasabah where agt_id = '$id'";
        $db->query($sql);

        if ($db->affected_rows > 0) {
            unlink($_POST['gambar']);
            $result['massage'] = "data berhasil dihapus";
        } else {
            $result['error'] = "server error";
        }

    } else {
        $result["error"] = "Id salah";
    }
} else {
    $result['error'] = "tidak ada data yang dipilih";
    echo $db->error;
}

echo json_encode($result);
