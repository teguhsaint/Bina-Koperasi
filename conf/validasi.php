<?php
class Test
{
   
    public $test = [];
    public function form($db, $kode, $nama, $nik, $alamat, $nohp)
    {
        
        if (!preg_match('/^[AO0-9_]+$/', $kode)) {
            $this->test['msg'] = 'Kode Tidak Sesuai';
            
        } elseif (!preg_match('/^[a-zA-Z.,\s]+$/', $nama)) {
            $this->test['msg'] = 'Nama hanya boleh berisi huruf dan spasi';
            
        } elseif (!ctype_digit($nik)) {
            $this->test['msg'] = 'Nik hanya boleh berisi angka';
            
        } elseif (!preg_match('/^[a-zA-Z0-9\s,.#-]+$/', $alamat)) {
            $this->test['msg'] = 'Alamat hanya boleh terdiri dari huruf, angka, spasi, koma, titik, dan tanda baca lainnya';
            
        } elseif (!preg_match('/^[0-9\+\(\)\s]+$/', $nohp)) {
            $this->test['msg'] = 'No hp hanya boleh berisi angka';
            
        } else {
            $kode = $db->real_escape_string(htmlspecialchars($kode));
            $nama = $db->real_escape_string(htmlspecialchars($nama));
            $nik = $db->real_escape_string(htmlspecialchars($nik));
            $alamat = $db->real_escape_string(htmlspecialchars($alamat));
            $hp = $db->real_escape_string(htmlspecialchars($nohp));
            $this->test = [
                'kode' => $kode,
                'nama' => $nama,
                'nik' => $nik,
                'alamat' => $alamat,
                'hp' => $hp
            ];
           
        }
    }
    public function get()
    {
        
            
        return $this->test;
       

    }
}
