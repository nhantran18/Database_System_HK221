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
        <h3 class="my-3">Danh sách hóa đơn</h3>
        <form class="d-flex mb-3" role="search" method="post">
            <input class="form-control me-2" type="search" name="ID" placeholder="ID người nhận" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID người nhận</th>
                    <th scope="col">ID hóa đơn</th>
                    <th scope="col">ID đơn hàng</th>
                    <th scope="col">Phương thức</th>
                    <th scope="col">Phí đơn hàng</th>
                    <th scope="col">Phí giao hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['ID'])) {
                    $id = $_POST['ID'];
                    require_once('controller\config.php');
                    $query = '';
                    if ($id == '') {
                        $query = 'SELECT D.ID_nguoinhan, H.ID, Phuongthuc, Phidonhang, Phigiaohang, ID_donhang 
                                    FROM Hoadon as H INNER JOIN Donhang as D ON H.ID_donhang = D.ID';
                    }
                    else {
                        $query = 'SELECT D.ID_nguoinhan, H.ID, Phuongthuc, Phidonhang, Phigiaohang, ID_donhang 
                                    FROM Hoadon as H INNER JOIN Donhang as D ON H.ID_donhang = D.ID
                                    WHERE D.ID_nguoinhan=' . $id;   
                    }
                    $res = $conn->query($query);
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            $price_query = 'SELECT TONGTIENDONHANG(' . $row['ID_donhang'] .')';
                            $total = $conn->query($price_query);
                            $total_res = $total->fetch_assoc();
                            echo '
                            <tr>
                                <th scope="row">' . $row['ID_nguoinhan'] .'</th>
                                <td>' . $row['ID'] .'</td>
                                <td>' . $row['ID_donhang'] . '</td>
                                <td>' . $row['Phuongthuc'] .'</td>
                                <td>' . $total_res['TONGTIENDONHANG(' . $row['ID_donhang'] .')'] . '</td>
                                <td>' . $row['Phigiaohang'] . '</td>
                            </tr>
                            ';
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
    
</script>