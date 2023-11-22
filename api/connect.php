<?php
$db = new mysqli('localhost', 'root', '', 'db_koperasi');
if ($db->connect_errno) {
    die("koneksi database gagal" . $db->connect_error);
}
