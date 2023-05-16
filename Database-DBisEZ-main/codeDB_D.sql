CREATE DATABASE ASS_DB;
USE ASS_DB;

CREATE TABLE taikhoan (
	idtaikhoan int PRIMARY KEY, 
	tendangnhap varchar(20) NOT NULL,
	matkhau varchar(20) NOT NULL,
    sdt varchar(20) NOT NULL,
    email varchar(100) NOT NULL
);

CREATE TABLE admin (
	idtaikhoan int PRIMARY KEY, 
	ho varchar(20) NOT NULL,
	ten varchar(20) NOT NULL
);

CREATE TABLE khachhang(
	IDtaikhoan int PRIMARY KEY,
    Ho VARCHAR(10) NOT NULL,
    Ten VARCHAR(20) NOT NULL,
    Ngaytaotaikhoan DATE NOT NULL,
    Diemtichluy int NOT NULL,
    Ngaysinh DATE NOT NULL,
    Loaithanhvien VARCHAR(10),
    Tuoi int as (2022 - YEAR(Ngaysinh)) virtual
);
ALTER TABLE khachhang
ADD CONSTRAINT fk_khachhang_IDtaikhoan	FOREIGN KEY (IDtaikhoan)
	REFERENCES taikhoan(idtaikhoan)
    ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE khuyenmai_chung (
	idcuama int PRIMARY KEY,
    giatoithieuapdung int NOT NULL,
    mota varchar(100) NOT NULL,
    makhuyenmai varchar(20) NOT NULL,
    ngaybatdau varchar(10) NOT NULL,
    hansudung varchar(10) NOT NULL,
    soluongtoida int NOT NULL,
    soluongconlai int NOT NULL,
    idnguoitaoma int NOT NULL
);

CREATE TABLE if not exists NhaHang(
	IDTaiKhoan INT primary key,
    TenNhaHang VARCHAR(255) NOT NULL,
    DiaChi VARCHAR(255) NOT NULL,
    Website VARCHAR(255) NOT NULL,
    IDQuanLy INT
);

CREATE TABLE khuyenmaicuahang (
	idcuama int NOT NULL,
    idcuahang int NOT NULL,
    primary key(idcuama, idcuahang),
    foreign key (idcuama) references khuyenmai_chung(idcuama)
    on delete cascade on update cascade,
    foreign key (idcuahang) references NhaHang(IDTaiKhoan)
    on delete cascade on update cascade
);

CREATE TABLE khuyenmaihethong (
	idcuama int NOT NULL,
    loaithanhvien varchar(20) NOT NULL,
    gioihandiemdesudung int NOT NULL,
    primary key (idcuama),
    foreign key (idcuama)  references khuyenmai_chung(idcuama)
    on delete cascade on update cascade
);

CREATE TABLE khuyenmaigiamtien
(
	IDcuama int PRIMARY KEY,
    Sotiengiam int,
    foreign key (IDcuama) references khuyenmai_chung(idcuama)
    on delete cascade on update cascade
);

CREATE TABLE khuyenmaiphantram
(
	IDcuama int PRIMARY KEY,
    Phantramgiam int,
    Tiengiamtoida int,
    foreign key (IDcuama) references khuyenmai_chung(idcuama)
    on delete cascade on update cascade
);

CREATE TABLE Congtyvanchuyen(
   ID     INTEGER  NOT NULL PRIMARY KEY 
  ,Ten    VARCHAR(50) NOT NULL
  ,SDT    INTEGER NOT NULL
  ,Email  VARCHAR(50) NOT NULL
  ,Diachi VARCHAR(256) NOT NULL
);

-- Phần của LMN --
CREATE TABLE if not exists LoaiMonAn(
	IDTaiKhoan INT NOT NULL,
    IDLoaiMonAn INT NOT NULL,
    TenLoaiMonAn VARCHAR(255) NOT NULL,
    PRIMARY KEY(IDTaiKhoan, IDLoaiMonAn)
);

CREATE TABLE if not exists MonAn(
	IDMonAn INT primary KEY,
    TenMonAn VARCHAR(255) NOT NULL,
    AnhMinhHoa VARCHAR(255) NOT NULL,
    MoTa VARCHAR(255) NOT NULL,
    GiaLamMon INT NOT NULL,
    GiaBan INT NOT NULL,
    IDNhaHang INT NOT NULL,
    IDLoaiMonAn INT NOT NULL
);

create table if not exists NguyenLieu(
	IDmonan INT NOT NULL,
    Tennguyenlieu VARCHAR(255) NOT NULL,
    primary key(IDmonan, Tennguyenlieu)
);

CREATE TABLE Noidung_donhang(
   ID_donhang INTEGER  NOT NULL
  ,ID_monan   INTEGER  NOT NULL
  ,Soluongmon INTEGER  NOT NULL
  ,Giamua     INTEGER  NOT NULL
  ,primary key(ID_donhang,ID_monan)
);

CREATE TABLE Hoadon(
   ID          INTEGER  NOT NULL PRIMARY KEY 
  ,Phuongthuc  VARCHAR(9) NOT NULL
  ,Phidonhang  INTEGER  NOT NULL
  ,Phigiaohang INTEGER  NOT NULL
  ,ID_donhang  INTEGER  NOT NULL
);

CREATE TABLE Donhang(
   ID           INTEGER  NOT NULL PRIMARY KEY 
  ,Nguoinhan    VARCHAR(50) NOT NULL
  ,Tinhtrang    VARCHAR(20) NOT NULL
  ,Ghichu       VARCHAR(256)
  ,Diachi       VARCHAR(256) NOT NULL
  ,SDT          INTEGER  NOT NULL
  ,Taixe_SDT    INTEGER  NOT NULL
  ,Taixe_Hoten  VARCHAR(50) NOT NULL
  ,Taixe_Bienso VARCHAR(10) NOT NULL
  ,Taixe_Tenxe  VARCHAR(30) NOT NULL
  ,ID_nguoinhan INTEGER  NOT NULL
  ,ID_congty    INTEGER  NOT NULL
  ,Ngaydathang  DATE  NOT NULL
);

CREATE TABLE Apdung_khuyenmai(
    ID_donhang  INTEGER NOT NULL,
    ID_makhuyenmai  INTEGER NOT NULL,
    PRIMARY KEY(ID_donhang, ID_makhuyenmai)
);

CREATE TABLE gioithieu(
	ID_nguoigioithieu integer not null,
    ID_nguoiduocgioithieu integer not null,
    ID_makhuyenmai integer not null,
    primary key(ID_nguoigioithieu, ID_nguoiduocgioithieu, ID_makhuyenmai)
);

CREATE TABLE thuthap(
	ID_ma integer not null,
    ID_khachhang integer not null,
    primary key(ID_ma, ID_khachhang)
);

ALTER table admin add foreign key (idtaikhoan) references taikhoan(idtaikhoan) on delete cascade on update cascade;
ALTER table loaimonan add foreign key (idtaikhoan) references nhahang(IDtaikhoan) on delete cascade on update cascade;
alter table monan add foreign key (IDnhahang,idloaimonan) references loaimonan(idtaikhoan,idloaimonan) on delete cascade on update cascade;
ALTER table nguyenlieu add foreign key (idmonan) references monan(idmonan) on delete cascade on update cascade;
alter table noidung_donhang add foreign key (ID_monan) references monan(IDmonan) on delete cascade on update cascade;
alter table noidung_donhang add foreign key (ID_donhang) references donhang(ID) on delete cascade on update cascade;
alter table nhahang add foreign key (IDquanly) references admin(idtaikhoan) on delete cascade on update cascade;
alter table khuyenmai_chung add foreign key (idnguoitaoma) references admin(idtaikhoan) on delete cascade on update cascade;
alter table nhahang add foreign key (idtaikhoan) references taikhoan(idtaikhoan) on delete cascade on update cascade;
alter table Apdung_khuyenmai add foreign key (ID_donhang) references donhang(ID)  on delete cascade on update cascade;
alter table Apdung_khuyenmai add foreign key (ID_makhuyenmai) references khuyenmai_chung(idcuama)  on delete cascade on update cascade;
alter table hoadon add foreign key (ID_donhang) references donhang(ID) on delete cascade on update cascade;
alter table donhang add foreign key (ID_congty) references congtyvanchuyen(ID) on delete cascade on update cascade;
alter table donhang add foreign key (ID_nguoinhan) references khachhang(IDtaikhoan) on delete cascade on update cascade;
alter table gioithieu add foreign key (ID_nguoigioithieu) references khachhang(IDtaikhoan) on delete cascade on update cascade;
alter table gioithieu add foreign key (ID_nguoiduocgioithieu) references khachhang(IDtaikhoan) on delete cascade on update cascade;
alter table gioithieu add foreign key (ID_makhuyenmai) references khuyenmai_chung(idcuama) on delete cascade on update cascade;
alter table thuthap add foreign key (ID_ma) references khuyenmai_chung(idcuama) on delete cascade on update cascade;
alter table thuthap add foreign key (ID_khachhang) references khachhang(IDtaikhoan) on delete cascade on update cascade;
-----------------------



