<div class="wrap">
    <h2 id="productStickers"><?= __('Opcije podešavanja nalepnica proizvoda') ?></h2>
    <br/>

    <?php settings_errors(); ?>

    <form method="post" action="options.php" id="theme-options-form">
        <?php
        settings_fields('gf_product_sticker_options');
        do_settings_sections('gf_product_sticker_options');
        $options = get_option('gf_product_sticker_options');


        ?>
        <div class="admin-module">

            <div class="stickerContainer">
                <h3>Novi proizvodi</h3>
                <div class="inputWrapper">
                    <div>
                        <label for="enable_stickers_select_new">Ukljuci nalepnice:</label>
                        <select name="gf_product_sticker_options[enable_stickers_select_new]">
                            <option value="0" <?php if ($options['enable_stickers_select_new'] == 0) {
                                echo 'selected';
                            } ?>>Ne
                            </option>
                            <option value="1" <?php if ($options['enable_stickers_select_new'] == 1) {
                                echo 'selected';
                            } ?>>Da
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="image_position_new">Pozicija nalepnice</label>
                        <select name="gf_product_sticker_options[image_position_new]">
                            <option value="left" <?php if ($options['image_position_new'] == 'left') {
                                echo 'selected';
                            } ?>>Levo
                            </option>
                            <option value="right" <?php if ($options['image_position_new'] == 'right') {
                                echo 'selected';
                            } ?>>Desno
                            </option>
                            <option value="center" <?php if ($options['image_position_new'] == 'center') {
                                echo 'selected';
                            } ?>>Sredina
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="new_product_time">Vreme trajanja novog proizvoda</label>
                        <input type="number" name="gf_product_sticker_options[new_product_time]" value="<?php if (strlen($options['new_product_time']) > 0)echo $options['new_product_time']?>">
                    </div>
                </div>
                <div>
                    <?php $option_new = $options['image_select_new']; ?>
                    <?php list($width_new, $height_new) = getimagesize($option_new); ?>
                    <div><img src="<?= $option_new ?>" alt="" width="<?= $width_new ?>"
                              height="<?= $height_new ?>"></div>
                    <input class="gf-upload-sticker-image-new"
                           id="upload-sticker-image-new"
                           name="image_select_new_button"
                           type="button"
                           value="Izaberite sliku">
                    <input type="hidden" class="image_select_new" name=gf_product_sticker_options[image_select_new]"
                           value="<?= $option_new ?>">
                </div>
            </div>

            <div class="stickerContainer">
                <h3>Rasprodati proizvodi</h3>
                <div class="inputWrapper inputWrapperTwo">
                    <div>
                        <label for="enable_stickers_select_soldout">Ukljuci nalepnice:</label>
                        <select name="gf_product_sticker_options[enable_stickers_select_soldout]">
                            <option value="0" <?php if ($options['enable_stickers_select_soldout'] == 0) {
                                echo 'selected';
                            } ?>>Ne
                            </option>
                            <option value="1" <?php if ($options['enable_stickers_select_soldout'] == 1) {
                                echo 'selected';
                            } ?>>Da
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="image_position_soldout">Pozicija nalepnice</label>
                        <select name="gf_product_sticker_options[image_position_soldout]">
                            <option value="left" <?php if ($options['image_position_soldout'] == 'left') {
                                echo 'selected';
                            } ?>>Levo
                            </option>
                            <option value="right" <?php if ($options['image_position_soldout'] == 'right') {
                                echo 'selected';
                            } ?>>Desno
                            </option>
                            <option value="center" <?php if ($options['image_position_soldout'] == 'center') {
                                echo 'selected';
                            } ?>>Sredina
                            </option>
                        </select>
                    </div>
                </div>
                <div>
                    <?php $options_soldout = $options['image_select_soldout'] ?>
                    <?php list($width_soldout, $height_soldout) = getimagesize($options_soldout); ?>
                    <div><img src="<?=$options_soldout ?>" alt="" width="<?= $width_soldout ?>"
                              height="<?= $height_soldout ?>"></div>
                    <input class="gf-upload-sticker-image-soldout"
                           id="upload-sticker-image-soldout"
                           name="image_select_soldout_button"
                           type="button"
                           value="Izaberite sliku">
                    <input type="hidden" class="image_select_soldout"
                           name="gf_product_sticker_options[image_select_soldout]"
                           value="<?=$options_soldout ?>">
                </div>
            </div>

            <div class="stickerContainer">
                <h3>Proizvodi na akciji</h3>
                <div class="inputWrapper inputWrapperTwo">
                    <div>
                        <label for="enable_stickers_select_sale">Ukljuci nalepnice:</label>
                        <select name="gf_product_sticker_options[enable_stickers_select_sale]">
                            <option value="0" <?php if ($options['enable_stickers_select_sale'] == 0) {
                                echo 'selected';
                            } ?>>Ne
                            </option>
                            <option value="1" <?php if ($options['enable_stickers_select_sale'] == 1) {
                                echo 'selected';
                            } ?>>Da
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="image_position_sale">Pozicija nalepnice</label>
                        <select name="gf_product_sticker_options[image_position_sale]">
                            <option value="left" <?php if ($options['image_position_sale'] == 'left') {
                                echo 'selected';
                            } ?>>Levo
                            </option>
                            <option value="right" <?php if ($options['image_position_sale'] == 'right') {
                                echo 'selected';
                            } ?>>Desno
                            </option>
                            <option value="center" <?php if ($options['image_position_sale'] == 'center') {
                                echo 'selected';
                            } ?>>Sredina
                            </option>
                        </select>
                    </div>
                </div>
                <div>
                    <?php $options_sale = $options['image_select_sale'] ?>
                    <?php list($width_sale, $height_sale) = getimagesize($options_sale); ?>
                    <div><img src="<?= $options_sale ?>" alt="" width="<?= $width_sale ?>"
                              height="<?= $height_sale ?>"></div>
                    <input class="gf-upload-sticker-image-sale"
                           id="upload-sticker-image-sale"
                           name="image_select_sale_button"
                           type="button"
                           value="Izaberite sliku">
                    <input type="hidden" class="image_select_sale" name="gf_product_sticker_options[image_select_sale]"
                           value="<?= $options_sale ?>">

                </div>
            </div>


        </div><!--admin-module-->

        <?php submit_button('', 'primary', 'sticker_submit'); ?>
    </form>


</div><!--WRAP-->