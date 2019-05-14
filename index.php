<?php require_once("includes/header.php"); ?>
<div class="container-login100">
    <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
        <form class="login100-form validate-form flex-sb flex-w" method="post" action="login.php">
            <?php if (isset($_SESSION['errorMsg']) && $_SESSION['errorMsg'] != "") {
                ?>
                <span class="error"><?php echo $_SESSION['errorMsg']; ?></span>
                <?php
                unset($_SESSION['errorMsg']);
            }
            ?>
            <span class="login100-form-title p-b-32">
                Account Login
            </span>

            <span class="txt1 p-b-11">
                Username
            </span>
            <div class="wrap-input100 validate-input m-b-36" data-validate = "Username is required">
                <input class="input100" type="text" name="username" >
                <span class="focus-input100"></span>
            </div>

            <span class="txt1 p-b-11">
                Password
            </span>
            <div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
                <span class="btn-show-pass">
                    <i class="fa fa-eye"></i>
                </span>
                <input class="input100" type="password" name="password" >
                <span class="focus-input100"></span>
            </div>
            <div class="container-login100-form-btn">
                <input type="submit" name="btnsubmit" id="btnsubmit" value="Login" class="login100-form-btn">
            </div>

        </form>
    </div>
</div>
<?php require_once("includes/footer.php"); ?>