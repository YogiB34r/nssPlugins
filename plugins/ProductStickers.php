<?php


namespace GfPluginsCore;


class ProductStickers
{
    /**
     * @var void
     */
    private $options;

    /**
     * ProductStickers constructor.
     */
    public function __construct()
    {
        $this->options = get_option('gf_product_sticker_options');
//        add_action('plugins_loaded', [$this, 'init']);
        $this->init();
    }

    public function init()
    {
        //New product Stickers
        add_action('woocommerce_before_shop_loop_item_title', [$this, 'addStickersToNewProducts'], 10);
        add_action('woocommerce_before_single_product_summary', [$this, 'addStickersToNewProducts'], 10);

        //Sold out product stickers
        add_action('woocommerce_before_shop_loop_item_title', [$this, 'addStickerForSoldOutProducts'], 10);
        add_action('woocommerce_before_single_product_summary', [$this, 'addStickerForSoldOutProducts'], 1);

        //Sale product stickers
        add_filter('woocommerce_sale_flash', [$this,'addStickerToSaleProducts'], 10, 3);
    }


    public static function addStickersToNewProducts($product = null, $stockStatus = null, $productId = null)
    {
        if (!is_object($product) && !$stockStatus) $product = wc_get_product(get_the_ID());
        $options = get_option('gf_product_sticker_options');

        if ($options['image_position_new'] === 'left') {
            $class = 'gf-sticker--left';
        } elseif ($options['image_position_new'] === 'center') {
            $class = 'gf-sticker--center';
        } else {
            $class = 'gf-sticker--right';
        }


        $postdatestamp = strtotime(get_the_time('Y-m-d'));
        $newness = 15;
        if ($stockStatus) {
            $sale_sticker_to = (int) get_post_meta($productId, 'sale_sticker_to', true);
            if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp && ($sale_sticker_to == 0)) {
                //// If the product was published within the newness time frame display the new badge /////
                echo '<span class="gf-sticker gf-sticker--new ' . $class . '"><img src="' . $options['image_select_new'] . '" alt="New Product Sticker" width="54" height="54"></span>';
            }
        } else {
            $sale_sticker_to = (int) get_post_meta($product->get_id(), 'sale_sticker_to', true);
            if ((time() - (60 * 60 * 24 * $newness)) < $postdatestamp && ($sale_sticker_to == 0) && static::isProductInStock($product)) {
                //// If the product was published within the newness time frame display the new badge /////
                echo '<span class="gf-sticker gf-sticker--new ' . $class . '"><img src="' . $options['image_select_new'] . '" alt="New Product Sticker" width="54" height="54"></span>';
            }
        }
    }

    public static function addStickerForSoldOutProducts($classes = null, $stockStatus = null)
    {
        if (isset($stockStatus) && $stockStatus === 1) {
            return '';
        }
        $options = get_option('gf_product_sticker_options');

        if ($options['image_position_soldout'] === 'right') {
            $class = 'gf-sticker--right';
        } elseif ($options['image_position_soldout'] === 'left') {
            $class = 'gf-sticker--left';
        } else {
            $class = 'gf-sticker--center';
        }
        if (!is_product()) {
            $class .= " gf-sticker--loop-grid ";
        }
        $html = '<span id="'.$options['image_position_soldout'].'" class="gf-sticker gf-sticker--soldout ' . $class . ' "><img src="' . $options['image_select_soldout'] . '" alt="" width="200" height="47"></span>';
        
        if (isset($stockStatus) && $stockStatus === 0) {
            return $html;
        // stockStatus not available, go with db data
        } else {
            // single page, safe to use heavy queries
            if (is_product()) {
                $product = wc_get_product(get_the_ID());
                if (!static::isProductInStock($product)) {
                    echo $html;
                }
                return '';
            } else {
                var_dump(is_product());
            }

            throw new \Exception('deprecated usage.');
        }
    }

    public static function addStickerToSaleProducts($classes, $id)
    {
//        if ($this->options['image_position_sale_option'] === 'right') {
//            $class = 'gf-sticker--right';
//        } elseif ($this->options['image_position_sale_option'] === 'center') {
//            $class = 'gf-sticker--center';
//        } else {
//            $class = 'gf-sticker--left';
//        }
//        if (!$classes || strstr($classes, 'span')) {
//            ob_start();
//            wc_product_class();
//            $classes = ob_get_clean();
//        }
//        $sale_sticker_active = get_post_meta($id, 'sale_sticker_active', true);
//        $sale_sticker_to = get_post_meta($id, 'sale_sticker_to', true);
//
//        if ($sale_sticker_active === 'yes' && $sale_sticker_to > time()) {
////        if (strstr($classes, 'sale') && !strstr($classes, 'outofstock')) {
//            if (!strstr($classes, 'outofstock')) {
//                return '<span class="gf-sticker gf-sticker--sale ' . $class . '"><img src="' . $this->options['image_select_sale'] . '" alt="" height="64" width="64"></span>';
//            }
//        }
        return '';
    }

    public static function isProductInStock(\WC_Product $product)
    {
        if (get_class($product) === \WC_Product_Variable::class) {
            foreach ($product->get_available_variations() as $variation) {
                if ($variation['is_in_stock']) {
                    return true;
                }
            }
        } else if ($product->is_in_stock()) {
            return true;
        }

        return false;
    }
}