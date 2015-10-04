<?php /** * @var \EShop\Models\Category */  ?>

<div class="row">
    <div class="col-sm-12">
        <h1>All Categories</h1>

        <ul class="nav nav-pills nav-stacked">
            <?php foreach($this->categoryViewModel as $category) : ?>
                <li>
                    <h3>
                        <?php $this->renderDeleteButton($category->getId()); ?>
                        <a id="categoryName" href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>categories/products/<?=$category->getId();?>">
                            <?= $category->getName(); ?>
                        </a>
                    </h3>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if(\EShop\Config\AppUserRolesConfig::hasAddEditDeletePriviligies()) : ?>
        <a href="" id="showProductMenu" class="btn btn-primary">Show Add Product</a>
        <div id="productMenu">
            <?php $this->renderAddProductMenu(); ?>
        </div>
        <a href="" id="showCategoryMenu" class="btn btn-primary">Show Add Category</a>
        <div id="categoryMenu">
            <?php $this->renderAddCategoryMenu(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>