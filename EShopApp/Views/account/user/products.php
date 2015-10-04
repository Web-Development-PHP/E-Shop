<?php /** * @var \EShop\Models\MiniProduct */  ?>

<div class="row">
    <div class="col-lg-12">
        <h3> Hello, <?= $this->userProducts[0]->getUsername(); ?></h3>
        <div>
            <ul class="list-group">
                <?php foreach($this->userProducts as $product): ?>
                    <li class="list-group-item">
                        <p>
                            <span>Category name: <strong>[<?= $product->getCategoryName(); ?>]</strong></span>
                            <strong><?= $product->getProductName(); ?></strong>
                            <span>Price : <b><?= $product->getPrice(); ?></b></span>
                            <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/sellProduct/<?= $product->getId();?>">
                                [Sell]
                            </a>
                        </p>
                    </li>
                <?php  endforeach;?>
            </ul>
        </div>
    </div>
</div>