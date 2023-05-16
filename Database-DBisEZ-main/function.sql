-- Viết function tính tổng số mã khuyến mãi của 1 khách hàng
drop function if exists TONGSOKHUYENMAI; 
DELIMITER $$ 
CREATE FUNCTION TONGSOKHUYENMAI(ID_khachhang INT) RETURNS INT deterministic
BEGIN
-- B1: Kiểm tra có phải là khách hàng không
-- Return -1: Tài khoản không tồn tại
-- Return -2: Không phải là tài khoản khách hàng
	DECLARE countKhachhang INT default 0;
    DECLARE countTaikhoan INT default 0;
	SET countKhachhang = (SELECT COUNT(IDtaikhoan) FROM khachhang WHERE ID_khachhang = IDtaikhoan);
    SET countTaikhoan = (SELECT COUNT(idtaikhoan) FROM taikhoan WHERE ID_khachhang = idtaikhoan);
	IF(countKhachhang = 0 and countTaikhoan = 0) THEN
		RETURN -1;
	ELSEIF(countKhachhang = 0) THEN
		RETURN -2;
    ELSE 
-- B3: Tính tổng số dòng trong bảng
		RETURN (
-- B2:  Kiểm tra tất cả các đơn hàng của khách hàng, gom lại thành 1 bảng
        SELECT COUNT(*)
        FROM (SELECT ID_nguoinhan, ID, ID_makhuyenmai
        FROM donhang, apdung_khuyenmai
        WHERE donhang.ID = apdung_khuyenmai.ID_donhang and ID_nguoinhan = ID_khachhang) AS BANGKHUYENMAI );
	END IF;
END $$
DELIMITER ;


SELECT TONGSOKHUYENMAI(40);


-- Viết Function tính tiền đơn hàng có khuyến mãi
drop function if exists TONGTIENDONHANG; 
DELIMITER $$ 
CREATE FUNCTION TONGTIENDONHANG(donhang_ID INT) RETURNS INT deterministic
BEGIN
	DECLARE tongtien INT default 0;
    DECLARE giagoc INT default 0;
    DECLARE x INT default 0;
    DECLARE y INT default 0;
    DECLARE z INT default 0;
    DECLARE phan_tram_giam INT default 0;
	DECLARE tien_giam_toi_da INT default 0;
    declare t int default 0;
    DECLARE maxIndex int default 0;
    DECLARE iterator int default 0;
    
    SET x = (SELECT COUNT(ID) from donhang where ID = donhang_ID);
    IF(x = 0) THEN
		RETURN -1;
	ELSE
		SET tongtien =  (SELECT SUM(Soluongmon * Giamua) AS TOTAL
		FROM donhang JOIN noidung_donhang ON donhang.ID = noidung_donhang.ID_donhang
		WHERE donhang.ID = donhang_ID
		GROUP BY ID
		);
        SET giagoc = tongtien;
        -- Trừ tất cả các mã giảm tiền
        -- ĐANG LÀM Ở ĐÂY :))))))))))))
        SET y = (SELECT SUM(Sotiengiam)
        FROM(
        SELECT ID_makhuyenmai, Sotiengiam
        FROM apdung_khuyenmai a JOIN khuyenmaigiamtien k ON a.ID_makhuyenmai = k.IDcuama
		WHERE ID_donhang = donhang_ID) AS BANG_GIAM_TIEN_DOI_VOI_DONHANG_ID);
        IF(y IS NOT NULL) THEN
			SET tongtien = tongtien - y;
		END IF;
        -- Trừ tất cả các mã giảm phần trăm
        
        drop temporary table if exists table_phan_tram_giam;
        drop temporary table if exists table_tien_giam_toi_da;
        
        CREATE temporary TABLE table_phan_tram_giam  
        (SELECT @n := @n + 1 n, Phantramgiam
        FROM apdung_khuyenmai a JOIN khuyenmaiphantram k ON a.ID_makhuyenmai = k.IDcuama, (SELECT @n := 0) m
		WHERE ID_donhang = donhang_ID);
        
        CREATE temporary table table_tien_giam_toi_da (SELECT @n := @n + 1 n, Tiengiamtoida
        FROM apdung_khuyenmai a JOIN khuyenmaiphantram k ON a.ID_makhuyenmai = k.IDcuama, (SELECT @n := 0) m
		WHERE ID_donhang = donhang_ID);
        
        SET iterator = 1;
        SET maxIndex = (SELECT MAX(n) FROM table_phan_tram_giam);
        
		WHILE iterator <= maxIndex DO
            SET phan_tram_giam = (SELECT Phantramgiam FROM table_phan_tram_giam WHERE n = iterator);
            SET tien_giam_toi_da = (SELECT Tiengiamtoida FROM table_tien_giam_toi_da WHERE n = iterator);
            IF(phan_tram_giam IS NOT NULL) THEN
				SET t = phan_tram_giam*giagoc/100;
			END IF;
			IF (tien_giam_toi_da IS NOT NULL) THEN
				IF(t > tien_giam_toi_da) THEN
					SET tongtien = tongtien - tien_giam_toi_da;
				ELSE
					SET tongtien = tongtien - t;
				END IF;
			ELSE 
				SET tongtien = tongtien - t;
			END IF;
			SET iterator = iterator + 1;
        END WHILE;
		-- Lấy từng ID mã khuyến mãi trong bảng T1 
        -- Dùng IF-ELSE và count(ID) để xét khuyến mãi đó thuộc bảng nào
        -- Nếu thuộc bảng khuyến mãi giảm tiền -> khiểm tra tối thiểu -> trừ vào biến tổng tiền
        -- Nếu thuộc bẳng khuyến mãi giảm theo phần trăm -> trừ theo giá gốc
        
		RETURN tongtien;
	END IF;
END $$
DELIMITER ;

SELECT TONGTIENDONHANG(7);
