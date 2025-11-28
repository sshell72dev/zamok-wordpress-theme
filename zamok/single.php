<?php get_header(); ?>

<!-- page -->
<div class="page-full">

    <?php zamok01_breadcrumbs(); ?>

    <!--title-box-->
    <div class="title-box">
        <div class="title-wrap">
            <h1 class="h1-title section-title"><?php the_title(); ?></h1>
        </div>
        <?php 
        $post_type = get_post_type();
        if ($post_type == 'post' && get_field('article_description')):
        ?>
        <div class="info-wrap">
            <p><?php echo get_field('article_description'); ?></p>
        </div>
        <?php elseif ($post_type == 'post'): ?>
        <div class="info-wrap">
            <p><?php echo get_the_excerpt() ?: 'Много интересной информации по вскрытию замков, рекомендации, как не стать жертвой проходимцев.'; ?></p>
        </div>
        <?php endif; ?>
    </div>
    <!--/title-box-->

    <!--content-outer-wrap-->
    <div class="content-outer-wrap">

        <!--content-wrap-->
        <div class="content-wrap">

            <!--article-box-->
            <div class="article-box">
                <div class="article-info-wrap">
                    <?php
                    // Для статей показываем категории
                    if ($post_type == 'post'):
                        $categories = get_the_terms(get_the_ID(), 'category');
                        if ($categories && !is_wp_error($categories)):
                            foreach ($categories as $category):
                    ?>
                    <a href="<?php echo get_term_link($category); ?>" class="btn button-light">
                        <div class="button-title"><?php echo esc_html($category->name); ?></div>
                    </a>
                    <?php
                            endforeach;
                        endif;
                    endif;
                    ?>
                    <div class="article-date"><?php echo get_the_date('d.m.Y'); ?></div>
                </div>
                <?php if (has_post_thumbnail()): ?>
                <div class="elm-photo">
                    <?php the_post_thumbnail('full', array('style' => 'max-width: 100%; height: auto;')); ?>
                </div>
                <?php endif; ?>
                <?php the_content(); ?>
            </div>
            <!--/article-box-->

            <!--bg-box-->
            <div class="bg-box section-inner">
                <!--action-box-->
                <div class="action-box">
                    <div class="info-inner-wrap">
                        <div class="section-title h1-title title-small-d"><?php echo get_field('action_title', 'option') ?: 'Чтобы вызвать мастера открыть машину звоните по телефону'; ?></div>
                        <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', get_field('phone_main', 'option') ?: '+7 (495) 514-53-50'); ?>" class="btn">
                            <div class="button-title"><?php echo get_field('phone_main', 'option') ?: '+7 (495) 514-53-50'; ?></div>
                        </a>
                        <div class="section-title h1-title title-small-d"><?php echo get_field('action_subtitle', 'option') ?: 'приедем через 15-20 минут'; ?></div>
                        <?php 
                        $action_image = get_field('action_image', 'option');
                        if ($action_image):
                        ?>
                        <div class="elm-photo photo-cover">
                            <img src="<?php echo esc_url($action_image['url']); ?>" alt="<?php echo esc_attr($action_image['alt']); ?>">
                        </div>
                        <?php else: ?>
                        <div class="elm-photo photo-cover">
                            <img src="<?php echo zamok01_get_image_url('photo01.png'); ?>" alt="">
                        </div>
                        <?php endif; ?>
                        <div class="elm-info"><?php echo get_field('action_info', 'option') ?: 'Все работы по вскрытию автомобиля производятся при предъявлении документов на транспортное средство'; ?></div>
                    </div>
                </div>
                <!--/action-box-->
            </div>
            <!--/bg-box-->

        </div>
        <!--/content-wrap-->

        <!--side-wrap-->
        <div class="side-wrap">
            <div class="title-inner-box">
                <div class="title-wrap">
                    <h2 class="h2-title section-title">Последние новости</h2>
                </div>
            </div>
            <!--tiles-box-->
            <div class="tiles-box">
                <div class="items-wrap">
                    <?php
                    // Показываем записи того же типа, что и текущая
                    $current_post_type = get_post_type();
                    $recent_posts = get_posts(array(
                        'post_type' => $current_post_type,
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ));
                    if ($recent_posts):
                        foreach ($recent_posts as $post_item):
                            setup_postdata($post_item);
                    ?>
                    <!--item wrap-->
                    <div class="item-wrap">
                        <a href="<?php echo get_permalink($post_item->ID); ?>" class="item-tile-article">
                            <div class="tile-photo-wrap">
                                <div class="elm-photo photo-cover">
                                    <?php
                                    $image_url = zamok01_get_post_image_url($post_item->ID);
                                    echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($post_item->ID)) . '">';
                                    ?>
                                </div>
                            </div>
                            <div class="tile-info-wrap">
                                <div class="tile-title"><?php echo get_the_title($post_item->ID); ?></div>
                                <div class="tile-info"><?php echo get_the_excerpt($post_item->ID); ?></div>
                            </div>
                        </a>
                    </div>
                    <!--/item wrap-->
                    <?php
                        endforeach;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                <?php if ($current_post_type == 'post'): ?>
                <div class="more-inner-wrap">
                    <a href="<?php echo get_permalink(get_option('page_for_posts')) ?: home_url('/'); ?>" class="btn button-light">
                        <div class="button-title">Все статьи→</div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <!--/tiles-box-->
        </div>
        <!--/side-wrap-->

    </div>
    <!--/content-outer-wrap-->

</div>
<!-- /page -->

<?php get_footer(); ?>

