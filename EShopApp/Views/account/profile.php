<?php /*** @var \EShop\ViewModels\UserViewModel $model */ ?>

<h2>This is profile page</h2>
<div>
    <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/viewCart">View Cart</a>
</div>
<div>
    <p><?= $this->userViewModel->getCash(); ?></p>
    <p><?= $this->userViewModel->getUsername();?></p>
    <p><?= $this->userViewModel->getAge();?></p>
    <p><?= $this->userViewModel->getFullname();?></p>
    <p><?= $this->userViewModel->getRoleName();?></p>
</div>
