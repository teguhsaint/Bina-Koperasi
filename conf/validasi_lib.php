<?php
class Validation
{
    public $errors = [];
    public $result = [];

    public function validate($rules, $db)
    {
        if (array_key_exists('file', $rules)) {
            
            $ruleFile = $rules['file'];
            $arrayFile=explode(':', $ruleFile);
            $max = $arrayFile[1];
            $maxSize = $max * 1024 * 1024;
            if ($_FILES['file']['size']>$maxSize) {
                $this->errors['file']['error']= 'File melebihi ukuran maksimal';
            }
        }
        foreach ($_POST as $key => $isi) {
            if (isset($rules[$key])) {
                 
                $fieldRules = $rules[$key];
                $rulesField = explode("|", $fieldRules);
                foreach ($rulesField as $rule) {

                    switch ($rule) {

                        case 'required':
                            if (empty($isi)) {
                                $this->errors[$key]['error'] = $key . ' tidak boleh kosong';
                            }
                            break;
                        case 'hs':
                            if (!preg_match('/^[a-zA-Z.,\s]+$/', $isi)) {
                                $this->errors[$key]['error'] = $key . ' hanya boleh berisi huruf dan spasi';
                            }
                            break;
                        case 'hast':
                            if (!preg_match('/^[a-zA-Z0-9\s,.#-]+$/', $isi)) {
                                $this->errors[$key]['error'] = $key.' hanya boleh terdiri dari huruf, angka, spasi, koma, titik, dan tanda baca lainnya';
                                
                            }
                        
                            break;

                    }
                }
            }
            $this->result[$key] = $db->real_escape_string(htmlspecialchars($isi));
        }
      
        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getResult()
    {
        return $this->result;
    }
}
