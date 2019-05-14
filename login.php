<?php
include("config.php");
if ((isset($_SESSION['login_user']) && $_SESSION['login_user'] != "")) {
    $_SESSION['login_user'] = $myusername;
    header("location: welcome.php");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['btnsubmit'] == "Login") {
        // username and password sent from form
        $myusername = $_POST['username'];
        $mypassword = md5($_POST['password']);
        $db->where('username', $myusername);
        $db->where('password', $mypassword);
        $users = $db->get('users');
        
        $count = sizeof($users);
        // If result matched $myusername and $mypassword, table row must be 1 row
        if ($count == 1) {
            //session_register("myusername");
            $_SESSION['login_user'] = $myusername;
            header("location: welcome.php");
        } else {
            $error = "Your Login Name or Password is invalid";
            $_SESSION['errorMsg'] = $error;
            header("location: index.php");
        }
    } else {
        header("location: index.php");
    }
}
?>