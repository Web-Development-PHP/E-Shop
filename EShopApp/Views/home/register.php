<form action="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/register" method="post">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="password" name="confirmPassword">
    <input type="text" name="email">
    <input type="submit" value="Register!">
</form>
<a href="login">Go to login</a>
<a href="index">Go to welcome</a>