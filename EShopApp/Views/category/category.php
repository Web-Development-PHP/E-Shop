<?php /** * @var \EShop\Models\Category */  ?>

<h1>Show categories here ...</h1>

<ul>
<?php foreach($this->categoryViewModel as $category) : ?>
    <li>
        <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>categories/products/<?=$category->getId();?>">
            <?= $category->getName(); ?>
        </a>
    </li>
    <?php $this->renderDeleteButton($category->getId()); ?>
<?php endforeach; ?>
</ul>
<div>
<?php $this->renderAddProductMenu(); ?>
</div>
<div>
    <?php $this->renderAddCategoryMenu(); ?>
</div>