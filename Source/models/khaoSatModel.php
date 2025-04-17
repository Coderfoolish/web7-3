<?php
// app/Models/KhaoSat.php

require_once __DIR__ . '/database.php';

class KhaoSatModel
{

    private $db; // Database connection

    public function __construct()
    {
        $this->db = new MyConnection(); // Create a Database instance
    }

    // Database operations
    public function create($ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status)
    {
        $conn = $this->db->getConnection();
        // Change the data type to DATE for ngay_bat_dau and ngay_ket_thuc
        $stmt = $conn->prepare("INSERT INTO khao_sat (ten_ks, ngay_bat_dau, ngay_ket_thuc, su_dung, nks_id, ltl_id, ctdt_id,status ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Change the bind_param types to 'sssi' for the date fields
        $stmt->bind_param("ssssiiis", $ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status);

        if ($stmt->execute()) {
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        } else {
            $stmt->close();
            return false;
        }
    }


    public function getAllKhaoSat()
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM khao_sat where status = 1 ");
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        // return array
        return $data;
    }

    public function getKhaoSatById($ks_id)
    {
        $conn = $this->db->getConnection();
        $query = "
            SELECT 
            khao_sat.ks_id, khao_sat.ten_ks, khao_sat.ngay_bat_dau,khao_sat.ngay_ket_thuc,khao_sat.su_dung,khao_sat.status,
            loai_tra_loi.ltl_id,loai_tra_loi.thang_diem,
            nhom_khao_sat.nks_id,nhom_khao_sat.ten_nks,
            chu_ki.ck_id,chu_ki.ten_ck,
            nganh.nganh_id, nganh.ten_nganh,
            ctdt_daura.la_ctdt
            FROM khao_sat
            JOIN loai_tra_loi ON khao_sat.ltl_id = loai_tra_loi.ltl_id
            JOIN nhom_khao_sat ON khao_sat.nks_id = nhom_khao_sat.nks_id
            JOIN ctdt_daura ON khao_sat.ctdt_id = khao_sat.ctdt_id
            JOIN chu_ki ON ctdt_daura.ck_id = chu_ki.ck_id 
            JOIN nganh ON  ctdt_daura.nganh_id=  nganh.nganh_id
            Where khao_sat.ks_id = ? and khao_sat.ctdt_id = ctdt_daura.ctdt_id
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $ks_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row;
        } else {
            return false;
        }
    }

    public function update($ks_id, $ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status)
    {
        $conn = $this->db->getConnection();
        // (ten_ks, ngay_bat_dau, ngay_ket_thuc, su_dung, nks_id, ltl_id, ctdt_id,status )
        $stmt = $conn->prepare(
            "UPDATE khao_sat SET 
        ten_ks = ?,
        ngay_bat_dau = ?,
        ngay_ket_thuc = ?,
        su_dung = ?,
        nks_id = ?,
        ltl_id = ?,
        ctdt_id = ?,
        status = ?
        WHERE ks_id = ?"
        );
        $stmt->bind_param("sssiiiiii", $ten_ks, $ngay_bat_dau, $ngay_ket_thuc, $su_dung, $nks_id, $ltl_id, $ctdt_id, $status, $ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($ks_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE khao_sat SET status = 0 WHERE ks_id = ?");
        $stmt->bind_param("i", $ks_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function searchCtdt($nganh_id, $chu_ki_id, $is_ctdt_daura)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM ctdt_daura WHERE nganh_id = ? AND ck_id = ? AND la_ctdt = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $nganh_id, $chu_ki_id, $is_ctdt_daura);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
        return $data;
    }

    public function isCTDTInUse($ctdt_id)
    {
        $conn = $this->db->getConnection();
        $query = "SELECT ks_id FROM khao_sat WHERE ctdt_id = ? AND status = 1";
        $stmt = $conn->prepare( $query);
        $stmt->bind_param("i", $ctdt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return true;
        } else {
            return false;
        }
    }

    public function getAllKhaoSatFilter($filters = [], $page = 1)
    {
        $limit = 10;
        $conn = $this->db->getConnection();
        $condition = "WHERE 1=1";
        $params = [];
        $types = "";

        // Xử lý điều kiện lọc

        if (!empty($filters['ten_ks'])) {
            $condition .= " AND ten_ks LIKE ?";
            $params[] = '%' . $filters['ten_ks'] . '%';
            $types .= "s";
        }

        if (!empty($filters['ngay_bat_dau'])) {
            $condition .= " AND ngay_bat_dau >= ?";
            $params[] = $filters['ngay_bat_dau'];
            $types .= "s";
        }

        if (!empty($filters['ngay_ket_thuc'])) {
            $condition .= " AND ngay_ket_thuc <= ?";
            $params[] = $filters['ngay_ket_thuc'];
            $types .= "s";
        }

        if (isset($filters['su_dung'])) {
            $condition .= " AND su_dung = ?";
            $params[] = $filters['su_dung'];
            $types .= "i";
        }

        if (isset($filters['nks_id'])) {
            $condition .= " AND nks_id = ?";
            $params[] = $filters['nks_id'];
            $types .= "i";
        }

        if (isset($filters['ltl_id'])) {
            $condition .= " AND ltl_id = ?";
            $params[] = $filters['ltl_id'];
            $types .= "i";
        }

        if (isset($filters['ctdt_id'])) {
            $condition .= " AND ctdt_id = ?";
            $params[] = $filters['ctdt_id'];
            $types .= "i";
        }

        if (isset($filters['status'])) {
            $condition .= " AND status = ?";
            $params[] = $filters['status'];
            $types .= "i";
        }

        //tổng số trang
        $countSql = "SELECT COUNT(*) as total FROM khao_sat" . $condition;
        $countStmt = $conn->prepare($countSql);
        if (!empty($params)) {
            $countStmt->bind_param($types, ...$params);
        }
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRecords = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRecords / $limit);
        $countStmt->close();

        // chính
        $sql = "SELECT * FROM khao_sat" . $condition . " ORDER BY ks_id DESC LIMIT ? OFFSET ?";
        $offset = ($page - 1) * $limit;
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();

        return [
            'data' => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

}

// $m = new KhaoSatModel();
// $r = $m->getKhaoSatById(2);
// echo json_encode($r);

?>