<?php get_header(); ?>

<!-- page -->
<div class="page-full">

    <!--title-box-->
    <div class="title-box text-center">
        <div class="title-wrap">
            <h1 class="h1-title section-title"><?php echo get_field('main_title') ?: 'Профессиональное вскрытие замков в Москве и&nbsp;Подмосковье: автомобили, квартиры, сейфы'; ?></h1>
        </div>
    </div>
    <!--/title-box-->

    <!--tiles-main-box-->
    <div class="tiles-main-box">
        <div class="items-wrap">
            <?php
            $main_services = get_field('main_services');
            if ($main_services):
                foreach ($main_services as $service):
            ?>
            <!--item wrap-->
            <div class="item-wrap">
                <div class="item-tile-main">
                    <div class="tile-content-wrap">
                        <div class="tile-phone-wrap">
                            <div class="elm-phone-number">
                                <a href="" class="btn js-btn-tgl">
                                    <div class="button-title">Показать целиком</div>
                                </a>
                                <div class="phone-number">
                                    <div class="phone-number-text"><?php echo get_field('phone_main', 'option') ?: '+7-(495) 514-53-50'; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-title-wrap">
                            <div class="tile-title h1-title title-small-d"><?php echo esc_html($service['title']); ?></div>
                        </div>
                        <?php if ($service['tags']): ?>
                        <div class="tile-tags-wrap">
                            <ul class="menu">
                                <?php foreach ($service['tags'] as $tag): 
                                    // Определяем URL: приоритет у выбранной записи, затем поле link
                                    $tag_url = '#';
                                    if (!empty($tag['vybor_zapisi'])) {
                                        // Если выбрана запись (post_object)
                                        $tag_url = get_permalink($tag['vybor_zapisi']->ID);
                                    } elseif (!empty($tag['link'])) {
                                        // Если указана прямая ссылка
                                        $tag_url = $tag['link'];
                                    }
                                ?>
                                <li class="<?php echo $tag['half_width'] ? 'li-half' : ''; ?>">
                                    <a href="<?php echo esc_url($tag_url); ?>" class="btn button-white">
                                        <div class="button-title"><?php echo esc_html($tag['text']); ?></div>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="tile-photo-wrap">
                        <div class="elm-photo photo-cover">
                            <?php if ($service['image']): ?>
                            <img src="<?php echo esc_url($service['image']['url']); ?>" alt="<?php echo esc_attr($service['image']['alt']); ?>">
                            <?php else: ?>
                            <img src="<?php echo zamok01_get_image_url('main01.jpg'); ?>" alt="<?php echo esc_html($service['title']); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--/item wrap-->
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
    <!--/tiles-main-box-->

    <!--tiles-prices-box-->
    <div class="tiles-prices-box">
        <div class="items-inner-wrap">
            <div class="items-wrap">
                <?php
                $prices = get_field('prices');
                if ($prices):
                    foreach ($prices as $price):
                ?>
                <!--item wrap-->
                <div class="item-wrap">
                    <?php
                    // Определяем URL: приоритет у выбранной записи, затем поле link
                    $price_url = '#';
                    if (!empty($price['vybrat_zapis'])) {
                        // Если выбрана запись (post_object)
                        $price_url = get_permalink($price['vybrat_zapis']->ID);
                    } elseif (!empty($price['link'])) {
                        // Если указана прямая ссылка
                        $price_url = $price['link'];
                    }
                    ?>
                    <a href="<?php echo esc_url($price_url); ?>" class="item-tile-price">
                        <div class="tile-title"><?php echo esc_html($price['title']); ?></div>
                        <div class="tile-price"><?php echo esc_html($price['price']); ?></div>
                        <div class="btn tile-button">
                            <div class="button-ico">
                                <img src="<?php echo zamok01_get_image_url('icons/arrow-button.svg'); ?>" alt="">
                            </div>
                        </div>
                    </a>
                </div>
                <!--/item wrap-->
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
    <!--/tiles-prices-box-->

    <!--info-text-box-->
    <div class="info-text-box">
        <?php echo get_field('main_info_text') ?: '<p>Забыли ключи в машине? Заклинил замок в квартире? Потеряли код от сейфа? <br>Без паники! <b class="text-att">Команда «Замок 01»</b> — это ваш надежный помощник в любой непредвиденной ситуации. Мы предлагаем профессиональные услуги по экстренному вскрытию замков любой сложности в Москве и Московской области по разумным ценам.</p>'; ?>
    </div>
    <!--/info-text-box-->

    <!--title-inner-box-->
    <div class="title-inner-box">
        <div class="title-wrap">
            <h2 class="section-title h1-title title-small-d"><?php echo get_field('advantages_title') ?: 'Почему нам доверяют?'; ?></h2>
        </div>
    </div>
    <!--/title-inner-box-->

    <!--tiles-pluses-box-->
    <div class="tiles-pluses-box">
        <div class="items-wrap">
            <?php
            $advantages = get_field('advantages');
            if ($advantages):
                $i = 1;
                foreach ($advantages as $advantage):
            ?>
            <!--item wrap-->
            <div class="item-wrap">
                <div class="item-tile-plus">
                    <div class="tile-title"><?php echo wp_kses_post($advantage['text']); ?></div>
                    <div class="tile-number"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></div>
                </div>
            </div>
            <!--/item wrap-->
            <?php
                    $i++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
    <!--/tiles-pluses-box-->

    <!--bg-box-->
    <div class="bg-box">
        <!--title-inner-box-->
        <div class="title-inner-box">
            <div class="title-wrap">
                <h2 class="section-title h1-title title-small-d"><?php echo get_field('services_title') ?: 'Наши услуги:'; ?></h2>
            </div>
        </div>
        <!--/title-inner-box-->

        <!--tiles-box-->
        <div class="tiles-box">
            <div class="slider-inner-wrap slider-tiles">
                <div class="slider-wrap swiper">
                    <div class="slider swiper-wrapper">
                        <?php
                        $services = get_posts(array(
                            'post_type' => 'service',
                            'posts_per_page' => -1,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                        ));
                        if ($services):
                            foreach ($services as $service):
                                setup_postdata($service);
                        ?>
                        <!--item wrap-->
                        <div class="sl-wrap swiper-slide">
                            <div class="item-tile-service">
                                <a href="<?php echo get_permalink($service->ID); ?>" class="tile-link"></a>
                                <div class="tile-photo-wrap">
                                    <div class="elm-photo photo-cover">
                                        <?php
                                        $image_url = zamok01_get_post_image_url($service->ID);
                                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($service->ID)) . '">';
                                        ?>
                                    </div>
                                </div>
                                <div class="tile-info-wrap">
                                    <div class="tile-title"><?php echo get_the_title($service->ID); ?>:</div>
                                    <?php echo get_field('service_description', $service->ID) ?: get_the_excerpt($service->ID); ?>
                                </div>
                                <div class="tile-phone-wrap">
                                    <div class="elm-phone-number">
                                        <a href="" class="btn js-btn-tgl">
                                            <div class="button-title">Показать целиком</div>
                                        </a>
                                        <div class="phone-number">
                                            <div class="phone-number-text"><?php echo get_field('phone_main', 'option') ?: '+7-(495) 514-53-50'; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/item wrap-->
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
                <div class="slider-actions-wrap">
                    <div class="btn-action-ico ico-arrow ico-arrow-prev button-slider button-slider-prev button-slider-tiles-prev"></div>
                    <div class="btn-action-ico ico-arrow ico-arrow-next button-slider button-slider-next button-slider-tiles-next"></div>
                </div>
            </div>
        </div>
        <!--/tiles-box-->
    </div>
    <!--/bg-box-->

    <?php get_template_part('template-parts/faq-block'); ?>

    <!--bg-box-->
    <div class="bg-box bg-light">
        <!--title-inner-box-->
        <div class="title-inner-box">
            <div class="title-wrap">
                <h2 class="section-title h1-title title-small-d"><?php echo get_field('reviews_title') ?: 'Отзывы о нашей работе'; ?></h2>
            </div>
        </div>
        <!--/title-inner-box-->

        <!--tiles-box-->
        <div class="tiles-box">
            <div class="slider-inner-wrap slider-tiles">
                <div class="slider-wrap swiper">
                    <div class="slider swiper-wrapper">
                        <?php
                        $reviews = get_posts(array(
                            'post_type' => 'review',
                            'posts_per_page' => 3,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ));
                        if ($reviews):
                            foreach ($reviews as $review):
                                setup_postdata($review);
                        ?>
                        <!--item wrap-->
                        <div class="sl-wrap swiper-slide">
                            <div class="item-tile-review">
                                <div class="tile-date"><?php echo get_the_date('d F Y г', $review->ID); ?></div>
                                <div class="tile-title"><?php echo get_the_title($review->ID); ?></div>
                                <div class="tile-info">
                                    <?php 
                                    $car_brand = get_field('car_brand', $review->ID);
                                    $opening_time = get_field('opening_time', $review->ID);
                                    if ($car_brand) echo 'Марка автомобиля: ' . esc_html($car_brand);
                                    if ($car_brand && $opening_time) echo ' <br>';
                                    if ($opening_time) echo 'Время вскрытия: ' . esc_html($opening_time);
                                    ?>
                                </div>
                                <div class="tile-text"><?php echo get_the_content($review->ID); ?></div>
                            </div>
                        </div>
                        <!--/item wrap-->
                        <?php
                            endforeach;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </div>
            <div class="more-inner-wrap">
                <a href="<?php echo get_post_type_archive_link('review'); ?>" class="btn button-white">
                    <div class="button-title">Все отзывы →</div>
                </a>
            </div>
        </div>
        <!--/tiles-box-->
    </div>
    <!--/bg-box-->

</div>
<!-- /page -->

<?php get_footer(); ?>

