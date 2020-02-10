<li class="slider-wrapper">
    <div class="row">
        <div class="col">
            <h4 data-slider-name="<?= $data['sliderName'] ?>"
                class="slider-heading"><?php _e( 'Slider name: ', 'gfShopTheme' ); ?><?= $data['sliderName'] ?></h4>
        </div>
        <div class="col">
            <h4><?php _e('Shortcode:  [gf_slider name="'.$data['sliderName'].'"]','gfShopTheme')?></h4>
        </div>
        <div class="col">
            <button class="delete-slider btn btn-danger float-right"><?php _e( 'Delete slider', 'gfShopTheme' ); ?></button>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-1">
            <label for="image_width"><?php _e( 'Images Width', 'gfShopTheme' ); ?></label>
            <input type="text" name="gf_slider_options[sliders][<?= $data['sliderName'] ?>][image_width]"
                   class="form-control images-width-input"
                   value="<?= $data['sliderData']['image_width'] ?>"/>
        </div>
        <div class="form-group col-md-1">
            <label for="image_height"><?php _e( 'Images Height', 'gfShopTheme' ); ?></label>
            <input type="text" name="gf_slider_options[sliders][<?= $data['sliderName'] ?>][image_height]"
                   class="form-control images-height-input"
                   value="<?= $data['sliderData']['image_height'] ?>"/>
        </div>
        <div class="form-group col-md-1">
            <label for="slide_speed"><?php _e( 'Slider Speed', 'gfShopTheme' ); ?></label>
            <input type="text" name="gf_slider_options[sliders][<?= $data['sliderName'] ?>][slide_speed]"
                   class="form-control images-slide-speed-input"
                   value="<?= $data['sliderData']['slide_speed'] ?>"/>
        </div>
    </div>
    <h4>Images</h4>
	<?php
	$imageCountWithData = 0;
	foreach ( $data['sliderData']['images'] as $image ) {
		if ( strlen( $image['url'] ) === 0 ) {
			continue;
		}
		$imageCountWithData ++;
	}
	?>
    <ul data-image-count="<?= $imageCountWithData ?>"
        class="list-unstyled list-inline sortable images-list-<?= $data['sliderName'] ?>">
		<?php
		if ( isset( $data['sliderData']['images'] ) && count( $data['sliderData']['images'] ) > 0 ) {
			$i = 0;
			foreach ( $data['sliderData']['images'] as $image ) {
				if ( strlen( $image['url'] ) === 0 ) {
					continue;
				}
				echo '
                <li class="list-inline-item">
                    <div class="image-preview-wrapper">
                        <img class="image-preview" src="' . $image['url'] . '" alt="" height="200px" width="200px">
                        <button class="remove-image btn btn-danger">&times</button>
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="gf_slider_options[sliders][' . $data['sliderName'] . '][images][' . $i . '][url]" class="image-url-input"
                          value="' . $image['url'] . '"/>
                        <input type="text" name="gf_slider_options[sliders][' . $data['sliderName'] . '][images][' . $i . '][linkTo]" class="image-custom-link-input" value="' . $image['linkTo'] . '"
                               placeholder=" ' . __( 'Enter custom link for image', 'gfShopTheme' ) . '"/>
                    </div>               
                </li>';
				$i ++;
			}

		} ?>
    </ul>
    <button class="btn btn-primary upload-images"
    ><?php _e( 'Select images', 'gfShopTheme' ); ?></button>
    <button class="btn btn-primary" type="submit"><?= __('Save slider', 'gfShopTheme') ?></button>
</li>