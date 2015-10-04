<?php /*** @var \EShop\ViewModels\UserViewModel $model */ ?>

<div class="row">
    <div>
        <div class="jumbotron">
            <h1>User Profile</h1>
            <h3>Hello, <?= $this->userViewModel->getUsername();?></h3>
            <div class="col-lg-12">
                <div class="list-group col-lg-4">
                    <div>
                        <?= $this->enterAdminPanel(); ?>
                    </div>
                    <div>
                        <a class="list-group-item" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/renderChangePasswordMenu">Change password</a>
                    </div>
                    <div>
                        <a class="list-group-item" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/viewCart">View Cart</a>
                    </div>
                    <div>
                        <a class="list-group-item" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/products">View my products</a>
                    </div>
                    <?php if(\EShop\Config\AppUserRolesConfig::hasAddEditDeletePriviligies()) : ?>
                    <div>
                        <a class="list-group-item" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/getSoldProducts">Reorder product</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bs-component">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">User info</h3>
                        </div>
                        <div class="panel-body">
                            <p>My cash: <?= $this->userViewModel->getCash(); ?> лв.</p>
                            <p><?= $this->userViewModel->getAge();?></p>
                            <p><?= $this->userViewModel->getFullname();?></p>
                            <p>Role: <?= $this->userViewModel->getRoleName();?></p>
                            <p>Email: <?= $this->userViewModel->getEmail();?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>