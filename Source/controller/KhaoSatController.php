<?php

require_once __DIR__ . '/../models/khaoSatModel.php';
require_once __DIR__ . '/../models/cauHoiModel.php';
require_once __DIR__ . '/../models/mucKhaoSatModel.php';
require_once __DIR__ . '/../models/SurveyModel.php';

header('Content-Type: application/json');

if (isset($_POST['func'])) {
    $func = $_POST['func'];

    $ksModel = new KhaoSatModel();
    $mucKhaoSatModel = new MucKhaoSatModel();
    $cauHoiModel = new CauHoiModel();
    $surveyModel = new SurveyModel();

    switch ($func) {
        case "getAllKhaoSat":
            $response = $ksModel->getAllKhaoSat();
            break;
        case "getChiTietKsById":
            $id = $_POST['id'];
            $response = $ksModel->getKhaoSatById($id);
            // $response = $ksModel->getAllKhaoSat();
            break;
        case 'createKhaoSat':
            
            $tenKhaoSat = $_POST['ten-ks'];
            $nhomKsId = $_POST['nhomks-id'];
            $dateStart = $_POST['date-start'];
            $dateEnd = $_POST['date-end'];
            $loaiTraLoi = $_POST['loai-tra-loi'];
            $isSuDung = $_POST['su-dung'];
            $ctdtId = $_POST['ctdt-id'];
            
            //xử lý tạo khảo sát thủ công hoặc nhập file
            if (isset($_FILES['excelFile']) ) {
                $tmpExcelPath =$_FILES['excelFile']['tmp_name'];
                require 'xuly_import.php';
                $content = survey_content_excel_to_json($tmpExcelPath);
            } else {
                $content = json_decode($_POST['content'], true);
            }
            
            $idNewKs = $ksModel->create(
                $tenKhaoSat,
                $dateStart,
                $dateEnd,
                $isSuDung,
                $nhomKsId,
                $loaiTraLoi,
                $ctdtId,
                1
            );

            // tao ra bai khao sat moi thanh cong thi moi tao nội dung
            if ($idNewKs >= 0) {
                $mucArray = $content;
                foreach ($mucArray as $mucItem) {
                    $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], $idNewKs);
                    $cauHoiArray = $mucItem["questions"];
                    foreach ($cauHoiArray as $cauHoiItem) {
                        $cauHoiModel->create($cauHoiItem, $newMucId);
                    }
                }
            }        
            
            $response = true;
            break;
        case "checkExistCtdt":
            $data = $_POST['data'];
            $data = json_decode($data, true);
            $arr = $ksModel->searchCtdt($data["nganh_id"], $data["chu_ki_id"], $data["is_ctdt_daura"]);
            $response = $arr[0]["ctdt_id"]; // tra ve ctdt tim duoc

            break;
        case "deleteKs" : 
            $id = $_POST['id'];
            $response = $ksModel->delete($id);
            break;
        case "getSurveyFieldAndQuestion":
            $id = $_POST['id'];
            $response = json_decode($surveyModel->getsurveyFieldAndQuestion($id));
            break;
        case "updateKhaoSat":
            $data = $_POST['data'];
            $data = json_decode($data, true);
            $isUpdateSuccess = $ksModel->update(
                $data["ks-id"],
                $data["ten-ks"],
                $data["date-start"],
                $data["date-end"],
                $data["su-dung"],
                $data["nhomks-id"],
                $data["loai-tra-loi"],
                $data["ctdt-id"],
                1
            );
            if ($isUpdateSuccess) {
                //delete old section and question
                $oldMucKs = $mucKhaoSatModel->getMucKhaoSatByKsId($data["ks-id"]);
                foreach ($oldMucKs as $oldMucKsItem) {
                    $mucKhaoSatModel->delete($oldMucKsItem["mks_id"]);
                    $cauHoiModel->deleteByMksId($oldMucKsItem["mks_id"]);
                }
                //tao lại nội dung mới
                $mucArray = $data["content"];
                foreach ($mucArray as $mucItem) {
                    $newMucId = $mucKhaoSatModel->create($mucItem["sectionName"], $data["ks-id"]);
                    $cauHoiArray = $mucItem["questions"];
                    foreach ($cauHoiArray as $cauHoiItem) {
                        $cauHoiModel->create($cauHoiItem, $newMucId);
                    }
                }
                
            }
            $response = $isUpdateSuccess;
            break;
        case "getAllKhaoSatFilter":
            $filters = [
                'ten_ks' => $_GET['ten_ks'] ?? null,
                'ngay_bat_dau' => $_GET['ngay_bat_dau'] ?? null,
                'ngay_ket_thuc' => $_GET['ngay_ket_thuc'] ?? null,
                'su_dung' => isset($_GET['su_dung']) ? (int)$_GET['su_dung'] : null,
                'nks_id' => isset($_GET['nks_id']) ? (int)$_GET['nks_id'] : null,
                'ltl_id' => isset($_GET['ltl_id']) ? (int)$_GET['ltl_id'] : null,
                'ctdt_id' => isset($_GET['ctdt_id']) ? (int)$_GET['ctdt_id'] : null,
                'status' => isset($_GET['status']) ? (int)$_GET['status'] : 1 // mặc định = 1
            ];
            
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $response = $khaoSatModel->getAllKhaoSatFilter($filters, $page);
            break;
        default:
            $response = [
                'error' => 'Page not found',
                'message' => 'khong tìm thấy hàm trong khao sat model.',
                'html' => "Loi tạo khảo sat"
            ];
            http_response_code(404); // Set a 404 status code for not found
            break;
    }
    echo json_encode($response);
}

