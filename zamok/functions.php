<?php
/**
 * Zamok01 Theme Functions
 */

// Подключение стилей и скриптов
function zamok01_enqueue_scripts() {
    // Стили
    wp_enqueue_style('reset', get_template_directory_uri() . '/css/reset.css', array(), '1.0');
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/fancybox.css', array(), '1.0');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/css/swiper-bundle.min.css', array(), '1.0');
    wp_enqueue_style('main', get_template_directory_uri() . '/css/style.min.css', array('reset', 'fancybox', 'swiper'), '1.0');
    wp_enqueue_style('zamok01-style', get_template_directory_uri() . '/style.css', array('main'), '1.0');
    
    // Скрипты
    wp_enqueue_script('swiper', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), '1.0', true);
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/fancybox.umd.js', array(), '1.0', true);
    wp_enqueue_script('main', get_template_directory_uri() . '/js/scripts.js', array('swiper', 'fancybox'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'zamok01_enqueue_scripts');

// Поддержка миниатюр
add_theme_support('post-thumbnails');

// Регистрация кастомных размеров изображений
add_image_size('quality_blog_img', 730, 280, true); // Обрезка для соответствия размеру

// Кастомный Walker для меню
class Zamok01_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Начало элемента списка
    function start_lvl(&$output, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);
        $output .= "{$n}{$indent}<ul class=\"sub-menu\">{$n}";
    }

    // Конец элемента списка
    function end_lvl(&$output, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat($t, $depth);
        $output .= "{$indent}</ul>{$n}";
    }

    // Начало элемента меню
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        // Упрощенная структура без лишних классов для соответствия верстке
        $output .= $indent . '<li>';

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        $item_output = '<a class="btn-menu"' . $attributes .'>';
        $item_output .= '<div class="button-title">';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '</div>';
        $item_output .= '</a>';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // Конец элемента меню
    function end_el(&$output, $item, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
    }
}

// Регистрация меню
function zamok01_register_menus() {
    register_nav_menus(array(
        'main-menu' => 'Главное меню',
        'footer-services' => 'Услуги в футере',
        'footer-info' => 'Информация в футере',
    ));
}
add_action('init', 'zamok01_register_menus');

// Регистрация типов записей
function zamok01_register_post_types() {
    // Тип записи: Услуги
    register_post_type('service', array(
        'labels' => array(
            'name' => 'Услуги',
            'singular_name' => 'Услуга',
            'add_new' => 'Добавить услугу',
            'add_new_item' => 'Добавить новую услугу',
            'edit_item' => 'Редактировать услугу',
            'new_item' => 'Новая услуга',
            'view_item' => 'Просмотреть услугу',
            'search_items' => 'Искать услуги',
            'not_found' => 'Услуги не найдены',
            'not_found_in_trash' => 'В корзине услуг не найдено',
        ),
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array(
            'slug' => '',
            'with_front' => false,
            'feeds' => false,
            'pages' => true,
        ),
    ));
    
    // Тип записи: Отзывы
    register_post_type('review', array(
        'labels' => array(
            'name' => 'Отзывы',
            'singular_name' => 'Отзыв',
            'add_new' => 'Добавить отзыв',
            'add_new_item' => 'Добавить новый отзыв',
            'edit_item' => 'Редактировать отзыв',
            'new_item' => 'Новый отзыв',
            'view_item' => 'Просмотреть отзыв',
            'search_items' => 'Искать отзывы',
            'not_found' => 'Отзывы не найдены',
            'not_found_in_trash' => 'В корзине отзывов не найдено',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'otzyvy'),
    ));
    
}
add_action('init', 'zamok01_register_post_types');

// Фильтр для изменения URL услуг - убираем префикс /uslugi/
function zamok01_service_post_link($post_link, $post) {
    if ($post->post_type == 'service') {
        $post_link = home_url('/' . $post->post_name . '/');
    }
    return $post_link;
}
add_filter('post_type_link', 'zamok01_service_post_link', 10, 2);

// Обработка запросов для услуг без префикса /uslugi/
function zamok01_parse_service_request($query_vars) {
    // Если это не главная страница и не страница, проверяем, не является ли это услугой
    if (!is_admin() && !isset($query_vars['post_type']) && !isset($query_vars['pagename']) && !isset($query_vars['page_id'])) {
        global $wp;
        $requested_slug = trim($wp->request, '/');
        
        if (!empty($requested_slug)) {
            // Проверяем, существует ли услуга с таким slug
            $service = get_page_by_path($requested_slug, OBJECT, 'service');
            if ($service) {
                $query_vars['post_type'] = 'service';
                $query_vars['name'] = $requested_slug;
            }
        }
    }
    return $query_vars;
}
add_filter('request', 'zamok01_parse_service_request');

// Добавляем метабокс для редактирования постоянной ссылки услуг
function zamok01_add_permalink_meta_box() {
    add_meta_box(
        'service_permalink',
        'Постоянная ссылка',
        'zamok01_permalink_meta_box_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'zamok01_add_permalink_meta_box');

// Callback для метабокса постоянной ссылки
function zamok01_permalink_meta_box_callback($post) {
    $permalink = get_permalink($post->ID);
    $slug = $post->post_name;
    $home_url = home_url('/');
    ?>
    <div class="inside">
        <div id="edit-slug-box" class="hide-if-no-js">
            <strong>Постоянная ссылка:</strong>
            <span id="sample-permalink">
                <a href="<?php echo esc_url($permalink); ?>" target="_blank">
                    <?php echo esc_html($home_url . $slug . '/'); ?>
                </a>
            </span>
            <span id="edit-slug-buttons">
                <button type="button" class="edit-slug button button-small hide-if-no-js" aria-label="Редактировать постоянную ссылку">
                    Редактировать
                </button>
            </span>
            <div id="edit-slug-box-inner" style="display: none; margin-top: 10px;">
                <label for="new-post-slug">Slug:</label>
                <input type="text" id="new-post-slug" name="new-post-slug" value="<?php echo esc_attr($slug); ?>" style="width: 100%; max-width: 400px; margin: 5px 0;" />
                <button type="button" class="save-slug button button-small">OK</button>
                <button type="button" class="cancel-slug button button-small">Отмена</button>
            </div>
        </div>
        <p class="description">
            Вы можете редактировать постоянную ссылку, изменив поле "Slug" выше. 
            После сохранения записи ссылка будет обновлена.
        </p>
        <input type="hidden" id="post_name_hidden" name="post_name" value="<?php echo esc_attr($slug); ?>" />
    </div>
    <script>
    jQuery(document).ready(function($) {
        var $editButton = $('.edit-slug');
        var $slugBox = $('#edit-slug-box-inner');
        var $samplePermalink = $('#sample-permalink');
        var $newSlugInput = $('#new-post-slug');
        var $postNameInput = $('#post_name_hidden');
        var homeUrl = '<?php echo esc_js($home_url); ?>';
        var originalSlug = '<?php echo esc_js($slug); ?>';
        
        // Обработчик кнопки редактирования
        $editButton.on('click', function() {
            if ($slugBox.is(':visible')) {
                // Закрываем редактор
                $slugBox.hide();
                $samplePermalink.show();
                $newSlugInput.val($postNameInput.val());
            } else {
                // Открываем редактор
                $slugBox.show();
                $samplePermalink.hide();
                $newSlugInput.focus().select();
            }
        });
        
        // Сохранение slug
        $('.save-slug').on('click', function() {
            var newSlug = $newSlugInput.val().trim();
            if (newSlug) {
                // Очищаем slug от спецсимволов
                newSlug = newSlug.toLowerCase().replace(/[^a-z0-9-]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
                if (newSlug) {
                    // Обновляем оба поля для надежности
                    $postNameInput.val(newSlug);
                    $newSlugInput.val(newSlug);
                    // Также обновляем скрытое поле, которое WordPress использует
                    if ($('#post_name').length) {
                        $('#post_name').val(newSlug);
                    } else {
                        // Создаем скрытое поле, если его нет
                        $('<input>').attr({
                            type: 'hidden',
                            id: 'post_name',
                            name: 'post_name',
                            value: newSlug
                        }).appendTo('form#post');
                    }
                    $samplePermalink.find('a').attr('href', homeUrl + newSlug + '/');
                    $samplePermalink.find('a').text(homeUrl + newSlug + '/');
                    $slugBox.hide();
                    $samplePermalink.show();
                } else {
                    alert('Slug не может быть пустым');
                }
            }
        });
        
        // Отмена редактирования
        $('.cancel-slug').on('click', function() {
            $newSlugInput.val($postNameInput.val());
            $slugBox.hide();
            $samplePermalink.show();
        });
        
        // Автоматическое обновление slug при вводе
        $newSlugInput.on('input', function() {
            var val = $(this).val();
            // Можно добавить live preview здесь
        });
    });
    </script>
    <style>
    #service_permalink .inside {
        padding: 12px;
    }
    #edit-slug-box {
        margin: 10px 0;
    }
    #edit-slug-box-inner {
        padding: 10px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    #edit-slug-box-inner label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }
    #new-post-slug {
        padding: 5px;
    }
    </style>
    <?php
}

// Сохранение измененного slug
function zamok01_save_service_slug($post_id) {
    // Проверки безопасности
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (get_post_type($post_id) !== 'service') {
        return;
    }
    
    // Проверяем nonce (если нужно)
    if (isset($_POST['_wpnonce']) && !wp_verify_nonce($_POST['_wpnonce'], 'update-post_' . $post_id)) {
        return;
    }
    
    $slug_changed = false;
    
    // Используем поле post_name из формы или new-post-slug
    $new_slug = '';
    if (isset($_POST['post_name']) && !empty($_POST['post_name'])) {
        $new_slug = sanitize_title($_POST['post_name']);
    } elseif (isset($_POST['new-post-slug']) && !empty($_POST['new-post-slug'])) {
        $new_slug = sanitize_title($_POST['new-post-slug']);
    }
    
    if (!empty($new_slug)) {
        $current_slug = get_post_field('post_name', $post_id);
        
        if ($new_slug !== $current_slug) {
            // Проверяем, не занят ли slug другим постом
            $existing = get_page_by_path($new_slug, OBJECT, 'service');
            if (!$existing || $existing->ID == $post_id) {
                // Также проверяем страницы, чтобы избежать конфликтов
                $existing_page = get_page_by_path($new_slug, OBJECT, 'page');
                if (!$existing_page) {
                    wp_update_post(array(
                        'ID' => $post_id,
                        'post_name' => $new_slug
                    ));
                    $slug_changed = true;
                }
            }
        }
    }
    
    // Если slug изменился, сбрасываем правила rewrite
    if ($slug_changed) {
        // Используем транзиент для отложенного сброса правил
        set_transient('zamok01_flush_rewrite_rules', true, 60);
    }
}

// Фильтр для обработки slug перед сохранением
function zamok01_pre_save_service_slug($data, $postarr) {
    if (isset($data['post_type']) && $data['post_type'] === 'service') {
        // Если передан новый slug через форму
        if (isset($_POST['new-post-slug']) && !empty($_POST['new-post-slug'])) {
            $new_slug = sanitize_title($_POST['new-post-slug']);
            if (!empty($new_slug)) {
                // Проверяем, не занят ли slug
                $existing = get_page_by_path($new_slug, OBJECT, 'service');
                if (!$existing || (isset($postarr['ID']) && $existing->ID == $postarr['ID'])) {
                    $existing_page = get_page_by_path($new_slug, OBJECT, 'page');
                    if (!$existing_page) {
                        $data['post_name'] = $new_slug;
                    }
                }
            }
        } elseif (isset($_POST['post_name']) && !empty($_POST['post_name'])) {
            $new_slug = sanitize_title($_POST['post_name']);
            if (!empty($new_slug)) {
                $data['post_name'] = $new_slug;
            }
        }
    }
    return $data;
}
add_filter('wp_insert_post_data', 'zamok01_pre_save_service_slug', 10, 2);

// Отложенный сброс правил rewrite
function zamok01_maybe_flush_rewrite_rules() {
    if (get_transient('zamok01_flush_rewrite_rules')) {
        flush_rewrite_rules(false);
        delete_transient('zamok01_flush_rewrite_rules');
    }
}
add_action('save_post', 'zamok01_save_service_slug');
add_action('admin_init', 'zamok01_maybe_flush_rewrite_rules');

// Сброс правил rewrite при активации темы
function zamok01_flush_rewrite_rules() {
    zamok01_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'zamok01_flush_rewrite_rules');

// Улучшенная обработка rewrite правил для услуг
function zamok01_service_rewrite_rules($rules) {
    global $wp_rewrite;
    
    // Получаем все услуги
    $services = get_posts(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));
    
    // Добавляем правила для каждой услуги без префикса
    foreach ($services as $service) {
        $slug = $service->post_name;
        if (!empty($slug)) {
            $rules[$slug . '/?$'] = 'index.php?post_type=service&name=' . $slug;
        }
    }
    
    return $rules;
}
add_filter('rewrite_rules_array', 'zamok01_service_rewrite_rules');

// Функция для получения пути к изображению
function zamok01_get_image_url($path) {
    return get_template_directory_uri() . '/img/' . $path;
}

// Функция для хлебных крошек
function zamok01_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    echo '<div class="breadcrumbs-box"><ol class="menu">';
    echo '<li><a href="' . home_url() . '" class="btn button-light">Главная</a></li>';
    
    if (is_page()) {
        echo '<li><a href="" class="btn button-light">' . get_the_title() . '</a></li>';
    } elseif (is_single()) {
        $post_type = get_post_type();
        if ($post_type == 'post') {
            $posts_page = get_permalink(get_option('page_for_posts')) ?: home_url('/');
            echo '<li><a href="' . esc_url($posts_page) . '" class="btn button-light">Статьи</a></li>';
        }
        echo '<li><a href="" class="btn button-light">' . get_the_title() . '</a></li>';
    } elseif (is_single() && get_post_type() == 'service') {
        echo '<li><a href="" class="btn button-light">' . get_the_title() . '</a></li>';
    } elseif (is_home() || is_category()) {
        echo '<li><a href="" class="btn button-light">Статьи</a></li>';
    } elseif (is_post_type_archive('review')) {
        echo '<li><a href="" class="btn button-light">Отзывы</a></li>';
    } elseif (is_post_type_archive('service')) {
        echo '<li><a href="" class="btn button-light">Услуги</a></li>';
    }
    
    echo '</ol></div>';
}

// Поддержка ACF JSON
add_filter('acf/settings/save_json', 'zamok01_acf_json_save_point');
function zamok01_acf_json_save_point($path) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'zamok01_acf_json_load_point');
function zamok01_acf_json_load_point($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

// Добавление страницы опций ACF
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Настройки сайта',
        'menu_title' => 'Настройки сайта',
        'menu_slug' => 'acf-options',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

// Функция активации темы - создание страниц и записей
function zamok01_theme_activation($force = false) {
    // Проверяем, не запускалась ли уже функция (если не принудительный запуск)
    if (!$force && get_option('zamok01_theme_activated')) {
        return;
    }
    
    // Создание категорий статей
    $categories = array(
        'Вскрытие замков' => array('slug' => 'vskrytie-zamkov'),
        'Безопасность жилища' => array('slug' => 'bezopasnost-zhilishha'),
        'Все о сейфах' => array('slug' => 'vse-o-sejfah'),
        'Безопасность автомобиля' => array('slug' => 'bezopasnost-avtomobilya'),
        'Техпомощь' => array('slug' => 'tehпомощь'),
    );
    
    $category_ids = array();
    foreach ($categories as $name => $args) {
        $term = wp_insert_term($name, 'category', $args);
        if (!is_wp_error($term)) {
            $category_ids[$name] = $term['term_id'];
        }
    }
    
    // Создание страниц
    $pages = array(
        'Главная' => array(
            'template' => 'default',
            'content' => '',
            'is_front' => true,
        ),
        'Контакты' => array(
            'template' => 'page-contacts.php',
            'content' => '',
        ),
        'Вскрытие автомобилей' => array(
            'template' => 'page-service.php',
            'content' => '<p>Мы работаем по Москве и Московской области круглосуточно. Вскрываем автомобили без повреждений за 15-20 минут.</p>',
        ),
        'Вскрытие двери квартиры' => array(
            'template' => 'page-service.php',
            'content' => '<p>Экстренная помощь при потере ключей или поломке замка. Откроем дверь в вашу квартиру быстро и аккуратно.</p>',
        ),
        'Вскрытие сейфов' => array(
            'template' => 'page-service.php',
            'content' => '<p>Деликатное вскрытие сейфов без повреждений. Восстановление доступа при потере ключа или кода.</p>',
        ),
        'Вскрытие гаражей' => array(
            'template' => 'page-service.php',
            'content' => '<p>Вскрытие гаражей без подключения к электросети и без повреждений конструкции ворот.</p>',
        ),
    );
    
    $page_ids = array();
    foreach ($pages as $title => $args) {
        $page = get_page_by_title($title);
        if (!$page) {
            $page_id = wp_insert_post(array(
                'post_title' => $title,
                'post_content' => $args['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
            
            // Установка шаблона страницы
            if ($args['template'] != 'default') {
                update_post_meta($page_id, '_wp_page_template', $args['template']);
            }
            
            $page_ids[$title] = $page_id;
            
            // Установка главной страницы
            if (isset($args['is_front']) && $args['is_front']) {
                update_option('show_on_front', 'page');
                update_option('page_on_front', $page_id);
            }
        } else {
            $page_ids[$title] = $page->ID;
            // Обновляем шаблон, если нужно
            if ($args['template'] != 'default') {
                update_post_meta($page->ID, '_wp_page_template', $args['template']);
            }
        }
    }
    
    // Заполнение ACF полей для главной страницы
    if (isset($page_ids['Главная'])) {
        update_field('main_title', 'Профессиональное вскрытие замков в Москве и Подмосковье: автомобили, квартиры, сейфы', $page_ids['Главная']);
        
        $main_services = array(
            array(
                'title' => 'Вскрытие автомобилей',
                'tags' => array(
                    array('text' => 'Вскрытие багажника', 'link' => '#', 'half_width' => true),
                    array('text' => 'Снятие блокираторов', 'link' => '#', 'half_width' => true),
                    array('text' => 'Отключение сигнализации', 'link' => '#', 'half_width' => true),
                    array('text' => 'Вскрытие гаражей', 'link' => '#', 'half_width' => true),
                    array('text' => 'Подвоз бензина, дизеля', 'link' => '#', 'half_width' => true),
                    array('text' => 'Прикурить автомобиль', 'link' => '#', 'half_width' => true),
                ),
            ),
            array(
                'title' => 'Вскрытие двери квартиры',
                'tags' => array(
                    array('text' => 'Входные металлические двери', 'link' => '#', 'half_width' => false),
                    array('text' => 'Межкомнатные двери', 'link' => '#', 'half_width' => false),
                    array('text' => 'Вскрытие цилиндрового замка', 'link' => '#', 'half_width' => false),
                ),
            ),
            array(
                'title' => 'Вскрытие сейфов',
                'tags' => array(
                    array('text' => 'Замена замков в сейфах', 'link' => '#', 'half_width' => true),
                    array('text' => 'Как выбрать сейф', 'link' => '#', 'half_width' => true),
                    array('text' => 'Замки для сейфов', 'link' => '#', 'half_width' => false),
                    array('text' => 'Классификация сейфов по назначению', 'link' => '#', 'half_width' => false),
                    array('text' => 'Классификация сейфов по ГОСТ Р 50862-2012', 'link' => '#', 'half_width' => false),
                    array('text' => 'Вскрытие металлических шкафов', 'link' => '#', 'half_width' => false),
                ),
            ),
            array(
                'title' => 'Вскрытие гаражей',
                'tags' => array(
                    array('text' => 'Без подключения к электросети', 'link' => '#', 'half_width' => false),
                    array('text' => 'Без повреждений конструкции ворот', 'link' => '#', 'half_width' => false),
                    array('text' => 'Подзарядка аккумулятора автомобиля бесплатно', 'link' => '#', 'half_width' => false),
                ),
            ),
        );
        update_field('main_services', $main_services, $page_ids['Главная']);
        
        $prices = array(
            array('title' => 'Стоимость вскрытия автомобилей', 'price' => 'от 1500 Р', 'link' => '#'),
            array('title' => 'Услуга «прикурить» автомобиль', 'price' => 'от 1500 Р', 'link' => '#'),
            array('title' => 'Стоимость вскрытия замков и дверей', 'price' => 'от 1500 Р', 'link' => '#'),
            array('title' => 'Стоимость вскрытия сейфов', 'price' => 'от 1500 Р', 'link' => '#'),
            array('title' => 'Открыть машину в области', 'price' => 'от 1500 Р', 'link' => '#'),
        );
        update_field('prices', $prices, $page_ids['Главная']);
        
        update_field('main_info_text', '<p>Забыли ключи в машине? Заклинил замок в квартире? Потеряли код от сейфа? <br>Без паники! <b class="text-att">Команда «Замок 01»</b> — это ваш надежный помощник в любой непредвиденной ситуации. Мы предлагаем профессиональные услуги по экстренному вскрытию замков любой сложности в Москве и Московской области по разумным ценам.</p>', $page_ids['Главная']);
        
        update_field('advantages_title', 'Почему нам доверяют?', $page_ids['Главная']);
        
        $advantages = array(
            array('text' => '<b>Опыт, проверенный временем:</b> <br>Все наши специалисты имеют многолетний опыт работы в Московской Службе Спасения. Мы знаем, как действовать быстро, аккуратно и эффективно.'),
            array('text' => '<b>Честные цены без сюрпризов:</b> <br>Стоимость услуг оговаривается заранее и не меняется в процессе работы. Вы платите именно ту сумму, которую озвучил мастер.'),
            array('text' => '<b>Гарантия результата:</b> Если по какой-то причине мы не смогли вскрыть замок, вызов мастера для вас будет абсолютно бесплатным.'),
        );
        update_field('advantages', $advantages, $page_ids['Главная']);
        
        update_field('services_title', 'Наши услуги:', $page_ids['Главная']);
        update_field('reviews_title', 'Отзывы о нашей работе', $page_ids['Главная']);
        
        $faq_items = array(
            array('question' => 'Типовой код для открытия сейфа Topaz', 'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>'),
            array('question' => 'Не открывается только правая задняя дверь в машине', 'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>'),
            array('question' => 'Как открыть дверь бмв без повреждения?', 'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>'),
            array('question' => 'Как открыть сейф ONIX KS 16 самостоятельно?', 'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>'),
            array('question' => 'В Вольво ХС60 при вставленном ключе закрылись двери', 'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>'),
        );
        update_field('faq_items', $faq_items, $page_ids['Главная']);
        update_field('faq_title', 'Часто задаваемые вопросы', $page_ids['Главная']);
    }
    
    // Заполнение ACF полей для страницы контактов
    if (isset($page_ids['Контакты'])) {
        update_field('contacts_title', 'Контакты Zamok01', $page_ids['Контакты']);
        update_field('contacts_description', 'Мы работаем по Москве и Московской области.', $page_ids['Контакты']);
        
        $contacts = array(
            array(
                'title' => 'Телефоны в Москве:',
                'value' => '<a href="tel:84955145350">+7(495) 514-53-50</a>',
                'link' => '',
            ),
            array(
                'title' => 'Наш офис по адресу:',
                'value' => 'Москва, Хвалынский бульвар дом 7, корпус 2',
                'link' => '#',
            ),
            array(
                'title' => 'Почта:',
                'value' => '<a href="mailto:zamok-01@yandex.ru">zamok-01@yandex.ru</a>',
                'link' => '',
            ),
            array(
                'title' => 'Дополнительные офисы:',
                'value' => 'Полярная дом 31 А',
                'link' => '#',
            ),
            array(
                'title' => '',
                'value' => 'Новоясеневский проспект дом 24 корпус 4',
                'link' => '#',
            ),
        );
        update_field('contacts', $contacts, $page_ids['Контакты']);
    }
    
    // Заполнение ACF полей для страниц услуг
    if (isset($page_ids['Вскрытие автомобилей'])) {
        $info_items = array(
            array('title' => '24/7', 'text' => 'Мастера дежурят круглосуточно по Москве и Подмосковью', 'icon' => ''),
            array('title' => '20 мин.', 'text' => 'Вскрываем автомобили без повреждений и без ключа быстро, обычно менее 20 минут', 'icon' => ''),
            array('title' => '', 'text' => 'Любые марки и модели машин.', 'icon' => 'infinity.svg'),
            array('title' => '', 'text' => 'При севшем аккумуляторе заведем от бустера', 'icon' => 'flash.svg'),
        );
        update_field('info_items', $info_items, $page_ids['Вскрытие автомобилей']);
        
        $article_content = '<p class="text-lead">И если вам говорят, что ключ от вашей машины нужно ждать месяц или нужно бить стекло, потому, что ваш автомобиль вскрыть невозможно, так как ключи в багажнике — не верьте. Без повреждений вскрываются любые автомобильные замки.</p><h2 class="h2-title">Если позволяет погода, мастер по вскрытию автомобилей приедет на мотоцикле максимально быстро</h2><p>Сейчас в нашей стране достаточно сложная финансовая ситуация. Из-за этого люди стараются сэкономить на всём. Большинство товаров и услуг поднимается в цене. Несмотря на это наша компания старается оставаться в том же ценовом диапазоне. Как и в предыдущие годы. Это достигается за счёт оптимизации расходов. Но не в ущерб качеству проводимых работ.</p><p>Несмотря на финансовые траты, наиболее верным решением будет обратиться к специалистам. И вот здесь очень важно не ошибиться в выборе. Мы предлагаем услуги высочайшего качества. Поэтому, часть мастеров нашей компании прошла обучение вскрытию замков в европейских странах. Там данный вид деятельности находится под контролем государства. Также они состоят членами Российской АССОСОД Ассоциации Специалистов Сервисного Обслуживания Систем Ограниченного Доступа. И как результат, опираясь на знания и опыт проведения таких работ, мы гарантируем, что можем вскрыть любую машину без повреждений.</p>';
        update_field('article_content', $article_content, $page_ids['Вскрытие автомобилей']);
        
        update_field('action_title', 'Чтобы вызвать мастера открыть машину звоните по телефону', $page_ids['Вскрытие автомобилей']);
        update_field('action_subtitle', 'приедем через 15-20 минут', $page_ids['Вскрытие автомобилей']);
        update_field('action_info', 'Все работы по вскрытию автомобиля производятся при предъявлении документов на транспортное средство', $page_ids['Вскрытие автомобилей']);
        
        $about_content = '<h2 class="h2-title">Когда необходимо экстренно открыть замок автомобиля без ключа?</h2><p>Иногда водители попадают в ситуацию, когда появляется необходимость экстренно открыть замок автомобиля без ключа. А произойти это может по разным причинам:</p><ul><li>Ключи остались в салоне или багажнике автомобиля.</li><li>Разрядился аккумулятор, а замок на двери не работает.</li><li>Потерялся последний ключ от машины.</li><li>«Зависла» сигнализация.</li><li>и т. д.</li></ul><h2 class="h2-title">Стоит ли вскрывать автомобиль самому?</h2><p>Некоторые водители пытаются открыть машину самостоятельно. Иногда это действительно приводит к положительному результату. Но после таких вскрытий, как правило, остаются «мелкие» неприятности. Например:</p><ul><li>Ободранная краска на стойке и двери автомобиля.</li><li>Лопнувшее стекло.</li><li>Кривая дверь, в которую потом заливает дождь.</li><li>Сгоревший блок управления автомобилем.</li><li>Сломанные замки и т. д.</li></ul><p>Однако, самые опасные помощники водителей, у которых остались ключи в машине, — это соседи, дворники около больших магазинов или просто прохожие. Дело в том, что они имеют весьма отдалённое представление о вскрытии автомобилей. Да и к тому же у них отсутствуют необходимые инструменты и опыт. Но при этом не упустят возможности потренироваться на чужой машине. Если открыть им удалось, то хозяин на радостях, что проблема решена, может не сразу понять глубину проблемы. А из-за последствий такого вскрытия  ему придётся ехать в автосервис для ремонта автомобиля.</p><p>Вскрытие машин с двойной блокировкой самостоятельно не получится, если у вас нет отмычек. К таким машинам относятся: Опель, БМВ, Шкода, Форд и некоторые другие.</p>';
        update_field('about_content', $about_content, $page_ids['Вскрытие автомобилей']);
        
        update_field('advantages_title', 'Замок автомобиля вскрываем профессионально', $page_ids['Вскрытие автомобилей']);
        update_field('advantages_subtitle', 'Выбирайте профессионалов. Тех, кто действительно может открыть замки у автомобиля без повреждений. Мы выезжаем на вызовы по Москве и ближнему Подмосковью.', $page_ids['Вскрытие автомобилей']);
        
        $advantages = array(
            array('text' => '<b>Опыт, проверенный временем:</b> <br>Все наши специалисты имеют многолетний опыт работы в Московской Службе Спасения. Мы знаем, как действовать быстро, аккуратно и эффективно.'),
            array('text' => '<b>Честные цены без сюрпризов:</b> <br>Стоимость услуг оговаривается заранее и не меняется в процессе работы. Вы платите именно ту сумму, которую озвучил мастер.'),
            array('text' => '<b>Гарантия результата:</b> Если по какой-то причине мы не смогли вскрыть замок, вызов мастера для вас будет абсолютно бесплатным.'),
        );
        update_field('advantages', $advantages, $page_ids['Вскрытие автомобилей']);
    }
    
    // Создание услуг
    $services = array(
        array(
            'title' => 'Вскрытие автомобилей',
            'content' => '<p><b>Без единой царапины: </b><br>Мы откроем ваш автомобиль без повреждений, даже если установлена двойная блокировка. Мы не отгибаем двери и не используем варварские методы.</p><p><b>Любые марки и модели: </b> <br>Наши мастера справятся с замками как отечественных, так и импортных автомобилей.</p><p><b>Вскрытие багажника: </b><br>Захлопнулись ключи в багажнике? Не проблема, мы аккуратно его откроем.</p><p><b>Помощь на дороге: </b><br>После вскрытия автомобиля наш мастер может завести двигатель с помощью профессионального пускового устройства (бустера) со скидкой 50%. Мы работаем с аккумуляторами на 12 и 24 вольта.</p>',
            'excerpt' => 'Вскрытие автомобилей без повреждений. Любые марки и модели.',
            'price' => 'от 1500 Р',
        ),
        array(
            'title' => 'Вскрытие квартир и домов',
            'content' => '<p><b>Экстренная помощь: </b><br>Потеряли ключи или сломался замок? Мы оперативно откроем дверь в вашу квартиру.</p><p><b>Замена замков на месте: </b><br>У нашего мастера всегда с собой большой ассортимент новых замков. При необходимости мы сразу же заменим неисправный механизм.</p><p><b>Работаем с любыми дверями: </b><br>Мы без повреждений вскроем даже сложные китайские двери, если вы случайно заблокировали замок, подняв ручку вверх.</p>',
            'excerpt' => 'Экстренное вскрытие дверей квартир и домов. Замена замков на месте.',
            'price' => 'от 1500 Р',
        ),
        array(
            'title' => 'Вскрытие сейфов',
            'content' => '<p><b>Деликатный подход: </b><br>Мы понимаем ценность содержимого вашего сейфа, поэтому вскрытие производится без повреждений, сверления и других разрушающих методов.</p><p><b>Восстановление доступа: </b><br>Потеряли ключ или забыли код? Наши специалисты откроют сейф и, при необходимости, помогут сменить кодовую комбинацию или заменить замок.</p>',
            'excerpt' => 'Деликатное вскрытие сейфов без повреждений. Восстановление доступа.',
            'price' => 'от 1500 Р',
        ),
    );
    
    foreach ($services as $service_data) {
        $service = get_page_by_title($service_data['title'], OBJECT, 'service');
        if (!$service) {
            $service_id = wp_insert_post(array(
                'post_title' => $service_data['title'],
                'post_content' => $service_data['content'],
                'post_excerpt' => $service_data['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'service',
            ));
            
            if ($service_id) {
                update_field('service_description', $service_data['content'], $service_id);
                update_field('service_price', $service_data['price'], $service_id);
            }
        }
    }
    
    // Создание отзывов
    $reviews = array(
        array(
            'title' => 'Елена',
            'content' => 'Вежливое общение оператора. Оперативный выезд. Быстрая и аккуратная работа. Спасибо!',
            'car_brand' => 'Mercedes',
            'opening_time' => '2 минуты',
            'date' => '2025-10-10',
        ),
        array(
            'title' => 'Александр',
            'content' => 'Очень быстро приехали, открыли машину за 5 минут. Никаких повреждений. Рекомендую!',
            'car_brand' => 'BMW',
            'opening_time' => '5 минут',
            'date' => '2025-10-08',
        ),
        array(
            'title' => 'Мария',
            'content' => 'Забыла ключи в квартире. Мастер приехал через 20 минут и аккуратно открыл дверь. Спасибо большое!',
            'car_brand' => '',
            'opening_time' => '15 минут',
            'date' => '2025-10-05',
        ),
    );
    
    foreach ($reviews as $review_data) {
        $review = get_page_by_title($review_data['title'], OBJECT, 'review');
        if (!$review) {
            $review_id = wp_insert_post(array(
                'post_title' => $review_data['title'],
                'post_content' => $review_data['content'],
                'post_status' => 'publish',
                'post_type' => 'review',
                'post_date' => $review_data['date'] . ' 12:00:00',
            ));
            
            if ($review_id) {
                update_field('car_brand', $review_data['car_brand'], $review_id);
                update_field('opening_time', $review_data['opening_time'], $review_id);
            }
        }
    }
    
    // Создание статей
    $articles = array(
        array(
            'title' => 'Почему нельзя взламывать замок от двери?',
            'content' => '<p>Видели кино, где спасатели ловко взломали дверь спасая людей?</p><p>Или фильм с криминалом, где вор фомкой легко открыл дверь…</p><p>Хотите попробовать так же? И остаться с открытой квартирой на несколько дней?</p><p>Ваша задача — открыть дверь так, чтобы ей можно было потом пользоваться.</p><p>Мысли о взломе замка посещают владельца помещения в случаях заклинивания замка или потери ключа и невозможности попасть внутрь.</p><h2 class="h2-title">Взлом замка — испорченный замок и полотно двери</h2><p>При взломе замка страдает не только сам замок, но и посадочное место.</p><p>В некоторых случаях полотно деформируется так, что наиболее приемлемым вариантом становится замена двери.</p>',
            'excerpt' => 'Много интересной информации по вскрытию замков, рекомендации, как не стать жертвой проходимцев.',
            'category' => 'Вскрытие замков',
        ),
        array(
            'title' => 'Какие секретки выбрать?',
            'content' => '<p>Полезная статья о том, как дополнительно защитить собственный автомобиль от угона и вскрытия.</p><p>Секретки — это дополнительные устройства защиты, которые устанавливаются на автомобиль для предотвращения угона.</p>',
            'excerpt' => 'Полезная статья о том, как дополнительно защитить собственный автомобиль…',
            'category' => 'Безопасность автомобиля',
        ),
        array(
            'title' => 'Как открыть мерседес w210 без ключа?',
            'content' => '<p>Кроме того, дополнительную сложность добавляют жесткие двери у Мерседеса, которые очень трудно отогнуть. Однако, если замок на двери работает, то его нужно открывать ТОЛЬКО специальным инструментом…</p>',
            'excerpt' => 'Кроме того, дополнительную сложность добавляют жесткие двери у Мерседеса, которые очень трудно отогнуть. Однако, если замок на двери работает, то его нужно открывать ТОЛЬКО специальным инструментом…',
            'category' => 'Безопасность автомобиля',
        ),
    );
    
    foreach ($articles as $article_data) {
        $article = get_page_by_title($article_data['title'], OBJECT, 'article');
        if (!$article) {
            $article_id = wp_insert_post(array(
                'post_title' => $article_data['title'],
                'post_content' => $article_data['content'],
                'post_excerpt' => $article_data['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'post',
            ));
            
            if ($article_id && isset($category_ids[$article_data['category']])) {
                wp_set_object_terms($article_id, $category_ids[$article_data['category']], 'category');
                update_field('article_description', $article_data['excerpt'], $article_id);
            }
        }
    }
    
    // Заполнение опций ACF
    update_field('phone_main', '+7 (495) 514-53-50', 'option');
    update_field('email_main', 'zamok-01@yandex.ru', 'option');
    
    $phones = array(
        array('phone' => '+7 (495) 514-53-50'),
        array('phone' => '+7 (916) 0889-911'),
        array('phone' => '+7 (925) 514-53-50'),
    );
    update_field('phones', $phones, 'option');
    
    update_field('social_vk', 'https://vk.com/zamok01', 'option');
    update_field('social_wa', 'https://wa.me/74955145350', 'option');
    update_field('social_tg', 'https://t.me/zamok01', 'option');
    
    update_field('footer_info', 'Работаем круглосуточно по Москве и МО <br>Время приезда мастера от 20 минут', 'option');
    update_field('footer_shield_title', 'ZAMOK01 входит в состав АССОСОД', 'option');
    update_field('footer_shield_text', 'Российская ассоциация специалистов сервисного обслуживания систем ограничения доступа', 'option');
    
    $car_brands = array(
        array('value' => 'mercedes', 'label' => 'Mercedes'),
        array('value' => 'bmw', 'label' => 'BMW'),
        array('value' => 'audi', 'label' => 'Audi'),
        array('value' => 'volkswagen', 'label' => 'Volkswagen'),
        array('value' => 'toyota', 'label' => 'Toyota'),
    );
    update_field('car_brands', $car_brands, 'option');
    
    $opening_times = array(
        array('value' => '2', 'label' => '2 минуты'),
        array('value' => '5', 'label' => '5 минут'),
        array('value' => '10', 'label' => '10 минут'),
        array('value' => '15', 'label' => '15 минут'),
        array('value' => '20', 'label' => '20 минут'),
    );
    update_field('opening_times', $opening_times, 'option');
    
    update_field('action_title', 'Чтобы вызвать мастера открыть машину звоните по телефону', 'option');
    update_field('action_subtitle', 'приедем через 15-20 минут', 'option');
    update_field('action_info', 'Все работы по вскрытию автомобиля производятся при предъявлении документов на транспортное средство', 'option');
    
    update_field('reviews_archive_title', 'Отзывы о работе Службы Zamok01 по вскрытию замков', 'option');
    update_field('reviews_archive_description', 'Если Вы пользовались нашими услугами, наши мастера Вам вскрывали автомобиль или дверь, оставьте отзыв о нашей работе.', 'option');
    
    update_field('articles_archive_title', 'Статьи на тему безопасности и вскрытия замков', 'option');
    update_field('articles_archive_description', 'Много интересной информации по вскрытию замков, рекомендации, как не стать жертвой проходимцев.', 'option');
    
    // Email для формы обратного звонка
    update_field('callback_email', get_option('admin_email'), 'option');
    
    // Отмечаем, что функция уже запускалась
    update_option('zamok01_theme_activated', true);
}
add_action('after_switch_theme', 'zamok01_theme_activation');

// Функция для ручного запуска создания страниц (можно вызвать через админ-панель)
function zamok01_create_pages_manually() {
    // Принудительный запуск
    zamok01_theme_activation(true);
    wp_die('Страницы и записи успешно созданы! <a href="' . admin_url() . '">Вернуться в админ-панель</a>', 'Готово', array('back_link' => true));
}

// Добавляем пункт меню для ручного запуска (только для администраторов)
if (is_admin() && current_user_can('manage_options')) {
    add_action('admin_menu', function() {
        add_management_page(
            'Создать страницы Zamok01',
            'Создать страницы Zamok01',
            'manage_options',
            'zamok01-create-pages',
            'zamok01_create_pages_manually'
        );
        
        add_management_page(
            'Заполнить услуги контентом',
            'Заполнить услуги контентом',
            'manage_options',
            'zamok01-fill-services',
            'zamok01_fill_services_content'
        );
        
        add_management_page(
            'Импорт отзывов',
            'Импорт отзывов',
            'manage_options',
            'zamok01-import-reviews',
            'zamok01_import_reviews'
        );
    });
}

// Функция для заполнения услуг контентом из верстки
function zamok01_fill_services_content() {
    if (!current_user_can('manage_options')) {
        wp_die('У вас нет прав для выполнения этого действия.');
    }
    
    // Данные для заполнения услуг
    $services_data = array(
        'Вскрытие автомобилей' => array(
            'info_items' => array(
                array(
                    'title' => '24/7',
                    'text' => 'Мастера дежурят круглосуточно по Москве и Подмосковью',
                    'icon' => '',
                ),
                array(
                    'title' => '20 мин.',
                    'text' => 'Вскрываем автомобили без повреждений и без ключа быстро, обычно менее 20 минут',
                    'icon' => '',
                ),
                array(
                    'title' => '',
                    'text' => 'Любые марки и модели машин.',
                    'icon' => 'infinity.svg',
                ),
                array(
                    'title' => '',
                    'text' => 'При севшем аккумуляторе заведем от бустера',
                    'icon' => 'flash.svg',
                ),
            ),
            'article_content' => '<p class="text-lead">И если вам говорят, что ключ от вашей машины нужно ждать месяц или нужно бить стекло, потому, что ваш автомобиль вскрыть невозможно, так как ключи в багажнике — не верьте. Без повреждений вскрываются любые автомобильные замки.</p><h2 class="h2-title">Если позволяет погода, мастер по вскрытию автомобилей приедет на мотоцикле максимально быстро</h2><p>Сейчас в нашей стране достаточно сложная финансовая ситуация. Из-за этого люди стараются сэкономить на всём. Большинство товаров и услуг поднимается в цене. Несмотря на это наша компания старается оставаться в том же ценовом диапазоне. Как и в предыдущие годы. Это достигается за счёт оптимизации расходов. Но не в ущерб качеству проводимых работ.</p><p>Несмотря на финансовые траты, наиболее верным решением будет обратиться к специалистам. И вот здесь очень важно не ошибиться в выборе. Мы предлагаем услуги высочайшего качества. Поэтому, часть мастеров нашей компании прошла обучение вскрытию замков в европейских странах. Там данный вид деятельности находится под контролем государства. Также они состоят членами Российской АССОСОД Ассоциации Специалистов Сервисного Обслуживания Систем Ограниченного Доступа. И как результат, опираясь на знания и опыт проведения таких работ, мы гарантируем, что можем вскрыть любую машину без повреждений.</p>',
            'action_title' => 'Чтобы вызвать мастера открыть машину звоните по телефону',
            'action_subtitle' => 'приедем через 15-20 минут',
            'action_info' => 'Все работы по вскрытию автомобиля производятся при предъявлении документов на транспортное средство',
            'about_content' => '<h2 class="h2-title">Когда необходимо экстренно открыть замок автомобиля без ключа?</h2><p>Иногда водители попадают в ситуацию, когда появляется необходимость экстренно открыть замок автомобиля без ключа. А произойти это может по разным причинам:</p><ul><li>Ключи остались в салоне или багажнике автомобиля.</li><li>Разрядился аккумулятор, а замок на двери не работает.</li><li>Потерялся последний ключ от машины.</li><li>«Зависла» сигнализация.</li><li>и т. д.</li></ul><h2 class="h2-title">Стоит ли вскрывать автомобиль самому?</h2><p>Некоторые водители пытаются открыть машину самостоятельно. Иногда это действительно приводит к положительному результату. Но после таких вскрытий, как правило, остаются «мелкие» неприятности. Например:</p><ul><li>Ободранная краска на стойке и двери автомобиля.</li><li>Лопнувшее стекло.</li><li>Кривая дверь, в которую потом заливает дождь.</li><li>Сгоревший блок управления автомобилем.</li><li>Сломанные замки и т. д.</li></ul><p>Однако, самые опасные помощники водителей, у которых остались ключи в машине, — это соседи, дворники около больших магазинов или просто прохожие. Дело в том, что они имеют весьма отдалённое представление о вскрытии автомобилей. Да и к тому же у них отсутствуют необходимые инструменты и опыт. Но при этом не упустят возможности потренироваться на чужой машине. Если открыть им удалось, то хозяин на радостях, что проблема решена, может не сразу понять глубину проблемы. А из-за последствий такого вскрытия  ему придётся ехать в автосервис для ремонта автомобиля.</p><p>Вскрытие машин с двойной блокировкой самостоятельно не получится, если у вас нет отмычек. К таким машинам относятся: <a href="" class="link-main">Опель</a>, БМВ, Шкода, Форд и некоторые другие.</p>',
            'advantages_title' => 'Замок автомобиля вскрываем профессионально',
            'advantages_subtitle' => 'Выбирайте профессионалов. Тех, кто действительно может открыть замки у автомобиля без повреждений. Мы выезжаем на вызовы по Москве и ближнему Подмосковью.',
            'advantages' => array(
                array('text' => '<b>Опыт, проверенный временем:</b> <br>Все наши специалисты имеют многолетний опыт работы в Московской Службе Спасения. Мы знаем, как действовать быстро, аккуратно и эффективно.'),
                array('text' => '<b>Честные цены без сюрпризов:</b> <br>Стоимость услуг оговаривается заранее и не меняется в процессе работы. Вы платите именно ту сумму, которую озвучил мастер.'),
                array('text' => '<b>Гарантия результата:</b> Если по какой-то причине мы не смогли вскрыть замок, вызов мастера для вас будет абсолютно бесплатным.'),
            ),
            'reviews_title' => 'Отзывы о нашей работе',
            'related_services_title' => 'Мы также оказываем услуги:',
            'articles_title' => 'Статьи по безопасности автомобиля:',
            'faq_title' => 'Часто задаваемые вопросы',
            'faq_links' => array(
                array(
                    'text' => 'Как найти мастера по вскрытию замков и автомобилей?',
                    'link' => '#',
                    'popup' => false,
                ),
                array(
                    'text' => 'Почему иногда мы отказываемся открывать замки без объяснения причины',
                    'link' => '#',
                    'popup' => false,
                ),
                array(
                    'text' => 'Задайте свой вопрос',
                    'link' => '#',
                    'popup' => true,
                ),
            ),
            'faq_items' => array(
                array(
                    'question' => 'Типовой код для открытия сейфа Topaz',
                    'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>',
                ),
                array(
                    'question' => 'Не открывается только правая задняя дверь в машине',
                    'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>',
                ),
                array(
                    'question' => 'Как открыть дверь бмв без повреждения?',
                    'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>',
                ),
                array(
                    'question' => 'Как открыть сейф ONIX KS 16 самостоятельно?',
                    'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>',
                ),
                array(
                    'question' => 'В Вольво ХС60 при вставленном ключе закрылись двери',
                    'answer' => '<p>Чтобы открыть сейф Topaz с электронным замком нужно воспользоваться заводским кодом. Для разных моделей это могут быть различные варианты.</p>',
                ),
            ),
        ),
        'Вскрытие квартир и домов' => array(
            'info_items' => array(
                array(
                    'title' => '24/7',
                    'text' => 'Мастера дежурят круглосуточно по Москве и Подмосковью',
                    'icon' => '',
                ),
                array(
                    'title' => '15 мин.',
                    'text' => 'Вскрываем двери квартир без повреждений быстро, обычно менее 15 минут',
                    'icon' => '',
                ),
                array(
                    'title' => '',
                    'text' => 'Любые типы дверей и замков.',
                    'icon' => 'infinity.svg',
                ),
                array(
                    'title' => '',
                    'text' => 'Замена замков на месте',
                    'icon' => 'flash.svg',
                ),
            ),
            'article_content' => '<p class="text-lead">Экстренная помощь при потере ключей или поломке замка. Мы оперативно откроем дверь в вашу квартиру без повреждений.</p><h2 class="h2-title">Профессиональное вскрытие дверей квартир</h2><p>Наши мастера имеют многолетний опыт работы и могут вскрыть любую дверь без повреждений. Мы работаем с металлическими, деревянными дверями, а также с любыми типами замков.</p>',
            'action_title' => 'Чтобы вызвать мастера открыть дверь звоните по телефону',
            'action_subtitle' => 'приедем через 15-20 минут',
            'action_info' => 'Все работы по вскрытию двери производятся при предъявлении документов на квартиру',
            'about_content' => '<h2 class="h2-title">Когда необходимо вскрыть дверь квартиры?</h2><p>Иногда возникают ситуации, когда необходимо экстренно открыть дверь квартиры:</p><ul><li>Потеряли ключи от квартиры.</li><li>Сломался замок.</li><li>Захлопнулась дверь.</li><li>Забыли ключи внутри.</li></ul>',
            'advantages_title' => 'Вскрытие дверей квартир профессионально',
            'advantages_subtitle' => 'Выбирайте профессионалов. Мы вскрываем любые двери без повреждений.',
            'advantages' => array(
                array('text' => '<b>Опыт, проверенный временем:</b> <br>Все наши специалисты имеют многолетний опыт работы в Московской Службе Спасения. Мы знаем, как действовать быстро, аккуратно и эффективно.'),
                array('text' => '<b>Честные цены без сюрпризов:</b> <br>Стоимость услуг оговаривается заранее и не меняется в процессе работы. Вы платите именно ту сумму, которую озвучил мастер.'),
                array('text' => '<b>Гарантия результата:</b> Если по какой-то причине мы не смогли вскрыть замок, вызов мастера для вас будет абсолютно бесплатным.'),
            ),
            'reviews_title' => 'Отзывы о нашей работе',
            'related_services_title' => 'Мы также оказываем услуги:',
            'articles_title' => 'Статьи по безопасности:',
        ),
        'Вскрытие сейфов' => array(
            'info_items' => array(
                array(
                    'title' => '24/7',
                    'text' => 'Мастера дежурят круглосуточно по Москве и Подмосковью',
                    'icon' => '',
                ),
                array(
                    'title' => '30 мин.',
                    'text' => 'Вскрываем сейфы без повреждений, обычно менее 30 минут',
                    'icon' => '',
                ),
                array(
                    'title' => '',
                    'text' => 'Любые типы сейфов.',
                    'icon' => 'infinity.svg',
                ),
                array(
                    'title' => '',
                    'text' => 'Восстановление доступа',
                    'icon' => 'flash.svg',
                ),
            ),
            'article_content' => '<p class="text-lead">Деликатное вскрытие сейфов без повреждений. Мы понимаем ценность содержимого вашего сейфа, поэтому вскрытие производится без сверления и других разрушающих методов.</p><h2 class="h2-title">Профессиональное вскрытие сейфов</h2><p>Наши специалисты могут вскрыть любой сейф без повреждений. После вскрытия мы поможем сменить кодовую комбинацию или заменить замок.</p>',
            'action_title' => 'Чтобы вызвать мастера открыть сейф звоните по телефону',
            'action_subtitle' => 'приедем через 15-20 минут',
            'action_info' => 'Все работы по вскрытию сейфа производятся при предъявлении документов',
            'about_content' => '<h2 class="h2-title">Когда необходимо вскрыть сейф?</h2><p>Иногда возникают ситуации, когда необходимо вскрыть сейф:</p><ul><li>Потеряли ключ от сейфа.</li><li>Забыли код.</li><li>Сломался замок.</li><li>Заблокировался механизм.</li></ul>',
            'advantages_title' => 'Вскрытие сейфов профессионально',
            'advantages_subtitle' => 'Выбирайте профессионалов. Мы вскрываем любые сейфы без повреждений.',
            'advantages' => array(
                array('text' => '<b>Опыт, проверенный временем:</b> <br>Все наши специалисты имеют многолетний опыт работы в Московской Службе Спасения. Мы знаем, как действовать быстро, аккуратно и эффективно.'),
                array('text' => '<b>Честные цены без сюрпризов:</b> <br>Стоимость услуг оговаривается заранее и не меняется в процессе работы. Вы платите именно ту сумму, которую озвучил мастер.'),
                array('text' => '<b>Гарантия результата:</b> Если по какой-то причине мы не смогли вскрыть замок, вызов мастера для вас будет абсолютно бесплатным.'),
            ),
            'reviews_title' => 'Отзывы о нашей работе',
            'related_services_title' => 'Мы также оказываем услуги:',
            'articles_title' => 'Статьи о сейфах:',
        ),
    );
    
    $updated = 0;
    $errors = array();
    
    foreach ($services_data as $service_title => $data) {
        $service = get_page_by_title($service_title, OBJECT, 'service');
        
        if (!$service) {
            $errors[] = "Услуга '{$service_title}' не найдена";
            continue;
        }
        
        $service_id = $service->ID;
        
        // Заполнение info_items
        if (isset($data['info_items'])) {
            $info_items = array();
            foreach ($data['info_items'] as $item) {
                $info_item = array(
                    'title' => $item['title'],
                    'text' => $item['text'],
                );
                
                // Обработка иконок - загружаем в медиатеку или используем существующую
                if (!empty($item['icon'])) {
                    $icon_path = get_template_directory() . '/img/icons/' . $item['icon'];
                    if (file_exists($icon_path)) {
                        // Проверяем, есть ли уже такое изображение в медиатеке
                        $existing = get_posts(array(
                            'post_type' => 'attachment',
                            'post_mime_type' => 'image',
                            'posts_per_page' => 1,
                            'meta_query' => array(
                                array(
                                    'key' => '_wp_attached_file',
                                    'value' => basename($item['icon']),
                                    'compare' => 'LIKE'
                                )
                            )
                        ));
                        
                        if (!empty($existing)) {
                            $info_item['icon'] = $existing[0]->ID;
                        } else {
                            $attachment_id = zamok01_upload_image_from_path($icon_path, $item['icon']);
                            if ($attachment_id) {
                                $info_item['icon'] = $attachment_id;
                            }
                        }
                    }
                }
                
                $info_items[] = $info_item;
            }
            update_field('info_items', $info_items, $service_id);
        }
        
        // Заполнение остальных полей
        if (isset($data['article_content'])) {
            update_field('article_content', $data['article_content'], $service_id);
        }
        
        if (isset($data['action_title'])) {
            update_field('action_title', $data['action_title'], $service_id);
        }
        
        if (isset($data['action_subtitle'])) {
            update_field('action_subtitle', $data['action_subtitle'], $service_id);
        }
        
        if (isset($data['action_info'])) {
            update_field('action_info', $data['action_info'], $service_id);
        }
        
        if (isset($data['about_content'])) {
            update_field('about_content', $data['about_content'], $service_id);
        }
        
        // Обработка изображения about_image для услуги "Вскрытие автомобилей"
        if ($service_title == 'Вскрытие автомобилей') {
            $about_image_path = get_template_directory() . '/img/about.jpg';
            if (file_exists($about_image_path)) {
                $existing_about = get_posts(array(
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key' => '_wp_attached_file',
                            'value' => 'about.jpg',
                            'compare' => 'LIKE'
                        )
                    )
                ));
                
                if (!empty($existing_about)) {
                    update_field('about_image', $existing_about[0]->ID, $service_id);
                } else {
                    $about_attachment_id = zamok01_upload_image_from_path($about_image_path, 'about.jpg');
                    if ($about_attachment_id) {
                        update_field('about_image', $about_attachment_id, $service_id);
                    }
                }
            }
        }
        
        // Обработка изображения action_image
        if (!isset($data['action_image'])) {
            $action_image_path = get_template_directory() . '/img/photo01.png';
            if (file_exists($action_image_path)) {
                $existing_action = get_posts(array(
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        array(
                            'key' => '_wp_attached_file',
                            'value' => 'photo01.png',
                            'compare' => 'LIKE'
                        )
                    )
                ));
                
                if (!empty($existing_action)) {
                    update_field('action_image', $existing_action[0]->ID, $service_id);
                } else {
                    $action_attachment_id = zamok01_upload_image_from_path($action_image_path, 'photo01.png');
                    if ($action_attachment_id) {
                        update_field('action_image', $action_attachment_id, $service_id);
                    }
                }
            }
        }
        
        if (isset($data['advantages_title'])) {
            update_field('advantages_title', $data['advantages_title'], $service_id);
        }
        
        if (isset($data['advantages_subtitle'])) {
            update_field('advantages_subtitle', $data['advantages_subtitle'], $service_id);
        }
        
        if (isset($data['advantages'])) {
            update_field('advantages', $data['advantages'], $service_id);
        }
        
        if (isset($data['reviews_title'])) {
            update_field('reviews_title', $data['reviews_title'], $service_id);
        }
        
        if (isset($data['related_services_title'])) {
            update_field('related_services_title', $data['related_services_title'], $service_id);
        }
        
        if (isset($data['articles_title'])) {
            update_field('articles_title', $data['articles_title'], $service_id);
        }
        
        if (isset($data['faq_title'])) {
            update_field('faq_title', $data['faq_title'], $service_id);
        }
        
        if (isset($data['faq_links'])) {
            update_field('faq_links', $data['faq_links'], $service_id);
        }
        
        if (isset($data['faq_items'])) {
            update_field('faq_items', $data['faq_items'], $service_id);
        }
        
        $updated++;
    }
    
    $message = "Успешно обновлено услуг: {$updated}";
    if (!empty($errors)) {
        $message .= "<br>Ошибки:<br>" . implode("<br>", $errors);
    }
    
    wp_die($message . '<br><br><a href="' . admin_url() . '">Вернуться в админ-панель</a>', 'Готово', array('back_link' => true));
}

// Функция для загрузки изображения из файла
function zamok01_upload_image_from_path($file_path, $filename) {
    if (!file_exists($file_path)) {
        return false;
    }
    
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    
    $upload = wp_upload_bits(basename($filename), null, file_get_contents($file_path));
    
    if ($upload['error']) {
        return false;
    }
    
    $attachment = array(
        'post_mime_type' => wp_check_filetype($filename)['type'],
        'post_title' => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $upload['file']);
    $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $attach_data);
    
    return $attach_id;
}

// AJAX обработчик для загрузки статей по категориям
function zamok01_load_articles_ajax() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zamok01_ajax_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => get_option('posts_per_page', 12),
        'paged' => $page,
        'post_status' => 'publish',
    );
    
    if ($category_id > 0) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        );
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
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
    
    $articles_html = ob_get_clean();
    
    // Пагинация
    ob_start();
    if ($query->max_num_pages > 1):
        $pagination_args = array(
            'total' => $query->max_num_pages,
            'current' => $page,
            'prev_text' => '←',
            'next_text' => '→',
            'type' => 'list',
        );
        echo paginate_links($pagination_args);
    endif;
    $pagination_html = ob_get_clean();
    
    wp_reset_postdata();
    
    wp_send_json_success(array(
        'articles' => $articles_html,
        'pagination' => $pagination_html,
        'found_posts' => $query->found_posts,
    ));
}
add_action('wp_ajax_load_articles', 'zamok01_load_articles_ajax');
add_action('wp_ajax_nopriv_load_articles', 'zamok01_load_articles_ajax');

// Локализация скрипта для AJAX
function zamok01_localize_ajax_script() {
    wp_localize_script('main', 'zamok01_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('zamok01_ajax_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'zamok01_localize_ajax_script', 20);

// AJAX обработчик для отправки формы обратного звонка
function zamok01_send_callback() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zamok01_ajax_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    // Получаем данные формы
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $agree = isset($_POST['agree']) ? true : false;
    
    // Валидация
    if (empty($name)) {
        wp_send_json_error(array('message' => 'Пожалуйста, укажите ваше имя'));
        return;
    }
    
    if (empty($phone)) {
        wp_send_json_error(array('message' => 'Пожалуйста, укажите ваш телефон'));
        return;
    }
    
    if (!$agree) {
        wp_send_json_error(array('message' => 'Необходимо дать согласие на обработку персональных данных'));
        return;
    }
    
    // Получаем email из настроек ACF
    $email = get_field('callback_email', 'option');
    if (empty($email)) {
        // Если email не указан в настройках, используем email администратора
        $email = get_option('admin_email');
    }
    
    // Формируем тему письма
    $subject = 'Заявка на обратный звонок с сайта ' . get_bloginfo('name');
    
    // Формируем тело письма
    $body = "Поступила новая заявка на обратный звонок:\n\n";
    $body .= "Имя: " . $name . "\n";
    $body .= "Телефон: " . $phone . "\n";
    if (!empty($message)) {
        $body .= "Сообщение: " . $message . "\n";
    }
    $body .= "\n---\n";
    $body .= "Дата: " . date('d.m.Y H:i:s') . "\n";
    $body .= "IP адрес: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    // Заголовки письма
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
    );
    
    // Отправляем письмо
    $sent = wp_mail($email, $subject, $body, $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Заявка успешно отправлена'));
    } else {
        wp_send_json_error(array('message' => 'Ошибка при отправке письма. Попробуйте позже.'));
    }
}
add_action('wp_ajax_send_callback', 'zamok01_send_callback');
add_action('wp_ajax_nopriv_send_callback', 'zamok01_send_callback');

// Функция для получения изображения поста (миниатюра или первое изображение из контента)
function zamok01_get_post_image($post_id = null, $size = 'full', $default = '/assosod/assosod.png') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    // Сначала проверяем миниатюру
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail($post_id, $size, array('alt' => get_the_title($post_id)));
    }
    
    // Если миниатюры нет, ищем первое изображение в контенте
    $post = get_post($post_id);
    if ($post) {
        $content = $post->post_content;
        
        // Используем DOMDocument для более надежного парсинга
        if (class_exists('DOMDocument')) {
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
            $images = $dom->getElementsByTagName('img');
            
            if ($images->length > 0) {
                $first_image = $images->item(0);
                $image_url = $first_image->getAttribute('src');
                
                if ($image_url) {
                    // Обрабатываем относительные URL
                    if (strpos($image_url, 'http') !== 0) {
                        if (strpos($image_url, '/') === 0) {
                            $image_url = home_url($image_url);
                        } else {
                            $image_url = home_url('/' . $image_url);
                        }
                    }
                    
                    // Преобразуем имя файла в URL к нижнему регистру (как в replace_uppercase_filenames)
                    $image_url = preg_replace_callback(
                        '/(https?:\/\/[^\"\s>]+?\/([^\/]+\/)*)([^\/\?\"\s>]+?\.(jpg|jpeg|png|gif|webp))/i',
                        function($matches) {
                            $base_url = $matches[1];  // Домен и путь
                            $filename = strtolower($matches[3]);  // Имя файла в нижнем регистре
                            return $base_url . $filename;
                        },
                        $image_url
                    );
                    
                    // Проверяем, является ли это вложением WordPress
                    $attachment_id = attachment_url_to_postid($image_url);
                    if ($attachment_id) {
                        // Если это вложение WordPress, используем wp_get_attachment_image
                        return wp_get_attachment_image($attachment_id, $size, false, array('alt' => get_the_title($post_id)));
                    } else {
                        // Если это внешнее изображение, создаем обычный тег img
                        return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($post_id)) . '">';
                    }
                }
            }
        } else {
            // Fallback: используем регулярное выражение, если DOMDocument недоступен
            $output = preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches);
            
            if ($output && isset($matches[1][0])) {
                $image_url = $matches[1][0];
                
                // Обрабатываем относительные URL
                if (strpos($image_url, 'http') !== 0) {
                    if (strpos($image_url, '/') === 0) {
                        $image_url = home_url($image_url);
                    } else {
                        $image_url = home_url('/' . $image_url);
                    }
                }
                
                // Преобразуем имя файла в URL к нижнему регистру (как в replace_uppercase_filenames)
                $image_url = preg_replace_callback(
                    '/(https?:\/\/[^\"\s>]+?\/([^\/]+\/)*)([^\/\?\"\s>]+?\.(jpg|jpeg|png|gif|webp))/i',
                    function($matches) {
                        $base_url = $matches[1];  // Домен и путь
                        $filename = strtolower($matches[3]);  // Имя файла в нижнем регистре
                        return $base_url . $filename;
                    },
                    $image_url
                );
                
                // Проверяем, является ли это вложением WordPress
                $attachment_id = attachment_url_to_postid($image_url);
                if ($attachment_id) {
                    return wp_get_attachment_image($attachment_id, $size, false, array('alt' => get_the_title($post_id)));
                } else {
                    return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($post_id)) . '">';
                }
            }
        }
    }
    
    // Если ничего не найдено, используем новую функцию для получения изображения с применением фильтра
    $image_url = zamok01_get_post_image_url($post_id, $size, $default);
    return '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($post_id)) . '">';
}

// AJAX обработчик для загрузки постов (posts) на странице статей
function zamok01_load_posts_ajax() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zamok01_ajax_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $append = isset($_POST['append']) ? (bool)$_POST['append'] : false; // Для кнопки "Развернуть еще"
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 12,
        'paged' => $page,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );
    
    if ($category_id > 0) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        );
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
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
    endif;
    
    $posts_html = ob_get_clean();
    
    wp_reset_postdata();
    
    wp_send_json_success(array(
        'posts' => $posts_html,
        'has_more' => $page < $query->max_num_pages,
        'current_page' => $page,
        'max_pages' => $query->max_num_pages,
        'found_posts' => $query->found_posts,
    ));
}
add_action('wp_ajax_load_posts', 'zamok01_load_posts_ajax');
add_action('wp_ajax_nopriv_load_posts', 'zamok01_load_posts_ajax');

// AJAX обработчик для загрузки отзывов
function zamok01_load_reviews_ajax() {
    // Проверка nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'zamok01_ajax_nonce')) {
        wp_send_json_error(array('message' => 'Ошибка безопасности'));
        return;
    }
    
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    
    $args = array(
        'post_type' => 'review',
        'posts_per_page' => 9,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    );
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();
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
    
    $reviews_html = ob_get_clean();
    
    wp_reset_postdata();
    
    wp_send_json_success(array(
        'reviews' => $reviews_html,
        'has_more' => $page < $query->max_num_pages,
        'current_page' => $page,
        'max_pages' => $query->max_num_pages,
    ));
}
add_action('wp_ajax_load_reviews', 'zamok01_load_reviews_ajax');
add_action('wp_ajax_nopriv_load_reviews', 'zamok01_load_reviews_ajax');

// Обработчик формы отправки отзыва
function zamok01_handle_review_submit() {
    // Проверка nonce
    if (!isset($_POST['review_nonce']) || !wp_verify_nonce($_POST['review_nonce'], 'submit_review')) {
        wp_die('Ошибка безопасности. Пожалуйста, попробуйте еще раз.', 'Ошибка', array('back_link' => true));
        return;
    }
    
    // Получаем и валидируем данные формы
    $name = isset($_POST['review_name']) ? sanitize_text_field($_POST['review_name']) : '';
    $email = isset($_POST['review_email']) ? sanitize_email($_POST['review_email']) : '';
    $car_brand = isset($_POST['review_car_brand']) ? sanitize_text_field($_POST['review_car_brand']) : '';
    $opening_time = isset($_POST['review_opening_time']) ? sanitize_text_field($_POST['review_opening_time']) : '';
    $text = isset($_POST['review_text']) ? sanitize_textarea_field($_POST['review_text']) : '';
    $consent = isset($_POST['review_consent']) ? true : false;
    
    // Валидация
    $errors = array();
    
    if (empty($name)) {
        $errors[] = 'Пожалуйста, укажите ваше имя';
    }
    
    if (empty($email) || !is_email($email)) {
        $errors[] = 'Пожалуйста, укажите корректный email';
    }
    
    if (empty($car_brand)) {
        $errors[] = 'Пожалуйста, выберите марку автомобиля';
    }
    
    if (empty($opening_time)) {
        $errors[] = 'Пожалуйста, укажите время вскрытия';
    }
    
    if (empty($text)) {
        $errors[] = 'Пожалуйста, напишите текст отзыва';
    }
    
    if (!$consent) {
        $errors[] = 'Необходимо дать согласие на обработку персональных данных';
    }
    
    // Если есть ошибки, возвращаем пользователя обратно
    if (!empty($errors)) {
        $error_message = implode('<br>', $errors);
        wp_die($error_message . '<br><br><a href="' . wp_get_referer() . '">Вернуться назад</a>', 'Ошибка валидации', array('back_link' => true));
        return;
    }
    
    // Обработка загруженного изображения
    $photo_id = null;
    if (!empty($_FILES['review_photo']) && $_FILES['review_photo']['error'] === UPLOAD_ERR_OK) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $upload = wp_handle_upload($_FILES['review_photo'], array('test_form' => false));
        
        if (!isset($upload['error'])) {
            $attachment = array(
                'post_mime_type' => $upload['type'],
                'post_title' => sanitize_file_name(pathinfo($upload['file'], PATHINFO_FILENAME)),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $photo_id = wp_insert_attachment($attachment, $upload['file']);
            if ($photo_id) {
                $attach_data = wp_generate_attachment_metadata($photo_id, $upload['file']);
                wp_update_attachment_metadata($photo_id, $attach_data);
            }
        }
    }
    
    // Создаем пост отзыва (черновик, чтобы администратор мог проверить перед публикацией)
    $review_id = wp_insert_post(array(
        'post_title' => $name . ' - ' . date('d.m.Y'),
        'post_content' => $text,
        'post_status' => 'pending', // Черновик, требует модерации
        'post_type' => 'review',
        'post_author' => 1,
    ));
    
    if ($review_id && !is_wp_error($review_id)) {
        // Сохраняем мета-поля ACF
        update_field('car_brand', $car_brand, $review_id);
        update_field('opening_time', $opening_time, $review_id);
        
        // Прикрепляем изображение, если оно было загружено
        if ($photo_id) {
            set_post_thumbnail($review_id, $photo_id);
        }
        
        // Получаем email для отправки уведомления
        $admin_email = get_field('callback_email', 'option');
        if (empty($admin_email)) {
            $admin_email = get_option('admin_email');
        }
        
        // Формируем тему письма
        $subject = 'Новый отзыв на сайте ' . get_bloginfo('name');
        
        // Формируем тело письма
        $body = "Поступил новый отзыв:\n\n";
        $body .= "Имя: " . $name . "\n";
        $body .= "Email: " . $email . "\n";
        $body .= "Марка автомобиля: " . $car_brand . "\n";
        $body .= "Время вскрытия: " . $opening_time . "\n";
        $body .= "Текст отзыва:\n" . $text . "\n";
        if ($photo_id) {
            $photo_url = wp_get_attachment_url($photo_id);
            $body .= "\nФотография: " . $photo_url . "\n";
        }
        $body .= "\n---\n";
        $body .= "Дата: " . date('d.m.Y H:i:s') . "\n";
        $body .= "IP адрес: " . $_SERVER['REMOTE_ADDR'] . "\n";
        $body .= "\nСсылка на отзыв в админ-панели: " . admin_url('post.php?post=' . $review_id . '&action=edit') . "\n";
        
        // Заголовки письма
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
            'Reply-To: ' . $name . ' <' . $email . '>',
        );
        
        // Отправляем письмо
        $sent = wp_mail($admin_email, $subject, $body, $headers);
        
        // Редирект с сообщением об успехе
        $redirect_url = add_query_arg('review_submitted', '1', wp_get_referer() ?: home_url());
        wp_redirect($redirect_url);
        exit;
    } else {
        wp_die('Ошибка при сохранении отзыва. Пожалуйста, попробуйте позже.', 'Ошибка', array('back_link' => true));
    }
}
add_action('admin_post_submit_review', 'zamok01_handle_review_submit');
add_action('admin_post_nopriv_submit_review', 'zamok01_handle_review_submit');

// Добавление страницы с инструкцией в админ-панель
function zamok01_add_instructions_page() {
    add_menu_page(
        'Инструкция по наполнению',
        'Инструкция',
        'edit_posts',
        'zamok01-instructions',
        'zamok01_display_instructions',
        'dashicons-book-alt',
        30
    );
}
add_action('admin_menu', 'zamok01_add_instructions_page');

// Функция для отображения инструкции
function zamok01_display_instructions() {
    $instructions_file = get_template_directory() . '/../ИНСТРУКЦИЯ_ПО_НАПОЛНЕНИЮ.md';
    
    if (!file_exists($instructions_file)) {
        $instructions_file = ABSPATH . 'ИНСТРУКЦИЯ_ПО_НАПОЛНЕНИЮ.md';
    }
    
    $content = '';
    if (file_exists($instructions_file)) {
        $content = file_get_contents($instructions_file);
    } else {
        $content = '# Инструкция по наполнению сайта Zamok01

Инструкция не найдена. Убедитесь, что файл `ИНСТРУКЦИЯ_ПО_НАПОЛНЕНИЮ.md` находится в корне темы или корне WordPress.';
    }
    
    // Конвертация Markdown в HTML (упрощенная версия)
    $html = zamok01_markdown_to_html($content);
    
    ?>
    <div class="wrap zamok01-instructions">
        <h1>Инструкция по наполнению сайта Zamok01</h1>
        <div class="zamok01-instructions-content">
            <?php echo $html; ?>
        </div>
        <style>
            .zamok01-instructions-content {
                max-width: 1200px;
                background: #fff;
                padding: 20px;
                margin-top: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .zamok01-instructions-content h1 {
                font-size: 2em;
                margin-top: 0;
                padding-bottom: 10px;
                border-bottom: 2px solid #2271b1;
            }
            .zamok01-instructions-content h2 {
                font-size: 1.5em;
                margin-top: 30px;
                margin-bottom: 15px;
                color: #2271b1;
                padding-top: 10px;
                border-top: 1px solid #eee;
            }
            .zamok01-instructions-content h3 {
                font-size: 1.3em;
                margin-top: 25px;
                margin-bottom: 12px;
                color: #135e96;
            }
            .zamok01-instructions-content h4 {
                font-size: 1.1em;
                margin-top: 20px;
                margin-bottom: 10px;
                color: #135e96;
            }
            .zamok01-instructions-content h5 {
                font-size: 1em;
                margin-top: 15px;
                margin-bottom: 8px;
                color: #135e96;
            }
            .zamok01-instructions-content p {
                line-height: 1.6;
                margin-bottom: 15px;
            }
            .zamok01-instructions-content ul,
            .zamok01-instructions-content ol {
                margin-left: 30px;
                margin-bottom: 15px;
                line-height: 1.6;
            }
            .zamok01-instructions-content li {
                margin-bottom: 8px;
            }
            .zamok01-instructions-content code {
                background: #f0f0f1;
                padding: 2px 6px;
                border-radius: 3px;
                font-family: Consolas, Monaco, monospace;
                font-size: 0.9em;
            }
            .zamok01-instructions-content pre {
                background: #f0f0f1;
                padding: 15px;
                border-radius: 5px;
                overflow-x: auto;
                margin-bottom: 15px;
            }
            .zamok01-instructions-content pre code {
                background: none;
                padding: 0;
            }
            .zamok01-instructions-content hr {
                border: none;
                border-top: 2px solid #eee;
                margin: 30px 0;
            }
            .zamok01-instructions-content strong {
                font-weight: 600;
                color: #1d2327;
            }
            .zamok01-instructions-content a {
                color: #2271b1;
                text-decoration: none;
            }
            .zamok01-instructions-content a:hover {
                text-decoration: underline;
            }
            .zamok01-instructions-content blockquote {
                border-left: 4px solid #2271b1;
                padding-left: 15px;
                margin-left: 0;
                color: #646970;
                font-style: italic;
            }
            .zamok01-instructions-content table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            .zamok01-instructions-content table th,
            .zamok01-instructions-content table td {
                padding: 10px;
                border: 1px solid #ddd;
                text-align: left;
            }
            .zamok01-instructions-content table th {
                background: #f0f0f1;
                font-weight: 600;
            }
        </style>
    </div>
    <?php
}

// Упрощенная функция конвертации Markdown в HTML
function zamok01_markdown_to_html($markdown) {
    $html = $markdown;
    
    // Заголовки
    $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $html);
    $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^#### (.+)$/m', '<h4>$1</h4>', $html);
    $html = preg_replace('/^##### (.+)$/m', '<h5>$1</h5>', $html);
    $html = preg_replace('/^###### (.+)$/m', '<h6>$1</h6>', $html);
    
    // Горизонтальная линия
    $html = preg_replace('/^---$/m', '<hr>', $html);
    
    // Жирный текст
    $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
    $html = preg_replace('/__(.+?)__/', '<strong>$1</strong>', $html);
    
    // Курсив
    $html = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $html);
    $html = preg_replace('/_(.+?)_/', '<em>$1</em>', $html);
    
    // Ссылки [текст](url)
    $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2">$1</a>', $html);
    
    // Inline код
    $html = preg_replace('/`([^`]+)`/', '<code>$1</code>', $html);
    
    // Блочный код (упрощенно)
    $html = preg_replace('/```([\s\S]*?)```/', '<pre><code>$1</code></pre>', $html);
    
    // Списки (упрощенно)
    $lines = explode("\n", $html);
    $in_list = false;
    $list_type = '';
    $result = array();
    
    foreach ($lines as $line) {
        if (preg_match('/^[\s]*[-*+]\s(.+)$/', $line, $matches)) {
            if (!$in_list || $list_type !== 'ul') {
                if ($in_list) {
                    $result[] = '</' . $list_type . '>';
                }
                $result[] = '<ul>';
                $in_list = true;
                $list_type = 'ul';
            }
            $result[] = '<li>' . trim($matches[1]) . '</li>';
        } elseif (preg_match('/^[\s]*\d+\.\s(.+)$/', $line, $matches)) {
            if (!$in_list || $list_type !== 'ol') {
                if ($in_list) {
                    $result[] = '</' . $list_type . '>';
                }
                $result[] = '<ol>';
                $in_list = true;
                $list_type = 'ol';
            }
            $result[] = '<li>' . trim($matches[1]) . '</li>';
        } else {
            if ($in_list) {
                $result[] = '</' . $list_type . '>';
                $in_list = false;
                $list_type = '';
            }
            if (trim($line) !== '' && !preg_match('/^<h[1-6]>/', trim($line)) && !preg_match('/^<hr>/', trim($line)) && !preg_match('/^<pre>/', trim($line))) {
                $result[] = '<p>' . $line . '</p>';
            } else {
                $result[] = $line;
            }
        }
    }
    
    if ($in_list) {
        $result[] = '</' . $list_type . '>';
    }
    
    $html = implode("\n", $result);
    
    // Убираем пустые параграфы
    $html = preg_replace('/<p>\s*<\/p>/', '', $html);
    
    // Очистка лишних тегов параграфов вокруг заголовков
    $html = preg_replace('/<p>(<h[1-6]>.*<\/h[1-6]>)<\/p>/', '$1', $html);
    $html = preg_replace('/<p>(<hr>)<\/p>/', '$1', $html);
    
    return $html;
}

// Временная функция для импорта отзывов из текста
function zamok01_import_reviews() {
    if (!current_user_can('manage_options')) {
        wp_die('У вас нет прав для выполнения этого действия.');
    }
    
    // Проверяем, была ли нажата кнопка импорта
    if (isset($_POST['import_reviews']) && check_admin_referer('zamok01_import_reviews')) {
        $reviews_text = isset($_POST['reviews_text']) ? $_POST['reviews_text'] : '';
        
        if (empty($reviews_text)) {
            wp_die('Текст отзывов не может быть пустым. <a href="' . admin_url('tools.php?page=zamok01-import-reviews') . '">Вернуться назад</a>', 'Ошибка', array('back_link' => true));
        }
        
        // Парсим отзывы
        $reviews = zamok01_parse_reviews_text($reviews_text);
        
        // Отладочный вывод
        $debug_info = '<h3>Отладочная информация:</h3>';
        $debug_info .= '<p>Найдено отзывов: ' . count($reviews) . '</p>';
        $debug_info .= '<pre style="background: #f0f0f0; padding: 15px; max-height: 400px; overflow-y: auto;">';
        $debug_info .= 'Массив отзывов:' . "\n";
        $debug_info .= print_r($reviews, true);
        $debug_info .= '</pre>';
        
        $created = 0;
        $skipped = 0;
        $errors = array();
        
        foreach ($reviews as $review_data) {
            // Проверяем, не существует ли уже отзыв с таким именем и датой
            $post_date = sprintf(
                '%04d-%02d-%02d',
                $review_data['date']['year'],
                $review_data['date']['month'],
                $review_data['date']['day']
            );
            
            // Проверяем по имени и дате
            $existing = get_posts(array(
                'post_type' => 'review',
                'post_status' => 'any',
                'posts_per_page' => 1,
                'title' => $review_data['name'],
                'date_query' => array(
                    array(
                        'year' => $review_data['date']['year'],
                        'month' => $review_data['date']['month'],
                        'day' => $review_data['date']['day'],
                    ),
                ),
            ));
            
            if (!empty($existing)) {
                $skipped++;
                continue;
            }
            
            // Формируем дату для WordPress
            $post_date = sprintf(
                '%04d-%02d-%02d %02d:%02d:%02d',
                $review_data['date']['year'],
                $review_data['date']['month'],
                $review_data['date']['day'],
                12, 0, 0
            );
            
            // Создаем пост отзыва
            $review_id = wp_insert_post(array(
                'post_title' => $review_data['name'],
                'post_content' => $review_data['text'],
                'post_status' => 'publish',
                'post_type' => 'review',
                'post_date' => $post_date,
                'post_date_gmt' => get_gmt_from_date($post_date),
            ));
            
            if ($review_id && !is_wp_error($review_id)) {
                // Сохраняем ACF поля (даже если пустые)
                update_field('car_brand', $review_data['car_brand'], $review_id);
                update_field('opening_time', $review_data['opening_time'], $review_id);
                
                $created++;
            } else {
                $error_msg = 'Ошибка при создании отзыва: ' . $review_data['name'];
                if (is_wp_error($review_id)) {
                    $error_msg .= ' - ' . $review_id->get_error_message();
                }
                $errors[] = $error_msg;
            }
        }
        
        $message = "Импорт завершен!<br>";
        $message .= $debug_info;
        $message .= "<br>Создано отзывов: {$created}<br>";
        if ($skipped > 0) {
            $message .= "Пропущено (уже существуют): {$skipped}<br>";
        }
        if (!empty($errors)) {
            $message .= "<br>Ошибки:<br>" . implode("<br>", $errors);
        }
        
        wp_die($message . '<br><br><a href="' . admin_url('edit.php?post_type=review') . '">Посмотреть все отзывы</a> | <a href="' . admin_url('tools.php?page=zamok01-import-reviews') . '">Вернуться к импорту</a>', 'Импорт завершен', array('back_link' => true));
    }
    
    // Отображаем форму импорта
    ?>
    <div class="wrap">
        <h1>Импорт отзывов</h1>
        <div class="card" style="max-width: 800px;">
            <h2>Добавить отзывы из текста</h2>
            <p>Вставьте текст с отзывами в поле ниже и нажмите "Импортировать".</p>
            <form method="post" action="">
                <?php wp_nonce_field('zamok01_import_reviews'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="reviews_text">Текст отзывов</label>
                        </th>
                        <td>
                            <textarea id="reviews_text" name="reviews_text" rows="30" style="width: 100%; font-family: monospace;" required><?php 
                                // Предзаполняем текст отзывами по умолчанию
                                echo esc_textarea('17.06.2020 Елена

Марка автомобиля: Mercedes

Время вскрытия: 2 минуты

Вежливое общение оператора. Оперативный выезд. Быстрая и аккуратная работа. Спасибо!

13.01.2020 Дарья

Марка автомобиля: Nissan

Время вскрытия: 30 секунд

Волшебное спасение севшего аккумулятора! Очень оперативно спасли меня, вернув мне работающую машину и сохранив планы на день! Очень рекомендую всем!

23.11.2019 Павел

Марка автомобиля: Ford Explorer

Время вскрытия: 2 мин.

Отличное бюро! Рекомендую. Два дня искал специалиста, который без повреждений вскроет замок моего авто с умершим аккумулятором. Главный критерий был, чтобы не кинули на деньги, как пишут о других компаниях! Приехал квалифицированный специалист Игорь Евгеньевич, деликатнейшим образом вскрыл замок и помог демонтировать прикипевший аккумулятор! Квалифицированный специалист! Буду рекомендовать эту компанию всем. Цена невысокая, отношение к делу профессиональное. Еще моё доверие купило то, что компания или сам специалист имеет непосредственное отношение к АССОСОД. В общем, обращайтесь, не пожалеете. Еще и совет дадут, как впредь не попадать в подобную ситуацию.

10.11.2019 Виктор

Марка автомобиля: Мерседес МЛ

Время вскрытия: 2 мин

За услугу вскрыть и прикурить машину с меня взяли 2000 рублей! В других фирмах цена была от 3500 и выше. Большое вам спасибо!

19.06.2019 Александр

Марка автомобиля: Mercedes Benz Ml w166

Время вскрытия: 2 мин

Все выполнено профессионально и очень очень быстро ,спасибо огромное за помощь!

2.02.2019 Виталий

Марка автомобиля: Тойота.Ауди

Время вскрытия:

Большое спасибо за быструю и профессиональную помощь

Тойоту-прикурили

Ауди вскрыли.

30.12.2018 Алексей

Марка автомобиля: Opel

Время вскрытия: 2 минуты

На Опеле сел акб заблокировались двери случайно ключ оказался внутри машины. Приехали через 35 минут. Открыли двери за 2 минуты без царапин и повреждений. Даже не успел заметить как. Просто Профи. Огромное спасибо.

03.08.2018 Артем

Марка автомобиля: VW

Время вскрытия: меньше минуты

Спасибо Игорю Евгеньевичу за профессионализм! ко мне приезжали две конторы которые пробовали вскрыть мой VW. У них получилось только испортить мне салон проволокой, а он меньше минуты открыл личинку СПАСИБО ❗️❗️❗️❗️❗️

23.05.2018 Anatoliy

Столкнулся с необходимостью открыть машину без ключа. Машина Шкода Октавия. Ключ положил в багажник и закрыл его. Вызвал специалистов, которые, как оказалось, не знают как открыть Шкоду. Целый час они прыгали вокруг автомобиля. Отогнули дверь, дёргали за ручки, нажимали кнопки. Отчаявшись, стал искать другую фирму. Позвонил в Замок 01. Приехал Игорь Евгеньевич и открыл замок машины за ДВЕ минуты! Сожалею, что не сразу позвонил в вашу компанию. Спасибо вам большое.

15.12.2017 Юрий

Вызывал мастера открыть сейф AIKO. Не было ни ключа ни кода. Приехал мастер Николай, как и обещал, открыл замки сейфа без сверления и сделал сразу ключи. Большое спасибо за вашу профессиональную работу.

28.08.2017 Василий

Спасибо Игорю Евгеньевичу. Приехал и меньше чем за 5 минут открыл мою машину. Был утерян ключ, в машину было не попасть. Спасибо.

08.08.2017 Николай Быстров

Добрый день! Хочу выразить благодарность Игорю, который 30 июля достаточно оперативно подъехал в подмосковный город Серебряные Пруды и открыл дверь нашего автомобиля, ключи от которого остались закрыты в багажнике. Конечно услуги мне показались несколько дороговаты)), но когда с тобой рядом трое детей, а уехать не можешь, а до Москвы 160км... Спасибо.

22.02.2016 Владимир

Сел аккумулятор полностью, машина проводами не прикуривалась, ребята оперативно приехали с пускачём и оперативно завели.

Спасибо!

27.10.2015 Елена Викторовна

Большое спасибо Вашей компании, а особенно мастеру Алексею за помощь в открывании двери. Приехал он очень быстро и открыл нам дверь не ломая замка. Умница. Ещё раз Спасибо.

12.07.2014 Виктор Владимирович

Случилось неприятность с моим авто. Положил ключи в багажник и захлопнул крышку. Машина Пассат В6. Вызвал из фирмы, которые обещали приехать через 15 минут, и в итоге прождал их 2 часа. А парень из этой компании Замок 01 приехал в Балашиху действительно на мотоцикле через 20 минут, и за 5 минут открыл машину.

Огромное Спасибо.

9.03.2014 Лариса

Больше спасибо за помощь!

Обратилась по поводу несложной, но очень неприятной проблемы с машиной: она не заводилась. Ребята подошли к решению неформально, гибко и за разумную плату. Теперь я знаю телефон "скорой помощи" для своей машины:)

7.03.2014 Сергей

Выражаю своё восхищение мастерством ваших сотрудников. Оставил ключи внутри машины, Мерседес бронированный. Сначала позвонил в другую фирму, Приехали какие-то странные люди на машине с белорусскими номерами и пытались отогнуть бронированную дверь. потратили кучу времени, и как потом оказалось, ободрали краску на двери и стойке машины. Потом позвонил в вашу компанию. Мастер приехал через 40 минут, и открыл замок на двери машины за 5 - 7 минут. Хорошо что есть настоящие мастера своего дела, Спасибо.

9.02.2014 Сергей

Вчера оставил ключи в багажнике своего Фольксвагена. Ваш мастер приехал через десять минут. Но скорость вскрытия машины просто поразила - три минуты! Большое спасибо за ваше мастерство.

1.10.2013 Михаил

Год назад обращался летом в эту службу, не открывался замок гаража. Мастер быстро приехал на мотоцикле, как на фотографии. С помощью специального устройства просмотрел внутрь замка (замок с другой стороны двери, ключ большой, с двумя бороздками), сказал, что произошло проворачивание ключа на полоборота, из-за этого замок не открывается и ключ правильно вставить не получится. И в течение нескольких минут, моим же ключом открыл замок. Очень дружелюбно, быстро и недорого. Теперь регулярно бываю на вашем сайте. Спасибо.

10.08.2013 Ольга

Огромное спасибо ребятам за их работу. Я забыла ключи в багажнике своей машины, у меня купе БМВ. Сначала вызвала другую компанию, они целый час пытались её открыть, что только не делали. В итоге уехали. А ваш мастер открыл замок всего за две минуты. Сразу видно профессионала.

Очень довольна.');
                            ?></textarea>
                            <p class="description">Вставьте текст с отзывами. Каждый отзыв должен начинаться с даты в формате ДД.ММ.ГГГГ, затем имя, затем информация об автомобиле и текст отзыва.</p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="import_reviews" class="button button-primary" value="Импортировать отзывы">
                </p>
            </form>
        </div>
    </div>
    <?php
}

// Функция для парсинга текста с отзывами
function zamok01_parse_reviews_text($text) {
    $reviews = array();
    
    // Разбиваем текст на блоки - ищем даты в формате ДД.ММ.ГГГГ
    // Разбиваем по паттерну: дата в начале строки
    $blocks = preg_split('/(?=\d{1,2}\.\d{1,2}\.\d{4})/', $text);
    
    // Удаляем пустые блоки
    $blocks = array_filter($blocks, function($block) {
        return !empty(trim($block));
    });
    
    foreach ($blocks as $block) {
        $block = trim($block);
        if (empty($block)) {
            continue;
        }
        
        $lines = explode("\n", $block);
        $review = array(
            'date' => null,
            'name' => '',
            'car_brand' => '',
            'opening_time' => '',
            'text' => '',
        );
        
        $found_date = false;
        $found_name = false;
        $text_started = false;
        $text_lines = array();
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            
            // Пропускаем строки с ответами и названиями компаний
            if (stripos($line, 'Ответ:') !== false || 
                stripos($line, 'Замок 01') !== false || 
                stripos($line, 'Zamok01') !== false ||
                (stripos($line, 'Служба') !== false && stripos($line, 'Замок') !== false)) {
                break; // Конец отзыва
            }
            
            // Ищем дату в формате ДД.ММ.ГГГГ
            if (!$found_date && preg_match('/^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(.+)$/', $line, $date_matches)) {
                $review['date'] = array(
                    'day' => intval($date_matches[1]),
                    'month' => intval($date_matches[2]),
                    'year' => intval($date_matches[3]),
                );
                // Имя может быть на той же строке после даты
                if (!empty($date_matches[4])) {
                    $review['name'] = trim($date_matches[4]);
                    $found_name = true;
                }
                $found_date = true;
                continue;
            }
            
            // Если дата найдена, следующая непустая строка - имя
            if ($found_date && !$found_name) {
                $review['name'] = $line;
                $found_name = true;
                continue;
            }
            
            // Парсим марку автомобиля
            if (stripos($line, 'Марка автомобиля:') !== false) {
                $car_brand = trim(str_ireplace('Марка автомобиля:', '', $line));
                if (!empty($car_brand)) {
                    $review['car_brand'] = $car_brand;
                }
                continue;
            }
            
            // Парсим время вскрытия
            if (stripos($line, 'Время вскрытия:') !== false) {
                $opening_time = trim(str_ireplace('Время вскрытия:', '', $line));
                if (!empty($opening_time)) {
                    $review['opening_time'] = $opening_time;
                }
                continue;
            }
            
            // Если имя найдено, остальное - текст отзыва
            // Но обрезаем при встрече "Ответ:"
            if ($found_name) {
                // Проверяем, не начинается ли строка с "Ответ:"
                if (stripos($line, 'Ответ:') === 0) {
                    break; // Конец отзыва, дальше идет ответ
                }
                $text_lines[] = $line;
            }
        }
        
        // Формируем текст отзыва
        if (!empty($text_lines)) {
            $review['text'] = trim(implode("\n", $text_lines));
        }
        
        // Добавляем отзыв, если есть хотя бы дата и имя
        if ($review['date'] !== null && !empty($review['name'])) {
            $reviews[] = $review;
        }
    }
    
    return $reviews;
}


// Автоматическая замена всех заглавных букв в именах файлов на строчные
function replace_uppercase_filenames($content) {
    // Ищем все URL с изображениями и заменяем имена файлов на lowercase
    $content = preg_replace_callback(
        '/(https?:\/\/[^\"\s>]+?\/([^\/]+\/)*)([^\/\?\"\s>]+?\.(jpg|jpeg|png|gif|webp))/i',
        function($matches) {
            $base_url = $matches[1];  // Домен и путь
            $filename = strtolower($matches[3]);  // Имя файла в нижнем регистре
            return $base_url . $filename;
        },
        $content
    );
    return $content;
}
add_filter('the_content', 'replace_uppercase_filenames');

/**
 * Преобразует URL изображения, заменяя заглавные буквы на маленькие в имени файла
 */
function zamok01_normalize_image_url($url) {
    if (empty($url)) {
        return $url;
    }
    
    // Для относительных путей добавляем базовый URL
    if (strpos($url, 'http') !== 0 && strpos($url, '//') !== 0) {
        // Относительный путь - добавляем базовый URL сайта
        $url = home_url($url);
    }
    
    // Разбиваем URL на части
    $parsed = parse_url($url);
    if (!$parsed || !isset($parsed['path'])) {
        return $url;
    }
    
    // Получаем путь и имя файла
    $path = $parsed['path'];
    $path_parts = pathinfo($path);
    
    // Преобразуем имя файла в нижний регистр
    if (isset($path_parts['basename'])) {
        $filename_lower = mb_strtolower($path_parts['basename'], 'UTF-8');
        $new_path = str_replace($path_parts['basename'], $filename_lower, $path);
        
        // Собираем URL обратно
        $new_url = '';
        if (isset($parsed['scheme'])) {
            $new_url .= $parsed['scheme'] . '://';
        }
        if (isset($parsed['host'])) {
            $new_url .= $parsed['host'];
        }
        if (isset($parsed['port'])) {
            $new_url .= ':' . $parsed['port'];
        }
        $new_url .= $new_path;
        if (isset($parsed['query'])) {
            $new_url .= '?' . $parsed['query'];
        }
        if (isset($parsed['fragment'])) {
            $new_url .= '#' . $parsed['fragment'];
        }
        
        return $new_url;
    }
    
    return $url;
}

/**
 * Устанавливает количество постов на странице для архивов
 */
function zamok01_set_archive_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_archive() || is_category() || is_tag() || is_tax() || is_post_type_archive()) {
            $query->set('posts_per_page', 12);
        }
    }
}
add_action('pre_get_posts', 'zamok01_set_archive_posts_per_page');

/**
 * Получает URL изображения из записи (миниатюра или первое изображение из контента)
 * Применяет фильтр нормализации URL (заглавные буквы в маленькие)
 */
function zamok01_get_post_image_url($post_id = null, $size = 'full', $default = '/assosod/assosod.png') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    // Сначала проверяем миниатюру
    if (has_post_thumbnail($post_id)) {
        $thumbnail_url = get_the_post_thumbnail_url($post_id, $size);
        if ($thumbnail_url) {
            return zamok01_normalize_image_url($thumbnail_url);
        }
    }
    
    // Если миниатюры нет, ищем первое изображение в контенте
    $post = get_post($post_id);
    if ($post) {
        $content = $post->post_content;
        
        // Ищем первое изображение в контенте
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches)) {
            $image_url = $matches[1];
            
            // Обрабатываем относительные URL
            if (strpos($image_url, 'http') !== 0 && strpos($image_url, '//') !== 0) {
                if (strpos($image_url, '/') === 0) {
                    $image_url = home_url($image_url);
                } else {
                    $image_url = home_url('/' . $image_url);
                }
            }
            
            // Применяем фильтр нормализации
            return zamok01_normalize_image_url($image_url);
        }
    }
    
    // Возвращаем fallback изображение с применением фильтра
    return zamok01_normalize_image_url($default);
}