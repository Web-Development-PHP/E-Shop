<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Eshop/content/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Eshop/content/css/styles.css">
    <script src="/Eshop/content/libs/jquery-2.1.4.js"></script>
    <script src="/Eshop/content/js/app.js"></script>
</head>
<body>
<div class="row">
    <div class="col-lg-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>">Home</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                        <?php if(isset($_SESSION['id'])) : ?>
                        <li class=""><a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/profile">
                                Profile <span class="sr-only">(current)</span></a></li>
                        <li class="">
                            <?php endif; ?>
                            <?php if(isset($_SESSION['id'])) : ?>
                                <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>categories/all">Categories</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if(isset($_SESSION['id'])) : ?>
                        <form action="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/logout" method="post">
                            <input type="submit" class="btn btn-danger" name="logout" value="Logout">
                        </form>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>