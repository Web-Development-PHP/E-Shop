<?php /** * @var \EShop\Models\Product */  ?>

<div class="row">
    <div class="col-sm-12">
        <h2>Category products:</h2>

        <ul class="list-group col-lg-8">
            <?php foreach($this->productViewModel as $product) : ?>
                <li class="list-group-item">
                    <div>
                        <h3><?= $product->getName(); ?></h3>
                        <b>Quantity: </b><span class="badge"><?= $product->getQuantity(); ?></span>

                        <span class="input-group-addon price">Price:  <?= $product->getPrice(); ?> лв.</span>
                        <div class="btn-group">
                            <?= $this->renderEditProductButton($product->getName(), $product->getId(), $product->getQuantity()); ?>
                            <?= $this->renderDeleteProductButton($product->getId()); ?>
                        </div>
                    </div>
                    <a class="btn btn-primary" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/addToCart/<?= $product->getId(); ?>">
                        Add to cart <span class="glyphicon glyphicon-shopping-cart"></span></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if(\EShop\Config\AppUserRolesConfig::hasAddEditDeletePriviligies()) : ?>
        <a href="" id="showProductMenu2" class="btn btn-primary">Show Add Product</a>
        <div id="productMenu2">
            <?php $this->renderAddProductMenu();?>
        </div>
        <?php endif; ?>
    </div>
</div>