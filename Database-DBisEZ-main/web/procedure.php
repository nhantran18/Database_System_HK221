<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <!-- jQuery CDN-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <?php $IPATH = $_SERVER["DOCUMENT_ROOT"];
    include($IPATH."\\navbar.php");?>

    <div class="container info">
        <h3 class="my-3">Danh sách đơn hàng</h3>
        <form class="d-flex mb-3" role="search" method="post">
            <input class="form-control me-2" type="search" name="phuongthuc" placeholder="Phương thức thanh toán" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID người nhận</th>
                    <th scope="col">Họ</th>
                    <th scope="col">Tên</th>
                    <th scope="col">ID đơn hàng</th>
                    <th scope="col">Phương thức</th>
                    <th scope="col">Cập nhật/ Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['phuongthuc'])) {
                    $phuongthuc = $_POST['phuongthuc'];
                    require_once('controller\config.php');
                    $query = 'CALL Hoadoncophuongthuc("' . $phuongthuc .'")';
                    if ($phuongthuc === '') {
                        $query = 'SELECT K.IDtaikhoan, K.Ho, K.Ten, D.ID as IDdonhang, H.ID as IDhoadon, H.Phuongthuc from (Hoadon as H inner join Donhang as D on H.ID_donhang = D.ID) 
                                inner join khachhang as K on K.IDtaikhoan = D.ID_nguoinhan';
                    }
                    $res = $conn->query($query);
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            if (isset($row['Thông báo lỗi'])) {
                                echo '<script>alert("' . $row['Thông báo lỗi'] . '")</script>';
                            }
                            else {
                                echo '
                                <tr>
                                    <th scope="row">' . $row['IDtaikhoan'] .'</th>
                                    <td>' . $row['Ho'] .'</td>
                                    <td>' . $row['Ten'] . '</td>
                                    <td>' . $row['IDdonhang'] .'</td>
                                    <td>' . $row['Phuongthuc'] . '</td>
                                    <td>
                                        <button 
                                            type="button" 
                                            class="btn btn-primary" 
                                            onclick="openUpdate(' . $row['IDhoadon'] . ')" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#exampleModal"
                                        >Cập nhật</button>
                                        <button 
                                            type="button" 
                                            class="btn btn-danger"
                                            onclick="handleDelete(' . $row['IDhoadon'] . ')" 
                                        >Xóa</button>
                                    </td>
                                </tr>
                                ';
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa thông tin hóa đơn</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="IDhoadon" class="form-label">ID hóa đơn</label> 
                        <input type="text" class="form-control" id="IDhoadon" disabled readonly>
                    </div>
                    <div class="mb-1">Phương thức</div>
                    <select class="form-select mb-3" aria-label="Default select example" id="phuongthuc">
                        <option value="offline">Trực tiếp</option>
                        <option value="online">Online</option>
                    </select>
                    <div class="mb-3">
                        <label for="phidonhang" class="form-label">Phí đơn hàng</label> 
                        <input type="text" class="form-control" id="phidonhang" disabled readonly>
                    </div>
                    <div class="mb-3">
                        <label for="phigiaohang" class="form-label">Phí giao hàng</label> 
                        <input type="text" class="form-control" id="phigiaohang">
                    </div>
                    <div class="mb-3">
                        <label for="IDdonhang" class="form-label">ID đơn hàng</label> 
                        <input type="text" class="form-control" id="IDdonhang">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="handleUpdate()">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    function openUpdate(id) {
        $.ajax({
            method:"post",
            url:"./controller/getAllHD.php",
            data:{
                id: id
            },
            success: function(data,status){
                console.log(data);
                data=JSON.parse(data);

                data.forEach(function(hoadon){
                    document.getElementById('IDhoadon').value = hoadon['ID'];
                    document.getElementById('phuongthuc').value = (hoadon['Phuongthuc'] === "Trực tiếp" ? "offline" : "online");
                    document.getElementById('phidonhang').value = hoadon['Phidonhang'];
                    document.getElementById('phigiaohang').value = hoadon['Phigiaohang'];
                    document.getElementById('IDdonhang').value = hoadon['ID_donhang'];
                });
            }
        });
    }

    function handleUpdate() {
        $.ajax({
            method:"post",
            url:"./controller/edit.php",
            data:{
                selected_id: $('#IDhoadon').val(),
                phuongthuc: $('#phuongthuc').val() === 'offline' ? "Trực tiếp" : "Online",
                phigiaohang: $('#phigiaohang').val(),
                IDdonhang: $('#IDdonhang').val()
            },
            success: function(data,status) {
                alert(data);
            }
        });
    }

    function handleDelete(id) {
        $.ajax({
            method:"post",
            url:"./controller/remove.php",
            data:{
                id: id
            },
            success: function(data,status) {
                alert(data);
            }
        });
    }
</script>