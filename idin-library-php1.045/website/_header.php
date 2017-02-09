<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BankId Merchant Website - PHP</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/Site.css" rel="stylesheet">
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">BankId Merchant Website - PHP</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="directory.php">Directory</a></li>
                    <li><a href="authenticate.php">Authenticate</a></li>
                    <li><a href="getresponse.php">GetResponse</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container body-content">

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
