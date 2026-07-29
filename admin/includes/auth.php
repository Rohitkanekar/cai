<?php
require_once "config.php";

/*=========================================
    CHECK LOGIN
=========================================*/

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit();
}