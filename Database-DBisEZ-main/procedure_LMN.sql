USE ass_db
DELIMITER $	
create procedure addHoaDon(
	new_id int,
    phuongthuc varchar(255),
    phigiaohang int,
    IDdonhang int
)
begin
	-- Check existing ID
    declare countID int default 0;
    declare countIDdonhang int default 0;
	declare phidonhang int default 0;

    set countID=(select count(id) from hoadon where id=new_id);
    set countIDdonhang=(select count(id) from donhang where id=IDdonhang);
	set phidonhang = TONGTIENDONHANG(IDdonhang);

    if countID > 0 then
		SELECT  CONCAT('ID của bạn(',new_id,') đã tồn tại.') AS 'RES';
	ELSEIF  not(phuongthuc='Trực tiếp' or phuongthuc ='Online') then
		select concat('Phương thức của bạn(',phuongthuc,') phải là \"Trực tiếp\" hoặc \"Online\".') AS 'RES';
	elseif countIDdonhang=0 then
		select concat('Mã đơn hàng được nhập(',IDdonhang,') không tồn tại.') AS 'RES';
	elseif phidonhang%500!=0 then
		select concat('Tiền đơn hàng của bạn(',phidonhang,') quá lẻ.') AS 'RES';
	elseif phigiaohang%500!=0 then
		select concat('Tiền đơn hàng của bạn(',phigiaohang,') quá lẻ.') AS 'RES';
	else
		INSERT INTO Hoadon VALUES (new_id, phuongthuc, phidonhang, phigiaohang, IDdonhang);
        select "Thêm thành công" AS 'RES';
	end if;
end $

create procedure removeHoadonByID(
	remove_id int
)
begin
	-- Check existing ID
    declare countID int default 0;
    set countID=(select count(id) from hoadon where id=remove_id);
    if countID = 0 then
		SELECT  CONCAT('ID của bạn(',remove_id,') không tồn tại trong bảng.') AS 'RES';
	else
		delete from hoadon where id=remove_id;
        select "Xóa thành công" AS 'RES';
	end if;
end $

create procedure updateHoadonByID(
	selected_id int,
    phuongthuc varchar(255),
    phigiaohang int,
    IDdonhang int
)
begin
	-- Check existing ID
    declare countID int default 0;
    declare countIDdonhang int default 0;
	declare phidonhang int default 0;

    set countID=(select count(id) from hoadon where id=selected_id);
    set countIDdonhang=(select count(id) from donhang where id=IDdonhang);
	set phidonhang = TONGTIENDONHANG(IDdonhang);
    if countID = 0 then
		SELECT  CONCAT('ID của bạn(',selected_id,') không tồn tại trong bảng.') AS 'RES';
	ELSEIF  not(phuongthuc='Trực tiếp' or phuongthuc ='Online') then
		select concat('Phương thức của bạn(',phuongthuc,') phải là \"Trực tiếp\" hoặc \"Online\".') AS 'RES';
	elseif countIDdonhang=0 then
		select concat('Mã đơn hàng được nhập(',IDdonhang,') không tồn tại.') AS 'RES';
	elseif phidonhang%500!=0 then
		select concat('Tiền đơn hàng của bạn(',phidonhang,') quá lẻ.') AS 'RES';
	elseif phigiaohang%1000!=0 then
		select concat('Tiền đơn hàng của bạn(',phigiaohang,') quá lẻ.') AS 'RES';
	
	else
		update hoadon
        set hoadon.Phuongthuc=phuongthuc, hoadon.Phidonhang=phidonhang, hoadon.Phigiaohang=phigiaohang, hoadon.ID_donhang=IDdonhang
        where hoadon.ID=selected_id;
        select "Thay đổi thành công" AS 'RES';
	end if;
end $
DELIMITER ;
-- Test
-- Insert
-- -- Bình thường

drop procedure addHoaDon;
drop procedure updateHoadonByID;
drop procedure removeHoadonByID;
call addHoadon(11,"Trực tiếp",2000,2);
-- -- Trùng ID
call addHoadon(11,"Trực tiếp",2000,2);
-- -- Sai phương thức
call addHoadon(12,"Thẻ",2000,2);
-- -- Số tiền quá lẻ
call addHoadon(13,"Online",2000,2);
call addHoadon(14,"Online",2020,2);
-- -- Mã đơn hàng không tồn tại
call addHoadon(15,"Online",2000,200);

-- Delete
-- -- Bình thường
call removeHoadonByID(11);
-- -- Không tồn tại ID
call removeHoadonByID(101);

-- Update
-- -- Bình thường
call updateHoadonByID(10,"Trực tiếp",2000,2);
-- -- Không tồn tại ID
call updateHoadonByID(110,"Trực tiếp",2000,2);
-- -- Sai phương thức
call updateHoadonByID(10,"Thẻ",2000,2);
-- -- Số tiền quá lẻ
call updateHoadonByID(10,"Online",2000,2);
call updateHoadonByID(10,"Online",2020,2);
-- -- Mã đơn hàng không tồn tại
call updateHoadonByID(10,"Online",2000,200);