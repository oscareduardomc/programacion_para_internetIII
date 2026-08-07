<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Tickets de Soporte</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="assets/css/style.css" rel="stylesheet">

    <style>

        body{

            background:#f4f6f9;
            overflow-x:hidden;

        }

        a{

            text-decoration:none;

        }

        .content{

            margin-left:260px;
            padding:20px;
            transition:.3s;

        }

        @media(max-width:991px){

            .content{

                margin-left:0;

            }

        }

        .card{

            border:none;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,.08);

        }

        .table thead{

            background:#0d6efd;
            color:white;

        }

        .sidebar {

            width: 250px;
            height: 100vh;
            background: #212529;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            color: white;

        }

        .sidebar-header {

            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, .1);

        }

        .sidebar-header h4 {

            margin: 0;

        }

        .usuario {

            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);

        }

        .avatar {

            width: 50px;
            height: 50px;
            background: #0d6efd;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;

        }

        .menu {

            list-style: none;
            margin: 0;
            padding: 0;

        }

        .menu li {

            width: 100%;

        }

        .menu li a {

            display: block;
            color: #dee2e6;
            padding: 13px 20px;
            transition: .3s;

        }

        .menu li a:hover {

            background: #0d6efd;
            color: white;

        }

        .menu li a i {

            width: 25px;

        }

        .titulo {

            padding: 15px 20px 8px;
            color: #adb5bd;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;

        }

        .navbar{
            margin-left: 250px;
            height: 65px;
            transition: .3s;
        }
         @media(max-width:991px){

            .navbar{

                margin-left:0;

            }

        }

        .sidebar.cerrado{
            margin-left: -250px;

        }
        .content.expandido{
            margin-left: 0;
        }
        .navbar.expandido{
            margin-left: 0;
        }
    </style>

</head>

<body>
