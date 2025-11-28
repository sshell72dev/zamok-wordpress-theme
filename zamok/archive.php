<?php get_header(); ?>

<!-- page -->
<div class="page-full">

    <?php zamok01_breadcrumbs(); ?>

    <!--title-box-->
    <div class="title-box">
        <div class="title-wrap">
            <h1 class="h1-title section-title">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    the_author();
                } elseif (is_post_type_archive()) {
                    post_type_archive_title();
                } elseif (is_tax()) {
                    single_term_title();
                } else {
                    echo get_field('articles_archive_title', 'option') ?: 'Архив';
                }
                ?>
            </h1>
        </div>
        <?php if (is_category() || is_tag() || is_tax()): ?>
        <div class="info-wrap">
            <?php
            $term_description = term_description();
            if ($term_description):
            ?>
            <p><?php echo wp_kses_post($term_description); ?></p>
            <?php else: ?>
            <p><?php echo get_field('articles_archive_description', 'option') ?: 'Много интересной информации по вскрытию замков, рекомендации, как не стать жертвой проходимцев.'; ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <!--/title-box-->

    <!--tiles-box-->
    <div class="tiles-box">
        <div class="items-wrap col-4">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
            ?>
            <!--item wrap-->
            <div class="item-wrap">
                <a href="<?php the_permalink(); ?>" class="item-tile-article">
                    <div class="tile-photo-wrap">
                        <div class="elm-photo photo-cover">
                            <?php
                            $image_url = zamok01_get_post_image_url();
                            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                            ?>
                        </div>
                    </div>
                    <div class="tile-info-wrap">
                        <div class="tile-title"><?php the_title(); ?></div>
                        <div class="tile-info"><?php the_excerpt(); ?></div>
                    </div>
                </a>
            </div>
            <!--/item wrap-->
            <?php
                endwhile;
            endif;
            ?>
        </div>
        <div class="more-inner-wrap">
            <?php
            global $wp_query;
            $total_pages = $wp_query->max_num_pages;
            $current_page = max(1, get_query_var('paged'));
            
            if ($total_pages > 1):
                // Информация о страницах
                echo '<div class="pagination-info">';
                echo 'Страница ' . $current_page . ' из ' . $total_pages;
                echo '</div>';
                
                // Пагинация
                echo paginate_links(array(
                    'total' => $total_pages,
                    'current' => $current_page,
                    'prev_text' => '<span class="pagination-arrow">←</span> <span class="pagination-text">Предыдущая</span>',
                    'next_text' => '<span class="pagination-text">Следующая</span> <span class="pagination-arrow">→</span>',
                    'type' => 'list',
                    'end_size' => 2,
                    'mid_size' => 2,
                    'before_page_number' => '<span class="pagination-number">',
                    'after_page_number' => '</span>',
                ));
            endif;
            ?>
        </div>
    </div>
    <!--/tiles-box-->

</div>
<!-- /page -->

<?php get_footer(); ?>

