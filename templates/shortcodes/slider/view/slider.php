<?php
$options = get_option('gf_slider_options')['sliders'][$data['name']];
$speed = $options['slide_speed'];
$imageWidth = $options['image_width'];
$imageHeight = $options['image_height'];
$images = $options['images'];
$counter = 0;
?>

<div id="carouselExample" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($images as $image): ?>
        <?php if($image['url'] === '') {  continue; } ?>
            <li data-target="#carouselExample" data-slide-to="<?=$counter?>" class="<?php if ($counter === 0) { echo 'active'; }?>"></li>
            <?php $counter++; ?>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">
        <?php $counter = 0; ?>
        <?php foreach ($images as $key => $image): ?>
        <?php if($image['url'] === '') continue; ?>
            <div class="carousel-item <?php if ($counter === 0) { echo 'active'; }?>">
                <a href="<?= $image['linkTo'] ?>" >
                    <img class="d-block w-100" src="<?= $image['url'] ?>" alt="Nonstopshop" width="<?=$imageWidth?>" height="auto">
                </a>
            </div>
            <?php $counter++; ?>
        <?php endforeach; ?>

    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Prethodni</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Sledeći</span>
    </a>
</div>

