<form action="<?= \EShop\Config\RouteConfig::getBasePath(); ?>categories/add" method="post">
    <input type="text" name="name">
    <input type="submit" value="Add Category">
    <input type="hidden" name="formToken" value="<?= \EShop\Helpers\TokenHelper::getCSRFToken(); ?>" />
</form>