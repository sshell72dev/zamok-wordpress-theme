<?php
/**
 * Template for displaying all pages
 */
get_header(); ?>

<!-- page -->
<div class="page-full">

    <?php zamok01_breadcrumbs(); ?>

    <!--title-box-->
    <div class="title-box">
        <div class="title-wrap">
            <h1 class="h1-title section-title"><?php the_title(); ?></h1>
        </div>
    </div>
    <!--/title-box-->


    <!--info-box-->
    <div class="info-box">
        <div class="items-wrap">
            <?php
            $info_items = get_field('info_items');
            if ($info_items):
                foreach ($info_items as $item):
            ?>
            <!--item wrap-->
            <div class="item-wrap">
                <div class="item-tile-info">
                    <?php if ($item['icon']): ?>
                    <div class="elm-ico">
                        <img src="<?php echo esc_url($item['icon']['url']); ?>" alt="<?php echo esc_attr($item['icon']['alt']); ?>">
                    </div>
                    <?php else: ?>
                    <div class="tile-title"><?php echo esc_html($item['title']); ?></div>
                    <?php endif; ?>
                    <div class="tile-info"><?php echo esc_html($item['text']); ?></div>
                </div>
            </div>
            <!--/item wrap-->
            <?php
                endforeach;
            endif;
            ?>
        </div>
        <?php if (get_field('article_content')): ?>
        <div class="article-inner-wrap">
            <?php echo wp_kses_post(get_field('article_content')); ?>
        </div>
        <?php endif; ?>
        <!--article-box-->
    <div class="article-box">
        <?php if(has_post_thumbnail()) : ?>
        <div class="elm-photo">
            <?php the_post_thumbnail('large', array('style' => 'max-width: 100%; height: auto;')); ?>
        </div>
        <?php endif; ?>
        
        <?php if (get_the_content()) : ?>
        <div class="article-content">
            <?php the_content(); ?>
        </div>
        <?php endif; ?>
    </div>
    <!--/article-box-->
    </div>
    <!--/info-box-->

    <?php
    // Проверяем, является ли страница /vskrytie-avtomobiley/ или дочерней
    $current_page_id = get_the_ID();
    $is_vskrytie_page = false;
    
    // Проверяем slug текущей страницы
    $current_slug = get_post_field('post_name', $current_page_id);
    if ($current_slug === 'vskrytie-avtomobiley') {
        $is_vskrytie_page = true;
    } else {
        // Проверяем, является ли страница дочерней для /vskrytie-avtomobiley/
        $parent_page = get_page_by_path('vskrytie-avtomobiley');
        if ($parent_page) {
            $ancestors = get_post_ancestors($current_page_id);
            if (in_array($parent_page->ID, $ancestors) || $current_page_id == $parent_page->ID) {
                $is_vskrytie_page = true;
            }
        }
    }
    
    // Выводим блок ссылок только для страниц /vskrytie-avtomobiley/ или дочерних
    if ($is_vskrytie_page):
    ?>
    <noindex>
    <div class="article-content" style="margin-top: 30px;margin-bottom: 70px;">
        <p>
            <a href="/vskrytie-bagazhnika/">Вскрытие багажника</a><br />
            <a href="/vskrytie-avto-blokiratorov/">Снятие блокираторов</a><br />
            <a href="/otklyuchenie-signalizaciy/">Отключение сигнализации</a><br />
            <a href="/vskrytie-garahzej/">Вскрытие гаражей</a><br />
            <a href="/tehpomosh-na-dorogah/prikurit-sel-akkumulyator/">Услуга прикурить автомобиль</a><br />
            <a href="/dostavka-topliva-benzina-dizelya/">Подвоз бензина, дизеля</a>
        </p>

        <p>
            <strong><a href="/vskrytie-avtomobiley/">Вскрытие автомобилей</a></strong><br />
            <strong>По маркам: </strong><br />
            <a href="/vskrytie-avtomobiley/audi/">Audi</a> | 
            <a href="/vskrytie-avtomobiley/bmw/">BMW</a> | 
            <a href="/vskrytie-avtomobiley/changan-qiyuan-a07/">Changan</a> | 
            <a href="/vskrytie-avtomobiley/chevrolet/">Chevrolet</a> | 
            <a href="/vskrytie-avtomobiley/ford/">Ford</a> | 
            <a href="/vskrytie-avtomobiley/honda/">Honda</a> | 
            <a href="/vskrytie-avtomobiley/hyundai/">Hyundai</a> | 
            <a href="/vskrytie-avtomobiley/infinity/">Infinity</a> | 
            <a href="/vskrytie-avtomobiley/kia/">KIA</a> | 
            <a href="/vskrytie-avtomobiley/lamborghini/">Lamborghini</a> | 
            <a href="/vskrytie-avtomobiley/land-rover-range-rover/">Land Rover</a> | 
            <a href="/vskrytie-avtomobiley/mercedes-benz/">Mercedes</a> | 
            <a href="/vskrytie-avtomobiley/mitsubishi/">Mitsubishi</a> | 
            <a href="/vskrytie-avtomobiley/nissan/">Nissan</a> | 
            <a href="/vskrytie-avtomobiley/opel/">OPEL</a> | 
            <a href="/vskrytie-avtomobiley/porsche/">Porsche</a> | 
            <a href="/vskrytie-avtomobiley/land-rover-range-rover/">Range Rover</a> | 
            <a href="/vskrytie-avtomobiley/renault/">Renault</a> | 
            <a href="/vskrytie-avtomobiley/rolls-royce/">Rolls-Royce</a> | 
            <a href="/vskrytie-avtomobiley/shkoda/">Skoda</a> | 
            <a href="/vskrytie-avtomobiley/suzuki/">Suzuki</a> | 
            <a href="/vskrytie-avtomobiley/tesla/">Tesla</a> | 
            <a href="/vskrytie-avtomobiley/toyota/">Toyota</a> | 
            <a href="/vskrytie-avtomobiley/volkswagen/">Volkswagen</a> | 
            <a href="/vskrytie-avtomobiley/volvo/">Volvo</a>
        </p>
    </div>
    </noindex>
    <?php endif; ?>

    <?php
    // Проверяем, является ли страница /vskrytie-seyfov/ или дочерней
    $is_seyfov_page = false;
    
    // Проверяем slug текущей страницы
    if ($current_slug === 'vskrytie-seyfov') {
        $is_seyfov_page = true;
    } else {
        // Проверяем, является ли страница дочерней для /vskrytie-seyfov/
        $parent_seyfov_page = get_page_by_path('vskrytie-seyfov');
        if ($parent_seyfov_page) {
            $ancestors = get_post_ancestors($current_page_id);
            if (in_array($parent_seyfov_page->ID, $ancestors) || $current_page_id == $parent_seyfov_page->ID) {
                $is_seyfov_page = true;
            }
        }
    }
    
    // Выводим содержимое safe_type.txt только для страниц /vskrytie-seyfov/ или дочерних
    if ($is_seyfov_page):
        $safe_type_file = get_template_directory() . '/../safe_type.txt';
        if (file_exists($safe_type_file)):
            echo file_get_contents($safe_type_file);
            echo '<div style="clear: both;"></div>';
        endif;
    endif;
    ?>

    <?php
    // Проверяем, является ли страница /vskrytie-zamkov-podmoskovye/ или дочерней
    $is_podmoskovye_page = false;
    
    // Проверяем slug текущей страницы
    if ($current_slug === 'vskrytie-zamkov-podmoskovye') {
        $is_podmoskovye_page = true;
    } else {
        // Проверяем, является ли страница дочерней для /vskrytie-zamkov-podmoskovye/
        $parent_podmoskovye_page = get_page_by_path('vskrytie-zamkov-podmoskovye');
        if ($parent_podmoskovye_page) {
            $ancestors = get_post_ancestors($current_page_id);
            if (in_array($parent_podmoskovye_page->ID, $ancestors) || $current_page_id == $parent_podmoskovye_page->ID) {
                $is_podmoskovye_page = true;
            }
        }
    }
    
    // Выводим блок ссылок на города Подмосковья только для страниц /vskrytie-zamkov-podmoskovye/ или дочерних
    if ($is_podmoskovye_page):
    ?>
    <p style="font-family: 'Open Sans'; font-weight: 400; font-size: 16pt; line-height: 27px; margin: 0 0 70px; word-wrap: break-word;">
        <a href="/vskrytie-zamkov-podmoskovye/aprelevka/">Апрелевка</a> | <a href="/vskrytie-zamkov-podmoskovye/vnukovo/">Аэропорт Внуково</a> | <a href="/vskrytie-zamkov-podmoskovye/aeroport-domodedovo/">Аэропорт Домодедово</a> | <a href="/vskrytie-zamkov-podmoskovye/sheremetyevo/">Аэропорт Шереметьево</a> | <a href="/vskrytie-zamkov-podmoskovye/balashiha/">Балашиха</a> | <a href="/vskrytie-zamkov-podmoskovye/bronnicy/">Бронницы</a> | <a href="/vskrytie-zamkov-podmoskovye/zhulebino/">Выхино</a> | <a href="/vskrytie-zamkov-podmoskovye/dzerzhinskiy/">Дзержинский</a> | <a href="/vskrytie-zamkov-podmoskovye/dmitrov/">Дмитров</a> | <a href="/vskrytie-zamkov-podmoskovye/zheleznodorozhnyj/">Железнодорожный</a> | <a href="/vskrytie-zamkov-podmoskovye/zhukovskiy/">Жуковский</a> | <a href="https://zhulebino.zamok01.ru/">Жулебино</a> | <a href="/vskrytie-zamkov-podmoskovye/zelenograd/">Зеленоград</a> | <a href="/vskrytie-zamkov-podmoskovye/ivanteevka/">Ивантеевка</a> | Кашира | Климовск | <a href="/vskrytie-zamkov-podmoskovye/klin/">Клин</a> | <a href="/vskrytie-zamkov-podmoskovye/kolomna/">Коломна</a> | <a href="/vskrytie-zamkov-podmoskovye/korolev/">Королёв</a> | <a href="/vskrytie-zamkov-podmoskovye/kotelniki/">Котельники</a> | <a href="/vskrytie-zamkov-podmoskovye/krasnogorsk/">Красногорск</a> | <a href="/vskrytie-zamkov-podmoskovye/lobnya/">Лобня</a> | <a href="/vskrytie-zamkov-podmoskovye/lytkarino/">Лыткарино</a> | <a href="https://lyubercy.zamok01.ru/">Люберцы</a> | <a href="/vskrytie-zamkov-podmoskovye/mytishi/">Мытищи</a> | <a href="/vskrytie-zamkov-podmoskovye/naro-fominsk/">Наро-Фоминск</a> | <a href="/vskrytie-zamkov-podmoskovye/odincovo/">Одинцово</a> | <a href="/vskrytie-zamkov-podmoskovye/podolsk/">Подольск</a> | <a href="/vskrytie-zamkov-podmoskovye/pushkino/">Пушкино</a> | <a href="/vskrytie-zamkov-podmoskovye/reutov/">Реутов</a> | <a href="/vskrytie-zamkov-podmoskovye/ramenskoe/">Раменское</a> | Сергиев Посад | Серпухов | <a href="/vskrytie-zamkov-podmoskovye/solnechnogorsk/">Солнечногорск</a> | <a href="/vskrytie-zamkov-podmoskovye/sofrino/">Софрино</a> | Ступино | Троицк | <a href="/vskrytie-zamkov-podmoskovye/vaskrytie-avto-v-chehove/">Чехов</a> | <a href="/vskrytie-zamkov-podmoskovye/vaskrytie-avto-v-schelcovo/">Щелково</a> | <a href="/vskrytie-zamkov-podmoskovye/himki/">Химки</a> | <a href="/vskrytie-zamkov-podmoskovye/elektrostal/">Электросталь</a> | 
    </p>
    <?php endif; ?>

    <!--bg-box-->
    <div class="bg-box section-inner">
        <!--action-box-->
        <div class="action-box">
            <div class="info-inner-wrap">
                <div class="section-title h1-title title-small-d"><?php echo get_field('action_title') ?: 'Чтобы вызвать мастера открыть машину звоните по телефону'; ?></div>
                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', get_field('phone_main', 'option') ?: '+7 (495) 514-53-50'); ?>" class="btn">
                    <div class="button-title"><?php echo get_field('phone_main', 'option') ?: '+7 (495) 514-53-50'; ?></div>
                </a>
                <div class="section-title h1-title title-small-d"><?php echo get_field('action_subtitle') ?: 'приедем через 15-20 минут'; ?></div>
                <?php 
                $action_image = get_field('action_image');
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
                <div class="elm-info"><?php echo get_field('action_info') ?: 'Все работы по вскрытию автомобиля производятся при предъявлении документов на транспортное средство'; ?></div>
            </div>
        </div>
        <!--/action-box-->
    </div>
    <!--/bg-box-->

    <!--info-about-box-->
    <?php if (get_field('about_content')): ?>
    <div class="info-about-box">
        <?php 
        $about_image = get_field('about_image');
        if ($about_image):
        ?>
        <div class="elm-photo">
            <img src="<?php echo esc_url($about_image['url']); ?>" alt="<?php echo esc_attr($about_image['alt']); ?>">
        </div>
        <?php endif; ?>
        <?php echo wp_kses_post(get_field('about_content')); ?>
    </div>
    <!--/info-about-box-->
    <?php endif; ?>

    <!--title-inner-box-->
    <div class="title-inner-box">
        <div class="title-wrap">
            <h2 class="section-title h2-title title-large-d"><?php echo get_field('advantages_title') ?: 'Замок автомобиля вскрываем профессионально'; ?></h2>
            <?php if (get_field('advantages_subtitle')): ?>
            <p><?php echo esc_html(get_field('advantages_subtitle')); ?></p>
            <?php endif; ?>
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

    <!--bg-box-->
    <div class="bg-box bg-light">
        <!--title-inner-box-->
        <div class="title-inner-box">
            <div class="title-wrap">
                <h2 class="section-title h1-title title-small-d"><?php echo get_field('related_services_title') ?: 'Мы также оказываем услуги:'; ?></h2>
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

    <?php get_template_part('template-parts/faq-block', null, array('link_button_class' => 'button-white')); ?>

    <!--bg-box-->
    <div class="bg-box bg-light">
        <!--title-inner-box-->
        <div class="title-inner-box">
            <div class="title-wrap">
                <h2 class="section-title h1-title title-small-d"><?php echo get_field('articles_title') ?: 'Статьи по безопасности автомобиля:'; ?></h2>
            </div>
        </div>
        <!--/title-inner-box-->

        <!--tiles-box-->
        <div class="tiles-box">
            <div class="slider-inner-wrap slider-tiles">
                <div class="slider-wrap swiper">
                    <div class="slider swiper-wrapper">
                        <?php
                        $articles = get_posts(array(
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ));
                        if ($articles):
                            foreach ($articles as $article):
                                setup_postdata($article);
                        ?>
                        <!--item wrap-->
                        <div class="sl-wrap swiper-slide">
                            <a href="<?php echo get_permalink($article->ID); ?>" class="item-tile-article">
                                <div class="tile-photo-wrap">
                                    <div class="elm-photo photo-cover">
                                        <?php
                                        $image_url = zamok01_get_post_image_url($article->ID);
                                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title($article->ID)) . '">';
                                        ?>
                                    </div>
                                </div>
                                <div class="tile-info-wrap">
                                    <div class="tile-title"><?php echo get_the_title($article->ID); ?></div>
                                    <div class="tile-info"><?php echo get_the_excerpt($article->ID); ?></div>
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
                </div>
            </div>
            <div class="more-inner-wrap">
                <a href="/statyi/" class="btn button-white">
                    <div class="button-title">Все статьи →</div>
                </a>
            </div>
        </div>
        <!--/tiles-box-->
    </div>
    <!--/bg-box-->

</div>
<!-- /page -->

<?php get_footer(); ?>

