<?php /** * @var \EShop\Models\Product */  ?>

<h2>Category products:</h2>

<ul>
    <?php foreach($this->productViewModel as $product) : ?>
        <li>
            <a href="#"><?= $product->getName(); ?></a>
            <div>
                <b>Quantity: <?= $product->getQuantity(); ?></b>
            </div>
            <div>
                <b>Price: <?= $product->getPrice(); ?></b>
            </div>
            <a href="">Add to cart</a>
        </li>
    <?php endforeach; ?>
</ul>