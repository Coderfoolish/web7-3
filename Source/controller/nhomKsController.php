<?php

require_once __DIR__ . '/../models/nhomKsModel.php'; 
// header('Content-Type: application/json'); 

if (isset($_GET['func'])) {
    $func = $_GET['func'];
    // $data = $_GET['data'];
    // $data = json_decode($data);
    $ksModel = new NhomKsModel();

    switch ($func) {
        case 'getAllNhomKs':
            
            $response = $ksModel->getAllNhomKs();
            break;

        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'nhom Loi khao sat model.'
            ];
            http_response_code(404); // Set a 404 status code for not found
        break;
    }

    echo json_encode($response);
}

// $ksModel = new NhomKsModel();
// $a = $ksModel->getAllNhomKs();
// echo  json_encode($a[1]);

?>