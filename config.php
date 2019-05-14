<?php

session_start();
$pagename = substr($_SERVER['PHP_SELF'], strripos($_SERVER['PHP_SELF'], "/") + 1);
if (!(isset($_SESSION['login_user']) && $_SESSION['login_user'] != "") && $pagename != 'index.php') {
    header("Location: index.php");
}

$db_config = [
    //current development environment
    "env" => "development",
    //Localhost
    "development" => [
        "host" => "localhost",
        "database" => "mcis",
        "username" => "root",
        "password" => "root"
    ],
    //Server
    "production" => [
        "host" => "sql313.epizy.com",
        "database" => "epiz_23902942_mcis",
        "username" => "epiz_23902942",
        "password" => "zxI7pWQt"
    ]
];

if ($db_config['env'] == "development") {
    $config = $db_config['development'];
} elseif ($db_config['env'] == "production") {
    $config = $db_config['production'];
} else {
    die("Environment must be either 'development' or 'production'.");
}

require_once("classes/MysqliDB.php");
$db = new MysqliDb($config['host'], $config['username'], $config['password'], $config['database']);
?>