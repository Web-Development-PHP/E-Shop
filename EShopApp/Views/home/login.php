<form action= "<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/login" method="post">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" value="Login!">
</form>
<a href="register">Go to register</a>
<a href="index">Go to welcome</a>