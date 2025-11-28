<?php
/**
 * Template Name: Страница статей
 * 
 * Шаблон для вывода записей (posts) и рубрик
 */
get_header(); ?>

<!-- page -->
<div class="page-full">

    <?php zamok01_breadcrumbs(); ?>

    <!--title-box-->
    <div class="title-box">
        <div class="title-wrap">
            <h1 class="h1-title section-title">
                <?php 
                $page_title = get_field('articles_page_title');
                echo $page_title ? esc_html($page_title) : get_the_title();
                ?>
            </h1>
        </div>
        <div class="info-wrap">
            <p>
                <?php 
                $page_description = get_field('articles_page_description');
                echo $page_description ? esc_html($page_description) : 'Много интересной информации по вскрытию замков, рекомендации, как не стать жертвой проходимцев.';
                ?>
            </p>
        </div>
    </div>
    <!--/title-box-->

    <!--tabs-box-->
    <?php
    // Получаем все категории
    $categories = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ));
    
    if ($categories && !is_wp_error($categories)):
        // Определяем активную категорию из GET-параметра
        $current_category_slug = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
        $current_category_id = 0;
        if ($current_category_slug) {
            $category_obj = get_term_by('slug', $current_category_slug, 'category');
            if ($category_obj) {
                $current_category_id = $category_obj->term_id;
            }
        }
    ?>
    <div class="tabs-box">
        <ul class="menu">
            <?php
            // Ссылка "Все" для сброса фильтра
            $is_all_active = !$current_category_slug;
            $all_url = remove_query_arg('category', get_permalink());
            ?>
            <li>
                <a href="<?php echo esc_url($all_url); ?>" class="btn button-light js-posts-tab <?php echo $is_all_active ? 'active' : ''; ?>" 
                   data-category-id="0" data-category-slug="">
                    <button-title>Все</button-title>
                </a>
            </li>
            <?php
            foreach ($categories as $category):
                $is_active = ($current_category_id == $category->term_id);
                $category_url = add_query_arg('category', $category->slug, get_permalink());
            ?>
            <li>
                <a href="<?php echo esc_url($category_url); ?>" class="btn button-light js-posts-tab <?php echo $is_active ? 'active' : ''; ?>" 
                   data-category-id="<?php echo $category->term_id; ?>" data-category-slug="<?php echo esc_attr($category->slug); ?>">
                    <button-title><?php echo esc_html($category->name); ?></button-title>
                </a>
            </li>
            <?php
            endforeach;
            ?>
        </ul>
    </div>
    <!--/tabs-box-->
    <?php endif; ?>

    <!--tiles-box-->
    <div class="tiles-box js-posts-container">
        <div class="items-wrap col-4">
            <?php
            // Настройка запроса для постов
            // Для страниц используется 'page', для архивов - 'paged'
            $paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
            $posts_per_page = 12; // Количество постов на странице
            
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            
            // Если выбрана категория, добавляем фильтр
            if ($current_category_slug && $current_category_id) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $current_category_id,
                    ),
                );
            }
            
            $articles_query = new WP_Query($args);
            
            if ($articles_query->have_posts()):
                while ($articles_query->have_posts()):
                    $articles_query->the_post();
            ?>
            <!--item wrap-->
            <div class="item-wrap">
                <a href="<?php the_permalink(); ?>" class="item-tile-article">
                    <div class="tile-photo-wrap">
                        <div class="elm-photo photo-cover">
                            <?php echo zamok01_get_post_image(); ?>
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
            else:
            ?>
            <div class="item-wrap" style="grid-column: 1 / -1;">
                <p>Записи не найдены.</p>
            </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
        <div class="more-inner-wrap">
            <?php
            // Пагинация
            $total_pages = $articles_query->max_num_pages;
            if ($total_pages > 1):
                // Кнопка "Развернуть еще" для AJAX-подгрузки или обычная пагинация
                $next_page = $paged + 1;
                if ($next_page <= $total_pages):
                    $next_page_url = remove_query_arg('page', get_permalink());
                    $next_page_url = add_query_arg('page', $next_page, $next_page_url);
                    if ($current_category_slug) {
                        $next_page_url = add_query_arg('category', $current_category_slug, $next_page_url);
                    }
            ?>
            <a href="<?php echo esc_url($next_page_url); ?>" class="btn button-light js-posts-load-more" data-page="<?php echo $paged; ?>" data-total-pages="<?php echo $total_pages; ?>">
                <div class="button-title">Развернуть еще→</div>
            </a>
            <?php
                endif;
                
                // Альтернативно можно использовать стандартную пагинацию WordPress
                /*
                echo paginate_links(array(
                    'total' => $total_pages,
                    'current' => $paged,
                    'prev_text' => '← Предыдущая',
                    'next_text' => 'Следующая →',
                    'type' => 'list',
                ));
                */
            endif;
            ?>
        </div>
    </div>
    <!--/tiles-box-->

</div>
<!-- /page -->

<?php get_footer(); ?>

