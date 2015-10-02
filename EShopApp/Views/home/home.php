<?php /** * @var \EShop\ViewModels\HomeViewModel */  ?>

<h1>Welcome to our site</h1>

<div>
    <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>home/login">Login</a>
</div>
<div>
    <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>home/register">Register</a>
</div>
<?php
//$this->renderSampleAjax();