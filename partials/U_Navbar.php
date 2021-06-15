
<div class="d-flex justify-content-end px-3">

    <div class="text-dark _shadow px-4 pt-2">
            <h6><strong>USER: <?php echo strtoupper($_SESSION['name']) ?> </strong></h6>
        </div>
    <a href="/inventory_sheet/php/U_logout.php"><button type="button" class="btn btn-primary">Log Out</button></a>
</div>

<div class="l-navbar" id="navbar">
    <nav class="nav">
        <div>
            <div class="nav__brand">
                <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                <a href="/INVENTORY_SHEET/php/User_Panel.php" class="nav__logo a1">User Panel&nbsp</a>
            </div>
            <div class="nav__list">
                <a href="/INVENTORY_SHEET/php/User_Panel.php" class="nav__link a1">
                    <ion-icon name="home-outline" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Dashboard</b></span>
                </a>
                <a href="/inventory_sheet/php/U_inventory_Table.php" class="nav__link a1">
                    <ion-icon name="basket" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Inventory</b></span>
                </a>
                <a href="/inventory_sheet/php/U_Food_Table.php" class="nav__link a1">
                    <ion-icon name="gift" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Donation</b></span>
                </a>
                <a href="#" class="nav__link disabled a1">
                    <ion-icon name="people" class="nav__icon disabled"></ion-icon>
                    <span class="nav__name disabled text-danger"><b>User's</b></span>
                </a>
                <a href="" class="nav__link a1" data-bs-toggle="modal" data-bs-target="#insertModal">
                    <ion-icon name="add-circle" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>ADD</b></span>
                </a>
            </div>
        </div>

        <a href="#" class="nav__link a1">
        <ion-icon name="arrow-up" class="nav__icon"></ion-icon>
            <span class="nav__name"><b>GO-TOP</b></span>
        </a>
    </nav>
</div>
<!-- ===== IONICONS ===== -->
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>

<!-- ===== MAIN JS ===== -->
<script src="/inventory_sheet/js/main.js"></script>