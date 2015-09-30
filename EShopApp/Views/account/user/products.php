<?php /** * @var \EShop\Models\MiniProduct */  ?>

<h3> Hello, <?= $this->userProducts[0]->getUsername(); ?></h3>
<div>
    <ul>
        <?php foreach($this->userProducts as $product): ?>
            <li>
                <p>
                    <b><?= $product->getProductName(); ?></b>
                <span>Price : <b><?= $product->getPrice(); ?></b></span>
                <a href="#">[Sell]</a>
                </p>
            </li>
        <?php  endforeach;?>
    </ul>
</div>
