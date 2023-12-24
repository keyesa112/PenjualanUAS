-- UAS

-- pengadaan detail pengadaan
-- ------------------------------------------------
-- view antara vendor, pengadaan, dan det.pengadaan (FIX)
-- ------------------------------------------------
CREATE OR REPLACE VIEW info_vendor AS
SELECT p.idpengadaan AS "ID Pengadaan", v.nama_vendor AS "Nama Vendor", 
p.timestamp AS "Waktu Pesan", p.status AS "Status Pengadaan", b.nama AS "Nama Barang", dp.harga_satuan AS "Harga Satuan", 
dp.jumlah AS Jumlah, dp.sub_total AS "Sub Total", p.subtotal_nilai AS "Sub Total Pengadaan" , p.ppn AS PPN, (p.total_nilai) AS "Total Pengadaan"
FROM vendor v
JOIN pengadaan p ON v.idvendor = p.vendor_idvendor
JOIN detail_pengadaan dp ON p.idpengadaan = dp.pengadaan_idpengadaan
JOIN barang b ON dp.barang_idbarang = b.idbarang;

SELECT * FROM info_vendor;

-- ---------------------------------------------------------------------
-- trigger penambahan nilai agar subtotal auto naik jika idpengadaan sama (FIX)
-- --------------------------------------------------------------------
DELIMITER //
CREATE TRIGGER update_subtotal_pengadaan
AFTER INSERT ON detail_pengadaan
FOR EACH ROW
BEGIN
    -- Hitung ulang subtotal pengadaan setelah penambahan data baru di detail_pengadaan
    UPDATE pengadaan p
    SET p.subtotal_nilai = (
        SELECT SUM(dp.sub_total) 
        FROM detail_pengadaan dp 
        WHERE dp.pengadaan_idpengadaan = NEW.pengadaan_idpengadaan
    )
    WHERE p.idpengadaan = NEW.pengadaan_idpengadaan;
    
    -- Panggil stored procedure untuk mengupdate total nilai
    CALL UpdateTotalPengadaan(NEW.pengadaan_idpengadaan);
END;
//
DELIMITER ;


DROP TRIGGER update_subtotal_pengadaan;

-- ---------------------------------------------------------------------

DELIMITER //
CREATE TRIGGER update_subtotal_pengadaan2
AFTER UPDATE ON detail_pengadaan
FOR EACH ROW
BEGIN
    -- Hitung ulang subtotal pengadaan setelah penambahan data baru di detail_pengadaan
    UPDATE pengadaan p
    SET p.subtotal_nilai = (
        SELECT SUM(dp.sub_total) 
        FROM detail_pengadaan dp 
        WHERE dp.pengadaan_idpengadaan = NEW.pengadaan_idpengadaan
    )
    WHERE p.idpengadaan = NEW.pengadaan_idpengadaan;
    
    -- Panggil stored procedure untuk mengupdate total nilai
    CALL UpdateTotalPengadaan(NEW.pengadaan_idpengadaan);
END;
//
DELIMITER ;

-- ---------------------------------------------------------------------
-- sp penambahan nilai agar total nilai auto update jika subtotal diupdate (FIX)
-- --------------------------------------------------------------------

DELIMITER $$
CREATE PROCEDURE UpdateTotalPengadaan(IN id_pgd INT)
BEGIN
    DECLARE new_total INT;
    
    -- Menghitung ulang nilai total_pengadaan
    SELECT SUM(subtotal_nilai * ppn) INTO new_total
    FROM pengadaan
    WHERE idpengadaan = id_pgd;
    
    -- Update nilai total_pengadaan
    UPDATE pengadaan
    SET total_nilai = new_total
    WHERE idpengadaan = id_pgd;
END $$
DELIMITER ;

DROP PROCEDURE UpdateTotalPengadaan;

-- ---------------------------------------------------------------------
-- Stored procedure yang menghitung ulang kedua kolom (FIX)
-- ---------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE UpdatePengadaanTotal(IN id_pgd INT)
BEGIN
    DECLARE new_total INT;
    SELECT (subtotal_nilai * ppn) INTO new_total FROM pengadaan WHERE idpengadaan = id_pgd;
    UPDATE pengadaan SET total_nilai = new_total WHERE idpengadaan = id_pgd;
END $$
DELIMITER ;


-- ---------------------------------------------------------------------
-- Function jumlah pengadaan pervendor (FIX)
-- ---------------------------------------------------------------------
DELIMITER $$
CREATE FUNCTION JumlahPengadaanPerVendor(id_vendor_param INT)
RETURNS INT
BEGIN
    DECLARE jumlah_pengadaan INT;
    SELECT COUNT(*) INTO jumlah_pengadaan
    FROM uas.pengadaan
    WHERE vendor_idvendor = id_vendor_param;
    RETURN jumlah_pengadaan;
END $$
DELIMITER ;

SELECT JumlahPengadaanPerVendor(3); 
-- ------------------------------------------------


-- penerimaan detail penerimaan
-- ------------------------------------------------
-- view antara penerimaan dan detail penerimaan (FIX)
-- ------------------------------------------------
CREATE OR REPLACE VIEW info_penerimaan AS
SELECT 
	b.nama AS "Nama Barang",
	pe.timestamp AS "Waktu Pengadaan",
    p.created_at AS "Waktu Penerimaan",
    dp.jumlah_terima AS "Jumlah Diterima",
    dp.harga_satuan_terima AS "Harga Satuan Diterima",
    dp.sub_total_terima AS "Sub Total Diterima",
    u.username AS "User",
    p.status AS "Status Penerimaan"
FROM uas.penerimaan p
JOIN uas.detail_penerimaan dp ON p.idpenerimaan = dp.idpenerimaan
JOIN uas.barang b ON dp.barang_idbarang = b.idbarang
JOIN uas.pengadaan pe ON p.idpengadaan = pe.idpengadaan
JOIN uas.users u ON p.iduser = u.iduser
GROUP BY p.idpenerimaan, b.nama;

SELECT * FROM info_penerimaan;

-- ------------------------------------------------
-- Trigger untuk Memperbarui Status Penerimaan (FIX)
-- ------------------------------------------------
DELIMITER //

CREATE TRIGGER update_status_penerimaan AFTER UPDATE ON uas.detail_penerimaan
FOR EACH ROW
BEGIN
    DECLARE total_terima INT;
    DECLARE total_diterima INT;

    SELECT SUM(jumlah_terima) INTO total_terima FROM uas.detail_penerimaan WHERE idpenerimaan = NEW.idpenerimaan;

    SELECT SUM(jumlah) INTO total_diterima FROM uas.detail_pengadaan WHERE pengadaan_idpengadaan = NEW.idpenerimaan;

    IF total_terima = total_diterima THEN
        UPDATE uas.penerimaan SET status = 0 WHERE idpenerimaan = NEW.idpenerimaan; -- Status 'Selesai'
    ELSE
        UPDATE uas.penerimaan SET status = 1 WHERE idpenerimaan = NEW.idpenerimaan; -- Status 'Belum selesai'
    END IF;
END;
//
DELIMITER ;

DROP TRIGGER update_status_penerimaan;














