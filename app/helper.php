<?php
if (!function_exists('resJSON')) {
    function resJSON($status, $message, $data, $code)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}


?>