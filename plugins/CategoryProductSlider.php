<?php
namespace GfPluginsCore;

use GF_Cache;

class CategoryProductSlider extends \WP_Widget
{
    /**
     * @var GF_Cache
     */
    private $cache;

    /**
     * CategoryProductSlider constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'gf_product_slider_without_tabs_widget', // Base ID
            esc_html__('Category Product Slider', 'gf_widgets_domain'),
            array('description' => esc_html__('Product Slider Without Tabs', 'gf_widgets_domain'))
        );
        $this->cache = new GF_Cache();
    }

    /**
     * Front-end display of widget.
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     * @see WP_Widget::widget()
     *
     */
    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        if (isset($instance['sliderSelect']) and !empty($instance['sliderSelect'])) {
            echo $this->generateBoxHtml($instance);
        }

        if (isset($args['after_widget'])) {
            echo $args['after_widget'];
        }
    }

    private function generateBoxHtml($instance)
    {
        $key = 'product-slider#' . md5(serialize($instance));
        $html = $this->cache->redis->get($key);
//        $html = false;
        if ($html === false) {
            $slider = getSlider($instance['sliderSelect'])[0];
            $options = [
                'category' => ['url' => $slider->url, 'id' => $slider->categoryId],
                'productIds' => unserialize($slider->items),
                'title' => $slider->title
            ];
            ob_start();
            GfShopThemePlugins::getTemplatePartials('view', 'categoryProductSlider', 'categoryProductSlider',
                ['sliderTitle' => $instance['sliderSelect'], 'options' => $options]);
            $html = ob_get_clean();

            $this->cache->redis->set($key, $html, 60);
        }

        return $html;
    }

    /**
     * Back-end widget form.
     *
     * @param array $instance Previously saved values from database.
     * @see WP_Widget::form()
     *
     */
    public function form($instance)
    {
        $sliders = getSliders();
        ?>
        <label for="<?php echo esc_attr($this->get_field_id('sliderSelect')); ?>">
            <?php _e('Select slider:', 'gfShopPlugins'); ?>
        </label>
        <select class="widefat" id="<?php echo esc_attr($this->get_field_id('sliderSelect')); ?>"
                name="<?php echo esc_attr($this->get_field_name('sliderSelect')); ?>">
            <?php foreach ($sliders as $slider) : ?>
                <option  value="<?=$slider->slideId?>"
                    <?php if (isset($instance['sliderSelect']) && $slider->slideId == $instance['sliderSelect']) {
                            echo 'selected';
                    } ?>><?=$slider->title?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }
}