<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Shop</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<?php
    include_once 'Views/public/navbar.php';
    require_once '../Framework/App.php';

    error_reporting(E_ALL ^ E_NOTICE);
    $app = new \EShop\App();
    $app->start();
    include_once 'Views/public/footer.php';

?>
</div>