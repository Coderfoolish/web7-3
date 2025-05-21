-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: student_survey_management
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `student_survey_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `student_survey_management`;

--
-- Table structure for table `cau_hoi`
--

DROP TABLE IF EXISTS cau_hoi;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE cau_hoi (
  ch_id int NOT NULL AUTO_INCREMENT,
  noi_dung varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  mks_id int DEFAULT NULL COMMENT 'ma muc khao sat',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (ch_id) USING BTREE,
  KEY cau_hoi_mks_id_fk (mks_id) USING BTREE,
  CONSTRAINT cau_hoi_mks_id_fk FOREIGN KEY (mks_id) REFERENCES muc_khao_sat (mks_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chu_ki`
--

DROP TABLE IF EXISTS chu_ki;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE chu_ki (
  ck_id int NOT NULL AUTO_INCREMENT,
  ten_ck varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (ck_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chuc_nang`
--

DROP TABLE IF EXISTS chuc_nang;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE chuc_nang (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  ten_cn varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`key`) USING BTREE,
  KEY `key` (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chuc_nang`
--

INSERT INTO chuc_nang VALUES ('create.account','Thêm tài khoản',1);
INSERT INTO chuc_nang VALUES ('create.permission','Thêm quyền',1);
INSERT INTO chuc_nang VALUES ('create.program','Thêm ngành,chu kì, chương trình đào tạo',1);
INSERT INTO chuc_nang VALUES ('create.survey','Thêm khảo sát',1);
INSERT INTO chuc_nang VALUES ('create.target','Thêm đối tượng và nhóm đối tượng',1);
INSERT INTO chuc_nang VALUES ('delete.account','Xóa tài khoản',1);
INSERT INTO chuc_nang VALUES ('delete.permission','Xóa quyền',1);
INSERT INTO chuc_nang VALUES ('delete.program','Xóa ngành,chu kì, chương trình đào tạo',1);
INSERT INTO chuc_nang VALUES ('delete.survey','Xóa khảo sát',1);
INSERT INTO chuc_nang VALUES ('delete.target','Xóa đối tượng và nhóm đối tượng',1);
INSERT INTO chuc_nang VALUES ('edit.account','Sửa tài khoản',1);
INSERT INTO chuc_nang VALUES ('edit.permission','Sửa quyền',1);
INSERT INTO chuc_nang VALUES ('edit.program','Sửa ngành,chu kì, chương trình đào tạo',1);
INSERT INTO chuc_nang VALUES ('edit.survey','Sửa khảo sát',1);
INSERT INTO chuc_nang VALUES ('edit.target','Sửa đối tượng và nhóm đối tượng',1);
INSERT INTO chuc_nang VALUES ('view.account','Xem tài khoản',1);
INSERT INTO chuc_nang VALUES ('view.permission','Xem quyền',1);
INSERT INTO chuc_nang VALUES ('view.program','Xem ngành,chu kì, chương trình đào tạo',1);
INSERT INTO chuc_nang VALUES ('view.survey','Xem khảo sát',1);
INSERT INTO chuc_nang VALUES ('view.target','Xem đối tượng và nhóm đối tượng',1);

--
-- Table structure for table `ctdt_daura`
--

DROP TABLE IF EXISTS ctdt_daura;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE ctdt_daura (
  ctdt_id int NOT NULL AUTO_INCREMENT,
  `file` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  nganh_id int DEFAULT NULL,
  ck_id int DEFAULT NULL COMMENT 'id chu ky',
  la_ctdt tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (ctdt_id) USING BTREE,
  KEY khoa_hoc_chu_ki_id_fk (ck_id) USING BTREE,
  KEY khoa_hoc_nganh_id_fk (nganh_id) USING BTREE,
  CONSTRAINT khoa_hoc_chu_ki_id_fk FOREIGN KEY (ck_id) REFERENCES chu_ki (ck_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT khoa_hoc_nganh_id_fk FOREIGN KEY (nganh_id) REFERENCES nganh (nganh_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `doi_tuong`
--

DROP TABLE IF EXISTS doi_tuong;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE doi_tuong (
  dt_id int NOT NULL AUTO_INCREMENT,
  ho_ten varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  email varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  diachi varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dien_thoai varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  nhom_ks int DEFAULT NULL,
  loai_dt_id int DEFAULT NULL COMMENT 'id loai doi tuong trong table loai doi tuong',
  ctdt_id int DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (dt_id) USING BTREE,
  KEY doi_tuong_ctdt_id_fk (ctdt_id) USING BTREE,
  KEY doi_tuong_loai_dt_fk (loai_dt_id) USING BTREE,
  KEY user_loai_tk_fk (nhom_ks) USING BTREE,
  CONSTRAINT doi_tuong_ctdt_id_fk FOREIGN KEY (ctdt_id) REFERENCES ctdt_daura (ctdt_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT doi_tuong_loai_dt_fk FOREIGN KEY (loai_dt_id) REFERENCES loai_doi_tuong (dt_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT user_loai_tk_fk FOREIGN KEY (nhom_ks) REFERENCES nhom_khao_sat (nks_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doi_tuong`
--

INSERT INTO doi_tuong VALUES (1,'Nguyễn Văn A','vana@example.com','Hà Nội','0987654321',1,1,1,1);


--
-- Table structure for table `khao_sat`
--

DROP TABLE IF EXISTS khao_sat;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE khao_sat (
  ks_id int NOT NULL AUTO_INCREMENT,
  ten_ks varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  ngay_bat_dau date DEFAULT NULL,
  ngay_ket_thuc date DEFAULT NULL,
  su_dung tinyint(1) DEFAULT NULL COMMENT 'hien tai khao sat co dang duoc thuc hien hay khong',
  nks_id int DEFAULT NULL COMMENT 'id nhóm khảo sát',
  ltl_id int DEFAULT NULL COMMENT 'loai cau tra loi',
  ctdt_id int DEFAULT NULL COMMENT 'ma chuong trinh dao tao',
  `status` tinyint(1) DEFAULT NULL COMMENT 'tinh trang su dung 0,1',
  PRIMARY KEY (ks_id) USING BTREE,
  KEY khao_sat_ctdt_id_fk (ctdt_id) USING BTREE,
  KEY khao_sat_ltl_id_fk (ltl_id) USING BTREE,
  KEY khao_sat_nks_id_fk (nks_id) USING BTREE,
  CONSTRAINT khao_sat_ctdt_id_fk FOREIGN KEY (ctdt_id) REFERENCES ctdt_daura (ctdt_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT khao_sat_ltl_id_fk FOREIGN KEY (ltl_id) REFERENCES loai_tra_loi (ltl_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT khao_sat_nks_id_fk FOREIGN KEY (nks_id) REFERENCES nhom_khao_sat (nks_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kq_khao_sat`
--

DROP TABLE IF EXISTS kq_khao_sat;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE kq_khao_sat (
  kqks_id int NOT NULL AUTO_INCREMENT,
  nguoi_lamks_id int DEFAULT NULL,
  ks_id int DEFAULT NULL COMMENT 'id cua bai khao sat',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (kqks_id) USING BTREE,
  KEY kq_khao_sat_ks_id_fk (ks_id) USING BTREE,
  KEY kq_khao_sat_nguoi_lamks_id_fk (nguoi_lamks_id) USING BTREE,
  CONSTRAINT kq_khao_sat_ks_id_fk FOREIGN KEY (ks_id) REFERENCES khao_sat (ks_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT kq_khao_sat_nguoi_lamks_id_fk FOREIGN KEY (nguoi_lamks_id) REFERENCES doi_tuong (dt_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loai_doi_tuong`
--

DROP TABLE IF EXISTS loai_doi_tuong;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE loai_doi_tuong (
  dt_id int NOT NULL AUTO_INCREMENT,
  ten_dt varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (dt_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loai_doi_tuong`
--

INSERT INTO loai_doi_tuong VALUES (1,'Sinh viên',1);
INSERT INTO loai_doi_tuong VALUES (2,'Giảng viên',1);
INSERT INTO loai_doi_tuong VALUES (3,'Doanh nghiệp',1);

--
-- Table structure for table `loai_tra_loi`
--

DROP TABLE IF EXISTS loai_tra_loi;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE loai_tra_loi (
  ltl_id int NOT NULL AUTO_INCREMENT,
  thang_diem int DEFAULT NULL,
  mota varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  chitiet_mota varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contain array of keyqword: a,b,c,d',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (ltl_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `muc_khao_sat`
--

DROP TABLE IF EXISTS muc_khao_sat;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE muc_khao_sat (
  mks_id int NOT NULL AUTO_INCREMENT,
  ten_muc varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  ks_id int DEFAULT NULL COMMENT 'id cua bai khao sat',
  parent_mks_id int DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (mks_id) USING BTREE,
  KEY muc_khao_sat_ks_id_fk (ks_id) USING BTREE,
  KEY parent_mks_id_fk (parent_mks_id),
  CONSTRAINT muc_khao_sat_ks_id_fk FOREIGN KEY (ks_id) REFERENCES khao_sat (ks_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT parent_mks_id_fk FOREIGN KEY (parent_mks_id) REFERENCES muc_khao_sat (mks_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nganh`
--

DROP TABLE IF EXISTS nganh;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE nganh (
  nganh_id int NOT NULL AUTO_INCREMENT,
  ten_nganh varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (nganh_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nhom_khao_sat`
--

DROP TABLE IF EXISTS nhom_khao_sat;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE nhom_khao_sat (
  nks_id int NOT NULL AUTO_INCREMENT,
  ten_nks varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (nks_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quyen`
--

DROP TABLE IF EXISTS quyen;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE quyen (
  quyen_id int NOT NULL AUTO_INCREMENT,
  ten_quyen varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (quyen_id) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quyen`
--

INSERT INTO quyen VALUES (1,'Admin',1);
INSERT INTO quyen VALUES (2,'Giảng viên',1);
INSERT INTO quyen VALUES (3,'Sinh viên',1);

--
-- Table structure for table `quyen_chucnang`
--

DROP TABLE IF EXISTS quyen_chucnang;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE quyen_chucnang (
  quyen_id int NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (quyen_id,`key`) USING BTREE,
  KEY FK_chucnang_quyen (`key`) USING BTREE,
  CONSTRAINT FK_chucnang_quyen FOREIGN KEY (`key`) REFERENCES chuc_nang (`key`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_quyen_chucnang FOREIGN KEY (quyen_id) REFERENCES quyen (quyen_id) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quyen_chucnang`
--

INSERT INTO quyen_chucnang VALUES (1,'create.account',1);
INSERT INTO quyen_chucnang VALUES (1,'create.permission',1);
INSERT INTO quyen_chucnang VALUES (1,'create.program',1);
INSERT INTO quyen_chucnang VALUES (1,'create.survey',1);
INSERT INTO quyen_chucnang VALUES (1,'create.target',1);
INSERT INTO quyen_chucnang VALUES (1,'delete.account',1);
INSERT INTO quyen_chucnang VALUES (1,'delete.permission',1);
INSERT INTO quyen_chucnang VALUES (1,'delete.program',1);
INSERT INTO quyen_chucnang VALUES (1,'delete.survey',1);
INSERT INTO quyen_chucnang VALUES (1,'delete.target',1);
INSERT INTO quyen_chucnang VALUES (1,'edit.account',1);
INSERT INTO quyen_chucnang VALUES (1,'edit.permission',1);
INSERT INTO quyen_chucnang VALUES (1,'edit.program',1);
INSERT INTO quyen_chucnang VALUES (1,'edit.survey',1);
INSERT INTO quyen_chucnang VALUES (1,'edit.target',1);
INSERT INTO quyen_chucnang VALUES (1,'view.account',1);
INSERT INTO quyen_chucnang VALUES (1,'view.permission',1);
INSERT INTO quyen_chucnang VALUES (1,'view.program',1);
INSERT INTO quyen_chucnang VALUES (1,'view.survey',1);
INSERT INTO quyen_chucnang VALUES (1,'view.target',1);
INSERT INTO quyen_chucnang VALUES (2,'create.survey',1);
INSERT INTO quyen_chucnang VALUES (2,'delete.survey',1);
INSERT INTO quyen_chucnang VALUES (2,'edit.survey',1);
INSERT INTO quyen_chucnang VALUES (2,'view.survey',1);
INSERT INTO quyen_chucnang VALUES (2,'view.target',1);
INSERT INTO quyen_chucnang VALUES (3,'view.survey',1);

--
-- Table structure for table `tai_khoan`
--

DROP TABLE IF EXISTS tai_khoan;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE tai_khoan (
  tk_id int NOT NULL AUTO_INCREMENT,
  username varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  dt_id int DEFAULT NULL COMMENT 'doi tuong id lien ket ban doi tuong',
  quyen_id int DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (tk_id) USING BTREE,
  KEY tai_khoan_dt_id_fk (dt_id) USING BTREE,
  KEY tai_khoan_quyen_id_fk (quyen_id) USING BTREE,
  CONSTRAINT tai_khoan_dt_id_fk FOREIGN KEY (dt_id) REFERENCES doi_tuong (dt_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT tai_khoan_quyen_id_fk FOREIGN KEY (quyen_id) REFERENCES quyen (quyen_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

INSERT INTO tai_khoan VALUES (1,'admin','$2y$10$MgaVEZluiSMKpz6whUSmbuTNJG3GprR6GggLpF2Hh5cTm3d6F/sWq',1,1,1);

--
-- Table structure for table `tra_loi`
--

DROP TABLE IF EXISTS tra_loi;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE tra_loi (
  tl_id int NOT NULL AUTO_INCREMENT,
  ket_qua int DEFAULT NULL,
  ch_id int DEFAULT NULL COMMENT 'cau hoi id',
  kq_ks_id int DEFAULT NULL COMMENT 'ket qua khao sat id',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (tl_id) USING BTREE,
  KEY tra_loi_ch_id_fk (ch_id) USING BTREE,
  KEY tra_loi_kq_ks_id_fk (kq_ks_id) USING BTREE,
  CONSTRAINT tra_loi_ch_id_fk FOREIGN KEY (ch_id) REFERENCES cau_hoi (ch_id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT tra_loi_kq_ks_id_fk FOREIGN KEY (kq_ks_id) REFERENCES kq_khao_sat (kqks_id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
