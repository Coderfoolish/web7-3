<?php


require_once __DIR__ . '/database.php';

class LoaiDoiTuongModel
{
    private $db;

    public function __construct()
    {
        $this->db = new MyConnection();
    }

    public function getAll()
    {
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM loai_doi_tuong WHERE status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAllpaging($page, $status = null, $txt_search = '')
    {
        $limit = 10;
        $conn = $this->db->getConnection();
        $sql = "SELECT * FROM loai_doi_tuong WHERE 1=1";
        $countSql = "SELECT COUNT(*) as total FROM loai_doi_tuong WHERE 1=1";

        $params = [];
        $types = "";

        if ($status !== null) {
            $sql .= " AND status = ?";
            $countSql .= " AND status = ?";
            $params[] = $status;
            $types .= "i";
        }

        if (!empty($txt_search)) {
            $sql .= " AND ten_dt LIKE ?";
            $countSql .= " AND ten_dt LIKE ?";
            $params[] = '%' . $txt_search . '%';
            $types .= "s";
        }

        $countStmt = $conn->prepare($countSql);
        if (!empty($params)) {
            $countStmt->bind_param($types, ...$params);
        }
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalRow = $countResult->fetch_assoc()['total'];
        $totalPages = ceil($totalRow / $limit);
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;

        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'data' => $data
        ];
    }

    public function getById($dt_id)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM loai_doi_tuong WHERE dt_id = ?");
        $stmt->bind_param("i", $dt_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function create($ten_dt, $status = 1)
    {
        $conn = $this->db->getConnection();
        $sql = "INSERT INTO loai_doi_tuong (ten_dt, status) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $ten_dt, $status);

        return $stmt->execute();
    }

    public function update($dt_id, $ten_dt, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE loai_doi_tuong SET ten_dt = ?, status = ? WHERE dt_id = ?");
        $stmt->bind_param("sii", $ten_dt, $status, $dt_id);

        return $stmt->execute();
    }

    public function toggleStatus($dt_id)
    {
        $conn = $this->db->getConnection();

        // Bước 1: Lấy status hiện tại
        $stmt = $conn->prepare("SELECT status FROM loai_doi_tuong WHERE dt_id = ?");
        $stmt->bind_param("i", $dt_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $currentStatus = $row['status'];
            $newStatus = $currentStatus == 1 ? 0 : 1;

            // Bước 2: Cập nhật status mới
            $updateStmt = $conn->prepare("UPDATE loai_doi_tuong SET status = ? WHERE dt_id = ?");
            $updateStmt->bind_param("ii", $newStatus, $dt_id);
            return $updateStmt->execute();
        }

        return false; // Không tìm thấy dt_id
    }
}
