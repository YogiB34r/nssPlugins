<?php
$sliderName = $data['sliderName'];
$sliderNameData = str_replace(' ','-', $sliderName);
$categoryId = $data['sliderData']['category']['id'];
$categoryLink = $data['sliderData']['category']['link'];
$products = isset($data['sliderData']['products']) ? $data['sliderData']['products'] : [];
$cats = $data['categories'];
?>
<li class="slider-wrapper" data-slider-name="<?=$sliderNameData?>">
    <div class="row">
        <div class="col">
            <h4 data-slider-name="<?=$sliderNameData?>" class="slider-heading"><?php _e('Slider title: ', 'gfShopTheme'); ?><?=$sliderName?></h4>
        </div>
        <div class="col">
            <button class="delete-slider btn btn-danger float-right"><?php _e('Delete slider', 'gfShopTheme'); ?></button>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <label for="categorySelect">
                <?php _e('Select category:', 'gfShopTheme'); ?>
            </label>
            <select class="categorySelect" name="gf_category_product_slider_options[sliders][<?=$sliderName?>][category][id]">
                <?php foreach ($cats as $cat) :
                    $categoryUrl = get_term_link($cat->term_id);
                    ?>
                    <option data-cat-slug="<?= $categoryUrl ?>"
                            value="<?= $cat->term_id ?>"<?php if ($cat->term_id == $categoryId) echo ' selected'?>>
                        <?= $cat->name ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-2">
            <label for="linkInput">
                <?php _e('Link to:', 'gfShopTheme'); ?>
            </label>
            <input class="linkInput" name="gf_category_product_slider_options[sliders][<?=$sliderName?>][category][link]" value="<?=$categoryLink?>">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" placeholder="<?= __('Enter product sku') ?>">
            <button class="btn btn-primary addProduct"><?= __('Add product', 'gfShopTheme') ?></button>
        </div>
    </div>
    <h4><?=__('Products', 'gfShopTheme')?></h4>
	<?php
	$productCountWithData = 0;
    if ( isset( $data['sliderData']['products'] ) && count( $data['sliderData']['products'] ) > 0 ) {
        foreach ($data['sliderData']['products'] as $product) {
            if (strlen($product['id']) === 0) {
                continue;
            }
            $productCountWithData++;
        }
    }
	?>
    <ul data-product-count="<?= $productCountWithData ?>"
        class="list-unstyled list-inline sortable product-list-<?= $sliderNameData?>">
		<?php
		if ( isset( $data['sliderData']['products'] ) && count( $data['sliderData']['products'] ) > 0 ) {
			$i = 0;
			foreach ( $data['sliderData']['products'] as $product ) {
				if ( strlen( $product['id'] ) === 0 ) {
					continue;
				}
				$product = wc_get_product($product['id']);
				$imageSrc = get_the_post_thumbnail_url($product->get_id());
				$title = $product->get_title();
				echo '
                <li class="list-inline-item">
                 <h5 class="product-title">'.$product->get_title().'</h5>
                    <div class="image-preview-wrapper">
                        <img class="image-preview" src="' . $imageSrc . '" alt="" height="200px" width="200px">
                        <button class="remove-image btn btn-danger">&times</button>
                    </div>
                          <input class="product-id-input" type="hidden" value="'.$product->get_id().'"
                           name="gf_category_product_slider_options[sliders]['. $sliderName.'][products]['.$i.'][id]">
                </li>';
				$i ++;
			}

		} ?>
    </ul>
    <button class="btn btn-primary" type="submit"><?= __('Save slider', 'gfShopTheme') ?></button>
</li>