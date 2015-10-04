<?php /*** @var \EShop\Models\User $model */ ?>
<div class="row">
    <div class="col-lg-12">
        <h1>Hello Admin</h1>
        <div class="promotions">
            <div class="categories-promotions">
                <h3>Add Categories promotion</h3>
                <?= $this->renderCategoriesPromoMenu(); ?>
                <div class="valid-category-promos">
                    <?= $this->renderPromotionsForCategory(); ?>
                </div>
            </div>
            <div class="allProducts-promotions">
                <h3>All products promotion</h3>
                <?= $this->renderAllProductsPromoMenu(); ?>
                <div class="valid-allProducts-promos">
                    <?= $this->renderPromotionsForAllProducts(); ?>
                </div>
            </div>
            <div class="certainProducts-promotions">
                <h3>Promotion on certain product</h3>
                <?= $this->renderCertainProductsPromoMenu(); ?>
                <div class="valid-customProducts-promos">
                    <?= $this->renderCustomPromoProducts(); ?>
                </div>
            </div>
        </div>
    </div>
</div>