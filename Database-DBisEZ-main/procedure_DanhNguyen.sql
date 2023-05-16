USE ass_db;
drop procedure if exists Hoadoncophuongthuc;
drop procedure if exists SonguyenlieuthuocmotDonhang;
DELIMITER //
create procedure Hoadoncophuongthuc(
	Phuongthuc VARCHAR(9)
)
begin
	if Phuongthuc != "Trực tiếp" and Phuongthuc != "Online" then
		select "Phương thức này không tồn tại" as "Thông báo lỗi";
	else
		select K.IDtaikhoan, K.Ho, K.Ten, D.ID as IDdonhang, H.ID as IDhoadon, H.Phuongthuc from (Hoadon as H inner join Donhang as D on H.ID_donhang = D.ID) 
		inner join khachhang as K on K.IDtaikhoan = D.ID_nguoinhan
		where H.Phuongthuc = Phuongthuc
		order by D.ID;
	end if;
end //

-- 2: Số lượng nguyên liệu của một món ăn -- 
create procedure SonguyenlieuthuocmotDonhang(
	ID_donhang int,
    Giamua int
)
begin
	-- Kiem tra xem co Don hang do khong
    declare countID int default 0;
	-- if Giamua = null then set Giamua = 0; end if;
    set countID = (select count(ID) from Donhang where ID = ID_donhang);
    if countID = 0 then
		SELECT CONCAT('Đơn hàng ID (',ID_donhang,') không tồn tại trong bảng dữ liệu.') AS 'Thông báo lỗi';
	else
		select NL.IDmonan, ND.Giamua, count(NL.Tennguyenlieu) as Count from Noidung_donhang as ND inner join NguyenLieu as NL 
        on ND.ID_monan = NL.IDmonan
        where ND.ID_donhang = ID_donhang
        group by NL.IDmonan
        having ND.Giamua > Giamua
        order by NL.IDmonan desc;
	end if;
end //

DELIMITER ;

-- Thủ tục 1
call Hoadoncophuongthuc("Online");

-- Thủ tục 2
call SonguyenlieuthuocmotDonhang(3, 0);
