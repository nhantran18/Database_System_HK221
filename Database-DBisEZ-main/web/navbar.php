<link rel="stylesheet" href="./style/navbar.css">
<nav class="navbar navbar-expand-lg bg-custom">
    <div class="container-fluid nav-cont">
        <div class="col-md-3 col-12 home text-center">
            <button class="btn btn-menu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" style="padding:10px;">
                Main Menu
            </button>
        </div>
        
        <div class="col-md-6 col-12 text-center">
            <a href="#" class="navbar-brand">
                <img src="./img/logo-white.png" alt="Logo" class="brand-logo">
            </a>
        </div>
        
        <div class="credit col-md-3 col-12 text-center">
            <h4 style="font-weight: bolder;">
                Database Assignment 2
            </h4>
            <h6 style="font-weight: bolder;">
                From team DBisEZ
            </h6>
            <p>
                <a href="https://github.com/LMN1590/Database-DBisEZ" target="_blank" style="color:white; font-size: 20px; text-decoration: none;"><i class="fa-brands fa-github"></i></a>
            </p>
        </div>
        
    </div>
</nav>

<div class="offcanvas offcanvas-start offcanvas-menu" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <img src="./img/logo.png" alt="Logo" class="menu-logo">
        <h4 class="offcanvas-title" id="offcanvasExampleLabel">
            Main Menu
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>
    <div class="offcanvas-body">
        <div>
            Chỉ có một số trang web được hiện thực với đầy đủ các tính năng theo yêu cầu từ đề bài
        </div>
        <div class="dropdown mt-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action list-btn">
                    <i class="fa-solid fa-money-bill"></i> Quản lý hóa đơn
                </a>
                <a type="button" class="list-group-item list-group-item-action list-btn" href="/procedure.php">
                    <i class="fa-solid fa-motorcycle"></i> Lọc đơn hàng theo phương thức thanh toán
                </a>
                <a type="button" class="list-group-item list-group-item-action list-btn" href="/function.php">
                    <i class="fa-solid fa-bowl-food"></i> Lọc hóa đơn theo thông tin người nhận
                </a>
            </div>
        </div>
    </div>
</div>