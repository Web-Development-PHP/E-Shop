<h2>This is profile page</h2>

<div>
    <p><?= $this->userViewModel->getCash(); ?></p>
    <p><?= $this->userViewModel->getUsername();?></p>
    <p><?= $this->userViewModel->getAge();?></p>
    <p><?= $this->userViewModel->getFullname();?></p>
</div>
<form action="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/logout" method="post">
    <input type="submit" name="logout" value="Logout">
</form>