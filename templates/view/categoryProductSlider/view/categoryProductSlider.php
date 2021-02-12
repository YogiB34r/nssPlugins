<?php
$random_id = rand();
$options = $data['options'];
$sliderTitle = $options['title'];
$categoryLink = $options['category']['url'];
$categoryId = $options['category']['id'];
if (!isset($options['productIds'])) {
    return;
}
$productIds = $options['productIds'];
$itemLimit = 16;

if (wp_is_mobile()) {
    $mobile='mobile';
    $itemLimit = 10;
}else{
    $mobile = 'desktop';
}

$productCounter = 0;
$productIds = array_slice($productIds, 0, $itemLimit);
$metaCache = new \Gf\Util\MetaCache(new \GF_Cache());
$products = wc_get_products(['include' => $productIds, 'orderby' => 'include', 'numberposts' => $itemLimit]);
$stickers = new \GfPluginsCore\ProductStickers();
?>
<div id="<?php echo $random_id; ?>" class="gf-product-slider">
    <div class="gf-product-slider__header gf-product-slider__header--without-tabs">
        <h3 class="gf-product-slider__header__title"><a href="<?= $categoryLink ?>"><?= $sliderTitle ?></a></h3>
        <div class="gf-product-slider__header__controls gf-product-slider__header__controls--without-tabs">
            <a aria-label="slide to previous product" class="product-slider__control-prev gf-product-slider__header-control" href="#" role="button">
                <i class="fas fa-angle-left product-slider__control-prev-icon"></i>
            </a>
            <a aria-label="slide to next product" class="product-slider__control-next gf-product-slider__header-control" href="#" role="button">
                <i class="fas fa-angle-right product-slider__control-next-icon"></i>
            </a>
        </div>
    </div>
    <div class="swiper-container <?=$mobile; ?>">
        <div class="swiper-wrapper">
            <?php
            /** @var WC_Product $product */
            foreach ($products as $product):?>
                <div class="swiper-slide ">
                    <a href="<?= $metaCache->getMetaFor($product->get_id(), 'permalink', 'permalink', true) ?>"
                       title="<?= $product->get_name() ?>">
                        <?= $metaCache->getMetaFor($product->get_id(), 'saleSticker', 'saleSticker', true) ?>
                        <?= $metaCache->getMetaFor($product->get_id(), 'product', 'thumbnail', true) ?>
                        <h4><?= $product->get_name() ?></h4>
                        <span class="price"><?php echo $product->get_price_html(); ?></span>
                    </a>
                    <?php woocommerce_template_loop_add_to_cart($product); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>