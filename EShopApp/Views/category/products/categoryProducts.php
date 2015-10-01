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
<?php
\EShop\Helpers\ViewHelpers\FormViewHelper::initTextField()
    ->setName("productName")
    ->setAttribute('placeholder', 'Product name...')
    ->create();
\EShop\Helpers\ViewHelpers\FormViewHelper::initTextField()
    ->setName("productPrice")
    ->setAttribute("placeholder", "Product price")
    ->create();
\EShop\Helpers\ViewHelpers\FormViewHelper::initHiddenField()
    ->setName("categoryId")
    ->setValue(substr($_GET['uri'], strlen($_GET['uri'])- 1, strlen($_GET['uri'])))
    ->create();
\EShop\Helpers\ViewHelpers\FormViewHelper::initNumberField()
    ->setName("quantity")
    ->setAttribute('min', '1')
    ->create();
\EShop\Helpers\ViewHelpers\FormViewHelper::initSubmitButton()
    ->setValue('Add Product')
    ->create();

\EShop\Helpers\ViewHelpers\FormViewHelper::setAction(\EShop\Config\RouteConfig::getBasePath(). 'products/addProduct');
\EShop\Helpers\ViewHelpers\FormViewHelper::setMethod("post");
\EShop\Helpers\ViewHelpers\FormViewHelper::render();