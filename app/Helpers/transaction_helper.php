<?php

if (!function_exists('transaction_process')) {
    function transaction_process(callable $callback)
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $result = $callback();
            if ($result === false) {
                $db->transRollback();
                return false;
            }

            $db->transCommit();
            return $result;
        } catch (\Throwable $e) {
            $db->transRollback();
            // log_message('error', $e->getMessage());
            return ['success' => true, 'message' => $e->getMessage()];
        }
    }
}
