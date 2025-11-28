<?php
/**
 * FAQ Block Template
 * 
 * Использование: get_template_part('template-parts/faq-block', null, array('link_button_class' => 'button-white'));
 */

// Получаем аргументы, переданные через get_template_part
// WordPress устанавливает глобальную переменную $args при вызове get_template_part() с третьим параметром
global $args;
$link_button_class = (isset($args) && isset($args['link_button_class'])) ? $args['link_button_class'] : '';

// Получаем данные с fallback на option
$faq_title = get_field('faq_title') ?: get_field('faq_title', 'option') ?: 'Часто задаваемые вопросы';
$faq_links = get_field('faq_links') ?: get_field('faq_links', 'option');
$faq_items = get_field('faq_items') ?: get_field('faq_items', 'option');
?>

<!--tiles-faq-box-->
<div class="tiles-faq-box">
    <div class="title-inner-wrap">
        <h2 class="section-title page-title"><?php echo esc_html($faq_title); ?></h2>
        <div class="links-inner-wrap">
            <?php if ($faq_links): ?>
                <?php foreach ($faq_links as $link): ?>
                <div class="link-wrap">
                    <?php
                    // Получаем URL из нового поля ssylka_new (post_object) или fallback на старое поле link
                    $link_url = '#';
                    if (!empty($link['ssylka_new']) && is_object($link['ssylka_new'])) {
                        $link_url = get_permalink($link['ssylka_new']->ID);
                    } elseif (!empty($link['ssylka_new']) && is_numeric($link['ssylka_new'])) {
                        $link_url = get_permalink($link['ssylka_new']);
                    } elseif (!empty($link['link'])) {
                        $link_url = $link['link'];
                    }
                    ?>
                    <a href="<?php echo esc_url($link_url); ?>" class="btn <?php echo esc_attr($link_button_class); ?> <?php echo $link['style'] === 'white' ? 'button-white' : ''; ?> <?php echo $link['popup'] ? 'js-popup-open' : ''; ?>" <?php echo $link['popup'] ? 'data-popup="popup-callback"' : ''; ?>>
                        <div class="button-title"><?php echo esc_html($link['text']); ?></div>
                        <div class="button-ico">
                            <img src="<?php echo zamok01_get_image_url('icons/arrow-main.svg'); ?>" alt="">
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="items-inner-wrap">
        <div class="items-wrap">
            <?php if ($faq_items): ?>
                <?php foreach ($faq_items as $faq): ?>
                <!--item wrap-->
                <div class="item-wrap">
                    <div class="item-tile-faq">
                        <div class="tile-button js-btn-tgl">
                            <div class="tile-button-title"><?php echo esc_html($faq['question']); ?></div>
                        </div>
                        <div class="tile-content-block">
                            <?php echo wp_kses_post($faq['answer']); ?>
                        </div>
                    </div>
                </div>
                <!--/item wrap-->
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!--/tiles-faq-box-->

