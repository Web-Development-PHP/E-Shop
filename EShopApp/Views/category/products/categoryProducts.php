<?php /** * @var \EShop\Models\Product */  ?>

<h2>Category products:</h2>

<ul>
    <?php foreach($this->productViewModel as $product) : ?>
        <li>
            <div>
            <a href="#"><?= $product->getName(); ?></a>

                <b>Quantity: <?= $product->getQuantity(); ?></b>

                <b>Price: <?= $product->getPrice(); ?></b>
            </div>
            <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/addToCart/<?= $product->getId(); ?>">
                Add to cart</a>
        </li>
    <?php endforeach; ?>
</ul>