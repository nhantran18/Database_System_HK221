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
    <link rel="stylesheet" href="./style/style.css">
    <title>Document</title>
</head>
<body>
    <?php $IPATH = $_SERVER["DOCUMENT_ROOT"];
    include($IPATH."\\navbar.php");?>

    <div class="container info">
        <div class="row">
            <div class="col-md-6 col-12 online">
                <div class="row">
                    <div class="col-4 info-box num-order">
                        <h4></h4>
                        <p>Đơn hàng giao</p>
                    </div>
                    <div class="col-4 info-box sum-order">
                        <h4></h4>
                        <p>Tổng tiền đơn</p>
                    </div>
                    <div class="col-4 info-box sum-ship">
                        <h4></h4>
                        <p>Tổng tiền giao</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 real">
                <div class="row">
                    <div class="col-4 info-box num-order">
                        <h4></h4>
                        <p>Đơn hàng giao</p>
                    </div>
                    <div class="col-4 info-box sum-order">
                        <h4></h4>
                        <p>Tổng tiền đơn</p>
                    </div>
                    <div class="col-4 info-box sum-ship">
                        <h4></h4>
                        <p>Tổng tiền giao</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="title d-flex justify-content-between">
                <h4>Bảng thống kê các hóa đơn</h4>
                <button class="btn btn-custom" onclick="add();">Thêm</button>
            </div>
        </div>
        <div class="table-wrapper">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Phương thức</th>
                        <th scope="col">Phí đơn hàng</th>
                        <th scope="col">Phí giao hàng</th>
                        <th scope="col">ID đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr onclick="showModal(1);" class="data">
                        <th scope="row">1</th>
                        <td>Online</td>
                        <td>20000</td>
                        <td>111111</td>
                        <td>1</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</body>
</html>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-text" id="ID">ID</span>
                    <input type="number" class="form-control" id="valID" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-text" id="Phuongthuc">Phương thức</span>
                    <input type="text" class="form-control" id="valPT">
                </div>
                <div class="input-group">
                    <span class="input-group-text" id="totalCost">Phí đơn hàng</span>
                    <input type="number" class="form-control" id="valTotalCost" disabled>
                </div>
                <div class="input-group">
                    <span class="input-group-text" id="totalShip">Phí giao hàng</span>
                    <input type="number" class="form-control" id="valTotalShip">
                </div>
                <div class="input-group">
                    <span class="input-group-text" id="totalShip">ID đơn hàng</span>
                    <input type="number" class="form-control" id="valIDdh">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button id="editBtn" type="button" class="btn btn-primary">Sửa</button>
                <button id="delBtn" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
</div>
<script>
    function getInfo(type){
        if(type==="online"){
            $.ajax({
                method:"post",
                url:"./controller/getInfo.php",
                data:{
                    type: "Online"
                },
                success: function(data,status){
                    console.log(data);
                    data=JSON.parse(data);
                    $(".online .num-order h4").html(data['count']);
                    $(".online .sum-order h4").html(data['totalCost']);
                    $(".online .sum-ship h4").html(data['totalShip']);
                }
            });
        }
        else if(type==="real"){
            $.ajax({
                method:"post",
                url:"./controller/getInfo.php",
                data:{
                    type: "Trực tiếp"
                },
                success: function(data,status){
                    console.log(data);
                    data=JSON.parse(data);
                    $(".real .num-order h4").html(data['count']);
                    $(".real .sum-order h4").html(data['totalCost']);
                    $(".real .sum-ship h4").html(data['totalShip']);
                }
            });
        }
    }
    function getAllHD(id){
        $.ajax({
            method:"post",
            url:"./controller/getAllHD.php",
            data:{
                id: id
            },
            success: function(data,status){
                console.log(data);
                data=JSON.parse(data);
                $("tbody").empty();
                data.forEach(function(hoadon){
                    let row=$("<tr onclick=\"showModal("+hoadon['ID']+");\" class=\"data\"></tr>");
                    
                    let headerID=$("<th scope=\"row\"></th>").html(hoadon['ID']);
                    row.append(headerID);

                    let phuongthuc=$("<td></td>").html(hoadon['Phuongthuc']);
                    row.append(phuongthuc);

                    let totalCost = $("<td></td>").html(hoadon['Phidonhang']);
                    row.append(totalCost);
                    
                    let totalShip=$("<td></td>").html(hoadon['Phigiaohang']);
                    row.append(totalShip);

                    let idDon=$("<td></td>").html(hoadon['ID_donhang']);
                    row.append(idDon);

                    $("tbody").append(row);
                });
            }
        });
    }
    function showModal(id){
        $.ajax({
            method:"post",
            url:"./controller/getAllHD.php",
            data:{
                id: id
            },
            success: function(data,status){
                console.log(data);
                data=JSON.parse(data);
                hoadon=data[0];
                $(".modal-title").html("Chỉnh sửa thông tin cho hóa đơn "+String(hoadon['ID']));
                $("#valID").attr("disabled",true);
                $("#valID").val(hoadon['ID']);
                $("#valPT").val(hoadon['Phuongthuc']);
                $("#valTotalCost").val(hoadon['Phidonhang']);
                $("#valTotalShip").val(hoadon['Phigiaohang']);
                $("#valIDdh").val(hoadon['ID_donhang']);
                $("#editModal").modal("show");
                $("#editBtn").html("Sửa");
                $("#editBtn").attr("onclick","edit("+String(hoadon['ID']+")"));
                $("#delBtn").css("display","block");
                $("#delBtn").attr("onclick","del("+String(hoadon['ID']+")"));
            }
        });
    }

    function del(id){
        alert("Xóa hóa đơn có ID: "+String(id)+"?");
        $("#editModal").modal("hide");
        $.ajax({
            method:"post",
            url:"./controller/remove.php",
            data:{
                id:id 
            },
            success: function(data,status){
                console.log(data);
                alert(data);
                getAllHD(0);
                getInfo("online");
                getInfo("real");
            }
        });
    }

    function edit(id){
        alert("Chỉnh hóa đơn có ID: "+String(id)+"?");
        $("#editModal").modal("hide");
        $.ajax({
            method:"post",
            url:"./controller/edit.php",
            data:{
                selected_id:id,
                phuongthuc: $("#valPT").val(),
                phigiaohang: $("#valTotalShip").val(),
                IDdonhang: $("#valIDdh").val()
            },
            success: function(data,status){
                console.log(data);
                alert(data);
                getAllHD(0);
                getInfo("online");
                getInfo("real");
            }
        });
    }

    function add(){
        $(".modal-title").html("Thêm hóa đơn");
        $("#valID").attr("disabled",false);
        $("#delBtn").css("display","none");
        $("#editBtn").html("Thêm");
        $("#editModal").modal("show");
        $("#editBtn").attr("onclick","addInner();");
    }

    function addInner(){
        alert("Thêm một hóa đơn ?");
        $("#editModal").modal("hide");
        $.ajax({
            method:"post",
            url:"./controller/add.php",
            data:{
                id:$("#valID").val(),
                phuongthuc: $("#valPT").val(),
                phigiaohang: $("#valTotalShip").val(),
                IDdonhang: $("#valIDdh").val()
            },
            success: function(data,status){
                console.log(data);
                alert(data);
                getAllHD(0);
                getInfo("online");
                getInfo("real");
            }
        });
    }

    $(window).on('load',function(){
        getInfo("online");
        getInfo("real");
        getAllHD(0);
    });
</script>