<h1>Show categories here ...</h1>

<ul>
<?php foreach($this->categoryViewModel as $category) : ?>
    <li>
        <b><?= $category->getName(); ?></b>
        <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>categories/delete/<?=$category->getId();?>">
            Delete
        </a>
    </li>
<?php endforeach; ?>
</ul>