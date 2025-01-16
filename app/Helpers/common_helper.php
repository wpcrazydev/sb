<?php

// Get Dynamic Data
if (!function_exists('get_dynamic_data')) {
    function get_dynamic_data($tbl = '', $col = '', $key = [], $default = null) {
        if (!empty($tbl) && !empty($col) && !empty($key)) {
            $db = db_connect();
            $builder = $db->table($tbl);
            $builder->select($col);
            $builder->where($key);
            
            $query = $builder->get();
            $row = $query->getRow();
            
            if ($row && property_exists($row, $col)) {
                return $row->$col;
            }
        }
        return $default;
    }
}


if (!function_exists('getRefCode')) {
    function getRefCode() {
        $number = env('REFCODE_PREFIX') . mt_rand(99999, 999999);
        if ((new \App\Models\Users())->where('ref_code', $number)->countAllResults() > 0) {
            return getRefCode();
        } else {
            return $number;
        }
    }
}