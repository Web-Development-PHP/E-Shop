<?php /** * @var \EShop\Models\Cart */  ?>

<div>
    <h3>Cart owner: <?= $this->cart[0]->getCartOwner(); ?></h3>
    <div>
        <ul>
            <?php foreach($this->cart as $cartItems): ?>
                <li>
                    <p><b><?= $cartItems->getProductName(); ?></b></p>
                    <p>Price : <b><?= $cartItems->getProductPrice(); ?></b></p>
                </li>
            <?php  endforeach;?>
        </ul>
    </div>
</div>