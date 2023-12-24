CREATE DATABASE uas ;
USE uas ;

-- -----------------------------------------------------
-- Table uas.role
-- -----------------------------------------------------
CREATE TABLE  uas.roles (
  idrole INT NOT NULL AUTO_INCREMENT,
  nama_role VARCHAR(100) NULL,
  PRIMARY KEY (idrole)
  );
ALTER TABLE roles
ADD deleted_at TIMESTAMP NULL;

-- -----------------------------------------------------
-- Table uas.user
-- -----------------------------------------------------
CREATE TABLE  uas.users (
  iduser INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(45) NULL,
  password VARCHAR(100) NULL,
  idrole INT NOT NULL,
  PRIMARY KEY (iduser),
  CONSTRAINT fk_user_role FOREIGN KEY (idrole)
	REFERENCES roles (idrole)
  );
ALTER TABLE users
ADD deleted_at TIMESTAMP NULL;
ALTER TABLE users
ADD email VARCHAR(100) NOT NULL;

-- -----------------------------------------------------
-- Table uas.satuan
-- -----------------------------------------------------
CREATE TABLE  uas.satuan (
  idsatuan INT NOT NULL AUTO_INCREMENT,
  nama_satuan VARCHAR(45) NULL,
  status TINYINT NULL,
  PRIMARY KEY (idsatuan)
  );
ALTER TABLE satuan
ADD deleted_at TIMESTAMP NULL;

-- -----------------------------------------------------
-- Table uas.barang
-- -----------------------------------------------------
CREATE TABLE  uas.barang (
  idbarang INT NOT NULL AUTO_INCREMENT,
  jenis CHAR(1) NULL,
  nama VARCHAR(45) NULL,
  idsatuan INT NOT NULL,
  status TINYINT NULL,
  harga INT NULL,
  PRIMARY KEY (idbarang),
  CONSTRAINT fk_barang_satuan1 FOREIGN KEY (idsatuan)
    REFERENCES uas.satuan (idsatuan)
  );
ALTER TABLE barang
ADD deleted_at TIMESTAMP NULL;


-- -----------------------------------------------------
-- Table uas.vendor
-- -----------------------------------------------------
CREATE TABLE  uas.vendor (
  idvendor INT NOT NULL AUTO_INCREMENT,
  nama_vendor VARCHAR(100) NULL,
  badan_hukum CHAR(1) NULL,
  status CHAR(1) NULL,
  PRIMARY KEY (idvendor)
  );
ALTER TABLE vendor
ADD deleted_at TIMESTAMP NULL;

-- -----------------------------------------------------
-- Table uas.pengadaan
-- -----------------------------------------------------
CREATE TABLE  uas.pengadaan (
  idpengadaan BIGINT NOT NULL AUTO_INCREMENT,
  timestamp TIMESTAMP NULL,
  status CHAR(1) NULL,
  subtotal_nilai INT NULL,
  ppn INT NULL,
  total_nilai INT NULL,
  user_iduser INT NOT NULL,
  vendor_idvendor INT NOT NULL,
  PRIMARY KEY (idpengadaan),
  CONSTRAINT fk_pengadaan_user1 FOREIGN KEY (user_iduser)
    REFERENCES uas.users (iduser),
  CONSTRAINT fk_pengadaan_vendor1 FOREIGN KEY (vendor_idvendor)
    REFERENCES uas.vendor (idvendor)
  );
ALTER TABLE pengadaan
ADD deleted_at TIMESTAMP NULL;

-- -----------------------------------------------------
-- Table uas.detail_pengadaan
-- -----------------------------------------------------
CREATE TABLE  uas.detail_pengadaan (
  iddetail_pengadaan BIGINT NOT NULL AUTO_INCREMENT,
  harga_satuan INT NULL,
  jumlah INT NULL,
  sub_total INT NULL,
  barang_idbarang INT NOT NULL,
  pengadaan_idpengadaan BIGINT NOT NULL,
  PRIMARY KEY (iddetail_pengadaan),
	CONSTRAINT detail_pengadaan_idbarang_foreign FOREIGN KEY ( barang_idbarang)
	REFERENCES barang (idbarang),
    CONSTRAINT detail_pengadaan_idpengadaan_foreign FOREIGN KEY (pengadaan_idpengadaan)
	REFERENCES pengadaan (idpengadaan)
);
ALTER TABLE detail_pengadaan
ADD deleted_at TIMESTAMP NULL;


-- -----------------------------------------------------
-- Table uas.penerimaan
-- -----------------------------------------------------
CREATE TABLE  uas.penerimaan (
  idpenerimaan BIGINT NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP NULL,
  status CHAR(1) NULL,
  idpengadaan BIGINT NOT NULL,
  iduser INT NOT NULL,
  PRIMARY KEY (idpenerimaan),
  CONSTRAINT fk_penerimaan_pengadaan1 FOREIGN KEY (idpengadaan)
    REFERENCES uas.pengadaan (idpengadaan),
  CONSTRAINT fk_penerimaan_user1 FOREIGN KEY (iduser)
    REFERENCES uas.users (iduser)
  );


-- -----------------------------------------------------
-- Table uas.detail_penerimaan
-- -----------------------------------------------------
CREATE TABLE  uas.detail_penerimaan (
  iddetail_penerimaan BIGINT NOT NULL AUTO_INCREMENT,
  jumlah_terima INT NULL,
  harga_satuan_terima INT NULL,
  sub_total_terima INT NULL,
  idpenerimaan BIGINT NOT NULL,
  barang_idbarang INT NOT NULL,
  PRIMARY KEY (iddetail_penerimaan),
  CONSTRAINT fk_detail_penerimaan_penerimaan1 FOREIGN KEY (idpenerimaan)
    REFERENCES uas.penerimaan (idpenerimaan),
  CONSTRAINT fk_detail_penerimaan_barang1 FOREIGN KEY (barang_idbarang)
    REFERENCES uas.barang (idbarang)
  );


-- -----------------------------------------------------
-- Table uas.retur
-- -----------------------------------------------------
CREATE TABLE  uas.retur (
  idretur BIGINT NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP NULL,
  idpenerimaan BIGINT NOT NULL,
  iduser INT NOT NULL,
  PRIMARY KEY (idretur),
  CONSTRAINT fk_retur_penerimaan1 FOREIGN KEY (idpenerimaan)
    REFERENCES uas.penerimaan (idpenerimaan),
  CONSTRAINT fk_retur_user1 FOREIGN KEY (iduser)
    REFERENCES uas.users (iduser)
  );


-- -----------------------------------------------------
-- Table uas.detail_retur
-- -----------------------------------------------------
CREATE TABLE  uas.detail_retur (
  iddetail_retur INT NOT NULL AUTO_INCREMENT,
  jumlah INT NULL,
  alasan VARCHAR(200) NULL,
  idretur BIGINT NOT NULL,
  iddetail_penerimaan BIGINT NOT NULL,
  PRIMARY KEY (iddetail_retur),
  CONSTRAINT fk_detail_retur_retur1 FOREIGN KEY (idretur)
    REFERENCES uas.retur (idretur),
  CONSTRAINT fk_detail_retur_detail_penerimaan1 FOREIGN KEY (iddetail_penerimaan)
    REFERENCES uas.detail_penerimaan (iddetail_penerimaan)
  );


-- -----------------------------------------------------
-- Table uas.margin_penjualan
-- -----------------------------------------------------
CREATE TABLE  uas.margin_penjualan (
  idmargin_penjualan INT NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP NULL,
  persen DOUBLE NULL,
  status TINYINT NULL,
  iduser INT NOT NULL,
  updated_at TIMESTAMP NULL,
  PRIMARY KEY (idmargin_penjualan),
  CONSTRAINT fk_margin_penjualan_user1 FOREIGN KEY (iduser)
    REFERENCES uas.users (iduser)
  );


-- -----------------------------------------------------
-- Table uas.penjualan
-- -----------------------------------------------------
CREATE TABLE  uas.penjualan (
  idpenjualan INT NOT NULL AUTO_INCREMENT,
  created_at TIMESTAMP NULL,
  subtotal_nilai INT NULL,
  ppn INT NULL,
  total_nilai INT NULL,
  iduser INT NOT NULL,
  idmargin_penjualan INT NOT NULL,
  PRIMARY KEY (idpenjualan),
  CONSTRAINT fk_penjualan_user1 FOREIGN KEY (iduser)
	REFERENCES uas.users (iduser),
  CONSTRAINT fk_penjualan_margin_penjualan1 FOREIGN KEY (idmargin_penjualan)
    REFERENCES uas.margin_penjualan (idmargin_penjualan)
  );


-- -----------------------------------------------------
-- Table uas.detail_penjualan
-- -----------------------------------------------------
CREATE TABLE  uas.detail_penjualan (
  iddetail_penjualan BIGINT NOT NULL AUTO_INCREMENT,
  harga_satuan INT NULL,
  jumlah INT NULL,
  subtotal INT NULL,
  penjualan_idpenjualan INT NOT NULL,
  idbarang INT NOT NULL,
  PRIMARY KEY (iddetail_penjualan),
  CONSTRAINT fk_detail_penjualan_penjualan1 FOREIGN KEY (penjualan_idpenjualan)
    REFERENCES uas.penjualan (idpenjualan),
  CONSTRAINT fk_detail_penjualan_barang1 FOREIGN KEY (idbarang)
    REFERENCES uas.barang (idbarang)
  );


-- -----------------------------------------------------
-- Table uas.kartu_stok
-- -----------------------------------------------------
CREATE TABLE  uas.kartu_stok (
  idkartu_stok BIGINT NOT NULL AUTO_INCREMENT,
  jenis_transaksi CHAR(1) NULL,
  masuk INT NULL,
  keluar INT NULL,
  stock INT NULL,
  created_at TIMESTAMP NULL,
  idtransaksi INT NULL,
  idbarang INT NOT NULL,
  PRIMARY KEY (idkartu_stok),
  CONSTRAINT fk_kartu_stok_barang1 FOREIGN KEY (idbarang)
    REFERENCES uas.barang (idbarang)
  );

