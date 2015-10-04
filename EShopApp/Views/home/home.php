<?php /** * @var \EShop\ViewModels\HomeViewModel */  ?>

<div class="jumbotron">
    <h1>Welcome to E-shop</h1>

<?php if(!isset($_SESSION['id'])) : ?>
    <div>
        <a class="btn btn-primary btn-lg" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>home/login">Login</a>
        <a class="btn btn-default  btn-lg" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>home/register">Register</a>
    </div>
    <div>

    </div>
</div>
<?php endif; ?>
<?php
//$this->renderSampleAjax();