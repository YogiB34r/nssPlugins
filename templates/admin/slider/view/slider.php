<?php
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>
<div class="wrap">
	<?php settings_errors(); ?>
    <div class="row">
        <div class="col">
            <h1 id="productSlider">Gf sliders</h1>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="input-group">
                    <input class="slider-name-input" type="text"
                           placeholder="<?php _e( 'Enter Slider Name', 'gfShopTheme' ); ?>"
                           value="">
                    <button id="slider-add-button"
                            class="btn btn-primary d-inline"><?php _e( 'Add slider', 'gfShopTheme' ); ?></button>
                </div>
            </div>
        </div>
    </div>
    <form method="post" class="container-fluid" action="options.php">
		<?php settings_fields( 'gf_slider_options' ); ?>
		<?php do_settings_sections( 'gf_slider_options' ); ?>
		<?php $options = get_option( 'gf_slider_options' );?>
        <ul id="forms-container" class="list-unstyled">
			<?php
			if ( isset( $options['sliders'] ) && count( $options['sliders'] ) > 0 ) {
				$formsCount = count( $options['sliders'] );
				foreach ( $options['sliders'] as $key => $value ) {
				    $empty = true;
					$data = [
						'sliderName' => $key,
                        'sliderData' => $value,
					];
					foreach ($data['sliderData']['images'] as $image){
					   if (strlen($image['url']) > 0) {
					       $empty = false;
                       }
                    }
					if ($empty){
					    continue;
                    }
					$formsCount++;
					\GfPluginsCore\GfShopThemePlugins::getTemplatePartials( 'admin', 'slider', 'sliderForm', $data );
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
                <h4 data-slider-name ="" class="slider-heading"><?php _e( 'Slider name: ', 'gfShopTheme' ); ?></h4>
            </div>
            <div class="col">
                <button class="delete-slider btn btn-danger float-right"><?php _e( 'Delete slider', 'gfShopTheme' ); ?></button>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-1">
                <label for="image_width"><?php _e( 'Images Width', 'gfShopTheme' ); ?></label>
                <input type="text" name=""
                       class="form-control images-width-input"
                       value=""/>
            </div>
            <div class="form-group col-md-1">
                <label for="image_height"><?php _e( 'Images Height', 'gfShopTheme' ); ?></label>
                <input type="text" name=""
                       class="form-control images-height-input"
                       value=""/>
            </div>
            <div class="form-group col-md-1">
                <label for="slide_speed"><?php _e( 'Slider Speed', 'gfShopTheme' ); ?></label>
                <input type="text" name=""
                       class="form-control images-slide-speed-input"
                       value=""/>
            </div>
        </div>
        <h4>Images</h4>
        <ul class="list-unstyled list-inline sortable images-list">

        </ul>
        <button class="btn btn-primary upload-images"
        ><?php _e( 'Select images', 'gfShopTheme' ); ?></button>
        <button class="btn btn-primary" type="submit"><?= __('Save slider', 'gfShopTheme') ?></button>
    </li>
</template>
<template id="image-template">
    <li class="list-inline-item">
        <div class="image-preview-wrapper">
            <img class="image-preview" src="" alt="" height="200px" width="200px">
            <button class="remove-image btn btn-danger">&times</button>
        </div>
        <div class="form-group">
            <input type="hidden" name="" class="image-url-input"
                   value=""/>
            <input type="text" name="" class="image-custom-link-input" value=""
                   placeholder=" <?=__( 'Enter custom link for image', 'gfShopTheme' )?>"/>
        </div>
    </li>
</template>