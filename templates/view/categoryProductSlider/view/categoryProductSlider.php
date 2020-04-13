<?php
$random_id = rand();
$sliderTitle = $data['sliderTitle'];
$options = $data['options'];
$categoryLink = $options['category']['link'];
$categoryId = $options['category']['id'];
if (!isset($options['products'])) {
    return;
}
$productIds = array_column($options['products'],'id');
$itemLimit = 16;
if (wp_is_mobile()) {
    $itemLimit = 10;
}
$productIds = array_slice($productIds, 0, $itemLimit);
//$args = array(
//    'include' => $productIds,
//    'limit' => $itemLimit,
//    'orderby' => 'include'
//);
//$products = wc_get_products( $args );
global $metaCache;

$products = $metaCache->getWcProductsByIds($productIds);
$stickers = new \GfPluginsCore\ProductStickers();
?>
<div id="<?php echo $random_id; ?>" class="gf-product-slider">
    <div class="row gf-product-slider__header gf-product-slider__header--without-tabs">
        <h3 class="gf-product-slider__header__title"><a href="<?= $categoryLink ?>"><?= $sliderTitle ?></a></h3>
        <div class="gf-product-slider__header__controls gf-product-slider__header__controls--without-tabs">
            <a class="product-slider__control-prev gf-product-slider__header-control" href="#" role="button">
                <i class="fas fa-angle-left product-slider__control-prev-icon"></i>
            </a>
            <a class="product-slider__control-next gf-product-slider__header-control" href="#" role="button">
                <i class="fas fa-angle-right product-slider__control-next-icon"></i>
            </a>
        </div>
    </div>
    <div class="slider-inner without-tabs">
        <?php

        /** @var WC_Product $product */
        foreach ($products as $product):?>
            <div class="slider-item">
                <a href="<?=$product->get_permalink()?>" title="<?=$product->get_name()?>">
                    <?= $stickers->addStickerToSaleProducts('',  $product->get_id()); ?>
                    <?php if (has_post_thumbnail($product->get_id())) echo get_the_post_thumbnail($product->get_id(),[150, 150]); else echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />'; ?>
                    <h5><?= $product->get_name() ?></h5>
                    <span class="price"><?php echo $product->get_price_html(); ?></span>
                </a>
                <?php woocommerce_template_loop_add_to_cart($product); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>