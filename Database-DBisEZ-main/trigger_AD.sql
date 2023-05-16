drop trigger if exists before_monan_insert;
drop trigger if exists before_monan_update;
drop trigger if exists after_monan_delete;

CREATE TABLE monan_log (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    IDmonan INT NOT NULL,
    ten VARCHAR(255) NOT NULL,
    mota VARCHAR(255) NOT NULL,
    IDnhahang INT NOT NULL,
    IDLoaimonan INT NOT NULL,
    changedat DATETIME DEFAULT NULL,
    action VARCHAR(50) DEFAULT NULL
);

CREATE TRIGGER before_monan_insert
    BEFORE INSERT ON monan
    FOR EACH ROW 
 INSERT INTO monan_log
 SET action = 'add',
	IDmonan = NEW.IDMonAn,
	ten = NEW.TenMonAn,
	mota = NEW.MoTa,
	IDnhahang = NEW.IDNhaHang,
	IDLoaimonan = NEW.IDLoaiMonAn,
	changedat = NOW();

CREATE TRIGGER before_monan_update
    BEFORE UPDATE ON monan
    FOR EACH ROW 
 INSERT INTO monan_log
 SET action = 'update',
	IDmonan = NEW.IDMonAn,
	ten = NEW.TenMonAn,
	mota = NEW.MoTa,
	IDnhahang = NEW.IDNhaHang,
	IDLoaimonan = NEW.IDLoaiMonAn,
	changedat = NOW();

CREATE TRIGGER after_monan_delete
    AFTER DELETE ON monan
    FOR EACH ROW 
 INSERT INTO monan_log
 SET action = 'remove',
	IDmonan = OLD.IDMonAn,
	ten = OLD.TenMonAn,
	mota = OLD.MoTa,
	IDnhahang = OLD.IDNhaHang,
	IDLoaimonan = OLD.IDLoaiMonAn,
	changedat = NOW();

drop trigger if exists update_giaban;
DELIMITER $$
CREATE TRIGGER update_giaban AFTER UPDATE ON noidung_donhang
FOR EACH ROW
BEGIN
	UPDATE hoadon
    SET Phidonhang = TONGTIENDONHANG(id)
    WHERE id = NEW.ID_donhang;
END $$
DELIMITER ;

UPDATE noidung_donhang
SET Giamua = 10000000
WHERE ID_donhang = 1 AND ID_monan = 1