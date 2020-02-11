<?php
if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
}

$args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hierarchical' => 1,
    'hide_empty' => '0'
);
$cats = get_terms('product_cat', $args);
?>

<div class="wrap">
    <?php settings_errors(); ?>
    <div class="row">
        <div class="col">
            <h1 id="categoryProductSlider">Category Product Slider</h1>
        </div>
    </div>
    <div class="form-header">
        <div>
            <label for="sliderTitle">
                <?php _e('Slider title:', 'gfShopTheme'); ?>
            </label>
            <input class="slider-name-input" type="text"
                   placeholder="<?php _e('Enter Slider Title', 'gfShopTheme'); ?>"
                   value="" name="sliderTitle">
        </div>

        <div>
            <button id="slider-add-button"
                    class="btn btn-primary"><?php _e('Add slider', 'gfShopTheme'); ?></button>
        </div>
    </div>
    <form method="post" class="container-fluid" action="options.php">
        <?php settings_fields('gf_category_product_slider_options'); ?>
        <?php do_settings_sections('gf_category_product_slider_options'); ?>
        <?php $options = get_option('gf_category_product_slider_options');?>
        <ul id="forms-container" class="list-unstyled">
            <?php
            if (isset($options['sliders']) && count($options['sliders']) > 0) {
                foreach ($options['sliders'] as $key => $value) {
                    $empty = true;
                    $data = [
                        'sliderName' => $key,
                        'sliderData' => $value,
                        'categories' => $cats
                    ];
                    \GfPluginsCore\GfShopThemePlugins::getTemplatePartials('admin', 'categoryProductSlider', 'sliderForm', $data);
                }
            } ?>
        </ul>
        <?php submit_button(); ?>
    </form>
</div>


<template id="slider-form-template">
    <li class="slider-wrapper">
        <div class="row">
            <div class="col">
                <h4 data-slider-name="" class="slider-heading"><?php _e('Slider title: ', 'gfShopTheme'); ?></h4>
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
                <select class="categorySelect" name="">
                    <?php foreach ($cats as $cat) :
                        $categoryLink = get_term_link($cat->term_id);
                        ?>
                        <option data-cat-slug="<?= $categoryLink ?>"
                                value="<?= $cat->term_id ?>"><?= $cat->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-2">
                <label for="linkInput">
                    <?php _e('Link to:', 'gfShopTheme'); ?>
                </label>
                <input class="linkInput" name="" value="">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <input type="text" placeholder="<?= __('Enter product sku') ?>">
                <button class="btn btn-primary addProduct"><?= __('Add product', 'gfShopTheme') ?></button>
            </div>
        </div>
        <h4><?= __('Products', 'gfShopTheme') ?></h4>
        <ul class="list-unstyled list-inline sortable product-list">

        </ul>
        <button class="btn btn-primary" type="submit"><?= __('Save slider', 'gfShopTheme') ?></button>
    </li>
</template>


<template id="image-template">
    <li class="list-inline-item">
        <p class="product-title"></p>
        <div class="image-preview-wrapper">
            <img class="image-preview" src="" alt="" height="100px" width="100px">
            <button class="remove-image btn btn-danger">&times</button>
        </div>
        <input class="product-id-input" type="hidden" value="">
    </li>
</template>