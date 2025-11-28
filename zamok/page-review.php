<?php
/**
 * Template Name: Отзывы
 */
get_header(); ?>

<!-- page -->
<div class="page-full">

    <?php zamok01_breadcrumbs(); ?>

    <?php if (isset($_GET['review_submitted']) && $_GET['review_submitted'] == '1'): ?>
    <div class="notice notice-success" style="padding: 15px; margin: 20px 0; background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px; text-align: center;">
        <strong>Спасибо!</strong> Ваш отзыв успешно отправлен и будет опубликован после модерации.
    </div>
    <?php endif; ?>

    <!--title-box-->
    <div class="title-box">
        <div class="title-wrap">
            <h1 class="h1-title section-title"><?php echo get_field('reviews_archive_title', 'option') ?: get_the_title() ?: 'Отзывы о работе Службы Zamok01 по вскрытию замков'; ?></h1>
        </div>
        <div class="info-wrap">
            <p><?php echo get_field('reviews_archive_description', 'option') ?: 'Если Вы пользовались нашими услугами, наши мастера Вам вскрывали автомобиль или дверь, оставьте отзыв о нашей работе.'; ?></p>
        </div>
        <div class="action-wrap">
            <a href="#review-form" class="btn">
                <div class="button-title">Напишите свой отзыв</div>
                <div class="button-ico">
                    <img src="<?php echo zamok01_get_image_url('icons/arrow-main.svg'); ?>" alt="">
                </div>
            </a>
        </div>
    </div>
    <!--/title-box-->

    <!--tiles-box-->
    <div class="tiles-box">
        <div class="items-wrap">
            <?php
            $reviews_query = new WP_Query(array(
                'post_type' => 'review',
                'posts_per_page' => 9,
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish',
            ));

            if ($reviews_query->have_posts()):
                while ($reviews_query->have_posts()):
                    $reviews_query->the_post();
            ?>
            <!--item wrap-->
            <div class="item-wrap">
                <div class="item-tile-review">
                    <div class="tile-date"><?php echo get_the_date('d F Y г'); ?></div>
                    <div class="tile-title"><?php the_title(); ?></div>
                    <div class="tile-info">
                        <?php 
                        $car_brand = get_field('car_brand');
                        $opening_time = get_field('opening_time');
                        if ($car_brand) echo 'Марка автомобиля: ' . esc_html($car_brand);
                        if ($car_brand && $opening_time) echo ' <br>';
                        if ($opening_time) echo 'Время вскрытия: ' . esc_html($opening_time);
                        ?>
                    </div>
                    <div class="tile-text"><?php the_content(); ?></div>
                    <?php if (has_post_thumbnail()): ?>
                    <div class="tile-photo">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!--/item wrap-->
            <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
        <div class="more-inner-wrap">
            <?php
            if ($reviews_query->max_num_pages > 1):
            ?>
            <a href="" class="btn button-light js-reviews-load-more" data-page="1" data-total-pages="<?php echo $reviews_query->max_num_pages; ?>">
                <div class="button-title">Показать еще</div>
            </a>
            <?php
            endif;
            ?>
        </div>
    </div>
    <!--/tiles-box-->

    <!--bg-box-->
    <div class="bg-box" id="review-form">
        <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" enctype="multipart/form-data" class="form-box">
            <input type="hidden" name="action" value="submit_review">
            <?php wp_nonce_field('submit_review', 'review_nonce'); ?>
            <div class="frm-title-wrap">
                <div class="frm-title h1-title">Напишите отзыв</div>
            </div>
            <div class="frm-content-wrap">
                <div class="frm-row">
                    <div class="frm-field field-half">
                        <input type="text" class="form-input" name="review_name" placeholder="Ваше имя" required>
                    </div>
                    <div class="frm-field field-half">
                        <input type="email" class="form-input" name="review_email" placeholder="E-mail" required>
                    </div>
                </div>
                <div class="frm-row">
                    <div class="frm-field field-half">
                        <select class="form-input" name="review_car_brand" required>
                            <option selected disabled hidden value="">Вид работы</option>
                            <option value="автомобиль">Автомобиль</option>
                            <option value="сейф">Сейф</option>
                            <option value="дверь">Дверь</option>
                        </select>
                    </div>
                    <div class="frm-field field-half">
                        <select class="form-input" name="review_opening_time" required>
                            <option selected disabled hidden value="">Сколько ушло времени</option>
                            <?php
                            $opening_times = get_field('opening_times', 'option');
                            if ($opening_times):
                                foreach ($opening_times as $time):
                            ?>
                            <option value="<?php echo esc_attr($time['value']); ?>"><?php echo esc_html($time['label']); ?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="frm-row">
                    <div class="frm-field">
                        <textarea class="form-input" name="review_text" placeholder="Текст отзыва" required></textarea>
                    </div>
                </div>
                <div class="frm-row">
                    <div class="frm-field-file js-field-file">
                        <input type="file" class="js-field-input" name="review_photo" accept="image/*">
                        <button type="button" class="btn button-light button-file-attach js-file-button-attach">
                            <span class="button-title">Прикрепите фотографию</span>
                        </button>
                        <div class="file-inner-wrap">
                            <div class="file-name"></div>
                            <a href="" class="btn-action-ico ico-trash button-file-del js-file-button-del"></a>
                        </div>
                    </div>
                </div>
                <div class="frm-row-submit">
                    <div class="frm-field field-info">
                        <div class="frm-select">
                            <input type="checkbox" id="review-form" name="review_consent" required>
                            <label for="review-form">Даю согласие на обработку <a href="<?php echo get_field('privacy_policy_link', 'option') ?: '#'; ?>" class="link-main">персональных данных</a></label>
                        </div>
                    </div>
                    <div class="frm-field field-submit">
                        <button type="submit" class="btn">
                            <div class="button-title">Отправить</div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/bg-box-->

    <?php get_template_part('template-parts/faq-block', null, array('link_button_class' => 'button-white')); ?>

</div>
<!-- /page -->

<?php get_footer(); ?>

