<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">MCIS-Mini Car Inventory System </a>
        </div>
        <?php
        if ((isset($_SESSION['login_user']) && $_SESSION['login_user'] != "") && $pagename != 'index.php') {
            ?>
            <span style="color:#ebebeb;"><B>
                    <?php
                    echo "Welcome " . $_SESSION['login_user'];
                    echo "<BR><a href='logout.php'>Logout</a>";
                    ?></B>
            </span>

            <ul class="nav navbar-nav">
                <li class="active"><a href="welcome.php">Front End</a></li>
                <li><a href="manufacturer.php">Manufacture</a></li>
                <li><a href="carmodels.php">Car Model</a></li>
                <li><a href="inventory.php">Inventory</a></li>
            </ul><?php } ?>
    </div>
</nav>