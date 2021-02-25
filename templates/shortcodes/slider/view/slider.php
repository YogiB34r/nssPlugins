<?php
$options = get_option('gf_slider_options')['sliders'][$data['name']];

$speed = $options['slide_speed'];

$handle = 'nss-desktop-js';
if(wp_is_mobile()){
    $handle = 'nss-mobile-js';
}
wp_localize_script( $handle, 'banner_speed', array( 'speed' => $speed));

$imageWidth = $options['image_width'];
$imageHeight = $options['image_height'];
$images = $options['images'];
$counter = 0;
$cache = new GF_Cache();
// md5 will take care of refreshing cache upon change in ANY of the options :P
$cacheKey = 'image-slider#' . md5(serialize($options));
$html = $cache->redis->get($cacheKey);
if ($html === false) {
    ob_start();
    ?>
    <div class="center">
        <div class="images">
            <?php foreach ($images as $image): ?>
                <?php if ($image['url'] === '') {
                    continue;
                } ?>
                <div class="slideImg">
                    <a href="<?= $image['linkTo'] ?>">
                        <img src="<?= $image['url']; ?>" alt="Nonstopshop" width="<?= $imageWidth ?>" height="<?= $imageHeight ?> ">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="buttons">
            <?php foreach ($images as $image): ?>
                <?php if ($image['url'] === '') {
                    continue;
                } ?>
                <div id="btn-<?= $counter; ?>" class="sliderButton <?= $counter === 0 ? 'active' : ''; ?>"></div>
                <?php
                $counter++;
            endforeach; ?>
        </div>
        <div class="buttonPrevious"><i class="fas fa-chevron-left"></i><span class="sr-only">Prethodni</span></div>
        <div class="buttonNext"><i class="fas fa-chevron-right"></i><span class="sr-only">Naredni</span></div>
    </div>
    <?php
    $html = ob_get_clean();
    $cache->redis->set($cacheKey, $html);
}
echo $html;