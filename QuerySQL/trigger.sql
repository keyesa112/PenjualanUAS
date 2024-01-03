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

SELECT JumlahPengadaanPerVendor(2); 
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

-- ---------------------------------------------------------------------
DELIMITER //

CREATE TRIGGER update_status_penerimaan2 AFTER INSERT ON uas.detail_penerimaan
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

DROP TRIGGER update_status_penerimaan2;

-- ---------------------------------------------------------------------
-- trigger agar jumlah penerimaan berkurang jika retur dibuat (FIX)
-- --------------------------------------------------------------------
DELIMITER //

CREATE TRIGGER update_pengadaan_after_retur_insert
AFTER UPDATE ON uas.detail_retur
FOR EACH ROW
BEGIN
    DECLARE jumlah_retur INT;

    -- Mengambil jumlah yang diretur
    SELECT NEW.jumlah INTO jumlah_retur;

    -- Mengurangi jumlah penerimaan pada detail pengadaan
    UPDATE uas.detail_penerimaan
    SET jumlah_terima = jumlah_terima - jumlah_retur
    WHERE iddetail_penerimaan = NEW.iddetail_penerimaan;
END;
//
DELIMITER ;

DROP TRIGGER update_pengadaan_after_retur_insert;

-- --------------------------------------------------------------------
DELIMITER //
CREATE TRIGGER update_pengadaan_after_retur_insert2
AFTER INSERT ON uas.detail_retur
FOR EACH ROW
BEGIN
    DECLARE jumlah_retur INT;

    -- Mengambil jumlah yang diretur
    SELECT NEW.jumlah INTO jumlah_retur;

    -- Mengurangi jumlah penerimaan pada detail pengadaan
    UPDATE uas.detail_penerimaan
    SET jumlah_terima = jumlah_terima - jumlah_retur
    WHERE iddetail_penerimaan = NEW.iddetail_penerimaan;
END;
//
DELIMITER ;

DROP TRIGGER update_pengadaan_after_retur_insert2;
-- ------------------------------------------------

-- kartu stok
-- ------------------------------------------------
-- trigger membuat idtransaksi
-- ------------------------------------------------
SELECT * FROM uas.kartu_stok; 

DELIMITER //

CREATE TRIGGER generate_idtransaksi 
BEFORE INSERT ON uas.kartu_stok
FOR EACH ROW
BEGIN
    DECLARE last_id INT;
    DECLARE new_id INT;

    SELECT idtransaksi INTO last_id FROM uas.kartu_stok ORDER BY idkartu_stok DESC LIMIT 1;

    IF last_id IS NULL THEN
        SET new_id = 1;
    ELSE
        SET new_id = last_id + 1;
    END IF;

    SET NEW.idtransaksi = LPAD(new_id, 6, '0');
END;
//
DELIMITER ;

DELETE FROM detail_penerimaan WHERE iddetail_penerimaan BETWEEN 1 AND 10;

ALTER TABLE detail_penerimaan AUTO_INCREMENT=0;

DROP TRIGGER generate_idtransaksi;

-- ------------------------------------------------
-- trigger barang masuk
-- ------------------------------------------------
DROP TRIGGER IF EXISTS uas.before_insert_detail_penerimaan;
DELIMITER //
CREATE TRIGGER before_insert_detail_penerimaan
BEFORE INSERT ON uas.detail_penerimaan FOR EACH ROW
BEGIN
    DECLARE jumlah_lama INT;
    DECLARE stock_update INT;

    -- Get the current stock (if exists) or assume 0 for the first time
    SELECT COALESCE(MAX(stock), 0) INTO jumlah_lama
    FROM uas.kartu_stok
    WHERE idbarang = NEW.barang_idbarang; -- Corrected column name to match the table structure

    -- Calculate the new stock
    SET NEW.jumlah_terima = IFNULL(NEW.jumlah_terima, 0);  -- Ensure jumlah_terima is not null
    SET stock_update = jumlah_lama + NEW.jumlah_terima;

    -- Check if it's the first time adding stock or not
    IF jumlah_lama > 0 THEN
        -- Update kartu_stok with the new stock value using INSERT ... ON DUPLICATE KEY UPDATE
        INSERT INTO uas.kartu_stok (idbarang, masuk, stock, created_at, idtransaksi)
        VALUES (NEW.barang_idbarang, NEW.jumlah_terima, stock_update, NOW(), NEW.idpenerimaan)
        ON DUPLICATE KEY UPDATE stock = stock_update, masuk = NEW.jumlah_terima, created_at = NOW(), idtransaksi = NEW.idpenerimaan;
    ELSE
        -- Insert into kartu_stok for the first time
        INSERT INTO uas.kartu_stok (idbarang, masuk, stock, created_at, idtransaksi)
        VALUES (NEW.barang_idbarang, NEW.jumlah_terima, stock_update, NOW(), NEW.idpenerimaan);
    END IF;

END;
//
DELIMITER ;

-- -----------------------------------------------------------------------------------------------------
DROP TRIGGER IF EXISTS uas.before_update_detail_penerimaan;
DELIMITER //
CREATE TRIGGER before_update_detail_penerimaan
BEFORE UPDATE ON uas.detail_penerimaan FOR EACH ROW
BEGIN
    DECLARE jumlah_lama INT;
    DECLARE stock_update INT;

    -- Get the current stock (if exists) or assume 0 for the first time
    SELECT COALESCE(MAX(stock), 0) INTO jumlah_lama
    FROM uas.kartu_stok
    WHERE idbarang = NEW.barang_idbarang; -- Corrected column name to match the table structure

    -- Calculate the new stock
    SET NEW.jumlah_terima = IFNULL(NEW.jumlah_terima, 0);  -- Ensure jumlah_terima is not null
    SET stock_update = jumlah_lama - (jumlah_lama-NEW.jumlah_terima);

    -- Check if it's the first time adding stock or not
    IF jumlah_lama > 0 THEN
        -- Update kartu_stok with the new stock value using INSERT ... ON DUPLICATE KEY UPDATE
        INSERT INTO uas.kartu_stok (idbarang, masuk, keluar, stock, created_at, idtransaksi)
        VALUES (NEW.barang_idbarang, NEW.jumlah_terima, (jumlah_lama - NEW.jumlah_terima), stock_update, NOW(), NEW.idpenerimaan)
        ON DUPLICATE KEY UPDATE stock = stock_update, masuk = NEW.jumlah_terima, created_at = NOW(), idtransaksi = NEW.idpenerimaan;

        -- Reset NEW values to avoid the actual update operation
        SET NEW.jumlah_terima = NEW.jumlah_terima;
    ELSE
        -- Insert into kartu_stok for the first time
        INSERT INTO uas.kartu_stok (idbarang, masuk, stock, created_at, idtransaksi)
        VALUES (NEW.barang_idbarang, NEW.jumlah_terima, stock_update, NOW(), NEW.idpenerimaan);
    END IF;

END;
//
DELIMITER ;

DROP TRIGGER IF EXISTS uas.before_insert_detail_penjualan;
DELIMITER //
CREATE TRIGGER before_insert_detail_penjualan
BEFORE INSERT ON uas.detail_penjualan FOR EACH ROW
BEGIN
    DECLARE jumlah_lama INT;
    DECLARE stock_update INT;
    DECLARE barang_id INT;
    
    -- Ambil nilai lama stock dan dianggap 0 jika ini pertama kali
    SELECT COALESCE(MAX(stock), 0), idbarang INTO jumlah_lama, barang_id
    FROM uas.kartu_stok
    WHERE idbarang = NEW.idbarang;
    
    -- Calculate the new stock
    SET NEW.jumlah = IFNULL(NEW.jumlah, 0);  -- Pastikan jumlah tidak null
    SET stock_update = jumlah_lama - NEW.jumlah;

    -- Cek apakah ini penambahan stock pertama kali atau tidak
    IF jumlah_lama > 0 THEN
        -- Update kartu_stok with the new stock value using INSERT ... ON DUPLICATE KEY UPDATE
        INSERT INTO uas.kartu_stok (idbarang, keluar, stock)
        VALUES (barang_id, NEW.jumlah, stock_update)
        ON DUPLICATE KEY UPDATE stock = stock_update, keluar = NEW.jumlah;
    ELSE
        -- Insert into kartu_stok for the first time
        INSERT INTO uas.kartu_stok (idbarang, keluar, stock)
        VALUES (barang_id, NEW.jumlah, stock_update);
    END IF;
END;
//

DELIMITER ;

-- YANG BENAR (TAPI BELUM DICOBA SI)
DELIMITER //

CREATE TRIGGER before_insert_detail_penjualan
BEFORE INSERT ON uas.detail_penjualan FOR EACH ROW
BEGIN
    DECLARE jumlah_lama INT;
    DECLARE stock_update INT;
    DECLARE barang_id INT;

    -- Get the current stock (if exists) or assume 0 for the first time
    SELECT COALESCE(MAX(stock), 0), idbarang INTO jumlah_lama, barang_id
    FROM (
        SELECT stock, idbarang
        FROM uas.kartu_stok
        WHERE idbarang = NEW.idbarang
        ORDER BY created_at DESC
        LIMIT 1
    ) AS subquery;

    -- Calculate the new stock
    SET NEW.jumlah = IFNULL(NEW.jumlah, 0);  -- Ensure jumlah is not null
    SET stock_update = jumlah_lama - NEW.jumlah;

    -- Check if it's the first time updating stock or not
    IF jumlah_lama > 0 THEN
        -- Update kartu_stok with the new stock value using INSERT ... ON DUPLICATE KEY UPDATE
        INSERT INTO uas.kartu_stok (idbarang, keluar, stock, created_at, idtransaksi)
        VALUES (barang_id, NEW.jumlah, stock_update, NOW(), NEW.penjualan_idpenjualan)
        ON DUPLICATE KEY UPDATE stock = stock_update, keluar = keluar + NEW.jumlah, created_at = NOW(), idtransaksi = NEW.penjualan_idpenjualan;
    ELSE
        -- Insert into kartu_stok for the first time
        INSERT INTO uas.kartu_stok (idbarang, keluar, stock, created_at, idtransaksi)
        VALUES (NEW.idbarang, NEW.jumlah, stock_update, NOW(), NEW.penjualan_idpenjualan);
    END IF;

END;
//

DELIMITER ;



SET SQL_SAFE_UPDATES = 0;

DELIMITER //
CREATE PROCEDURE total_penjualan(IN iduser_param INT)
BEGIN
    DECLARE margin_percent DOUBLE;
    -- Ambil persentase dari tabel margin_penjualan
    SELECT m.persen INTO margin_percent
    FROM margin_penjualan m
    WHERE m.iduser = iduser_param
    ORDER BY m.id_margin_penjualan DESC -- Add an ORDER BY clause to select the latest record
    LIMIT 1;
    -- Update subtotal_nilai dengan mempertimbangkan persentase margin
    UPDATE penjualan p
    SET p.subtotal_nilai = ROUND(p.ppn * margin_percent / 100),
        p.total_nilai = ROUND(p.subtotal_nilai + p.ppn)
    WHERE p.iduser = iduser_param;
END //
DELIMITER ;

CALL total_penjualan(1);

DELIMITER //
CREATE FUNCTION hitung_subtotal(id_detail_penjualan_param INT) 
RETURNS INT DETERMINISTIC
BEGIN
    DECLARE total_value INT;
    
    -- Calculate total value for the specific row by summing up (harga_satuan * jumlah) for that item
    SELECT dp.harga_satuan * dp.jumlah + (
        SELECT p.total_nilai
        FROM penjualan p
        WHERE p.id_penjualan = dp.id_penjualan
    ) INTO total_value
    FROM detail_penjualan dp
    WHERE dp.id_detail_penjualan = id_detail_penjualan_param;
    
    RETURN total_value;
END //
DELIMITER ;
select hitung_subtotal(2);

-- Modify the procedure to update subtotal using the modified function
DELIMITER //
CREATE PROCEDURE update_detilpenjualan(IN id_detail_penjualan_param INT)
BEGIN
    DECLARE subtotal_val INT;
    -- Hitung subtotal menggunakan fungsi
    SET subtotal_val = hitung_subtotal(id_detail_penjualan_param);
    -- Update subtotal pada tabel detail_penjualan
    UPDATE detail_penjualan
    SET subtotal = subtotal_val
    WHERE id_detail_penjualan = id_detail_penjualan_param;
END //
DELIMITER ;
CALL update_detilpenjualan(2);


CREATE VIEW view_kartu_stok AS 
SELECT
    ks.idkartu_stok,
    ks.idbarang,
    b.nama, 
    ks.jenis_transaksi,
    ks.masuk,
    ks.keluar,
    ks.stock,
    ks.idtransaksi,
    ks.created_at
FROM kartu_stok ks
JOIN barang b ON ks.idbarang = b.idbarang;
SELECT * FROM view_kartu_stok;




