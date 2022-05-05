<?php
session_start();
try {
    if (!isset($_SESSION['sesion'])) {
        $arrayReturn['mensaje'] = '401 Se requiere autorización';
        $arrayReturn['error']   = true;
        http_response_code(401);
        http_response_code();
        echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
        exit();
    };
} catch (Exception $e) {
    $arrayReturn['mensaje'] = $e->getMessage();
    $arrayReturn['error']   = true;
    http_response_code(400);
    http_response_code();
    echo json_encode($arrayReturn, JSON_UNESCAPED_UNICODE);
    exit();
}
