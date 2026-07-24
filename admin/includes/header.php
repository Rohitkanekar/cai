<?php
require_once "auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Concrete Arts India | Admin Panel</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {

            background: #f4f6f9;

        }

        a {

            text-decoration: none;

        }

        ul {

            margin: 0;
            padding: 0;
            list-style: none;

        }

        /*===============================
            SIDEBAR
        ===============================*/

        .sidebar {

            position: fixed;

            top: 0;

            left: 0;

            width: 270px;

            height: 100vh;

            background: #1f2937;

            color: #fff;

            overflow-y: auto;

            box-shadow: 4px 0 15px rgba(0, 0, 0, .08);

        }

        .logo {

            padding: 30px 20px;

            background: #b88e2f;

            text-align: center;

        }

        .logo h4 {

            margin: 0;

            color: #fff;

            font-weight: 600;

        }

        .logo span {

            font-size: 13px;

            color: #fff;

        }

        .sidebar ul {

            padding: 20px 0;

        }

        .sidebar ul li {

            margin: 6px 0;

        }

        .sidebar ul li a {

            display: flex;

            align-items: center;

            gap: 15px;

            color: #fff;

            padding: 15px 25px;

            transition: .3s;

            font-size: 15px;

        }

        .sidebar ul li a:hover {

            background: #b88e2f;

            color: #fff;

        }

        .sidebar i {

            width: 22px;

            text-align: center;

        }

        /*===============================
            CONTENT
        ===============================*/

        .main-content {

            margin-left: 270px;

            padding: 30px;

        }

        select option{
            text-transform: capitalize;
        }
    </style>

</head>

<body>