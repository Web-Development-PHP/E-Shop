<?php /** * @var \EShop\Models\Cart */  ?>

<div class="row">
    <div class="col-lg-12">
        <h3>Cart owner: <?= $this->cart[0]->getCartOwner(); ?></h3>
        <div class="col-lg-8">
            <ul class="list-group">
                <?php foreach($this->cart as $cartItems): ?>
                    <li class="list-group-item">
                        <p><b><?= $cartItems->getProductName(); ?></b></p>
                        <p>Price : <b><?= $cartItems->getProductPrice(); ?></b></p>
                        <!--                    TODO-->
                        <a href="<?= \EShop\Config\RouteConfig::getBasePath(); ?>account/removeProduct/<?= $cartItems->getId(); ?>/<?= $cartItems->getProductId(); ?>">
                            Remove from cart
                        </a>
                    </li>
                <?php  endforeach;?>
            </ul>
        </div>
        <div>
            <b>Total price: </b> <?= $this->getProductsTotalSum(); ?> лв.
        </div>
        <?php
        \EShop\Helpers\ViewHelpers\FormViewHelper::initSubmitButton()
            ->setValue('Checkout cart')
            ->setAttribute('class', 'btn btn-success')
            ->create();
        \EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath() . 'account/checkoutCart/' . $this->cart[0]->getId())
            ->setMethod('post')->render();
        ?>
    </div>
</div>