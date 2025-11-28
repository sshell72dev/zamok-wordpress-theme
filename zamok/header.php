<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <!-- DNS Prefetch для оптимизации -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//s.w.org">
    
    <!-- Title будет переопределен Yoast SEO если плагин активен -->
    <title><?php wp_title('|', true, 'right'); ?></title>
    
    <!-- Favicon -->
    <?php
    $favicon_32 = get_field('favicon_32', 'option');
    if (is_array($favicon_32) && isset($favicon_32['url'])) {
        $favicon_32 = $favicon_32['url'];
    }
    $favicon_192 = get_field('favicon_192', 'option');
    if (is_array($favicon_192) && isset($favicon_192['url'])) {
        $favicon_192 = $favicon_192['url'];
    }
    $favicon_180 = get_field('favicon_180', 'option');
    if (is_array($favicon_180) && isset($favicon_180['url'])) {
        $favicon_180 = $favicon_180['url'];
    }
    $favicon_270 = get_field('favicon_270', 'option');
    if (is_array($favicon_270) && isset($favicon_270['url'])) {
        $favicon_270 = $favicon_270['url'];
    }
    ?>
    <?php if ($favicon_32): ?>
    <link rel="icon" href="<?php echo esc_url($favicon_32); ?>" sizes="32x32">
    <?php endif; ?>
    <?php if ($favicon_192): ?>
    <link rel="icon" href="<?php echo esc_url($favicon_192); ?>" sizes="192x192">
    <?php endif; ?>
    <?php if ($favicon_180): ?>
    <link rel="apple-touch-icon-precomposed" href="<?php echo esc_url($favicon_180); ?>">
    <?php endif; ?>
    <?php if ($favicon_270): ?>
    <meta name="msapplication-TileImage" content="<?php echo esc_url($favicon_270); ?>">
    <?php endif; ?>
    
    <!-- Yandex Verification -->
    <?php
    $yandex_verification = get_field('yandex_verification', 'option');
    if ($yandex_verification):
    ?>
    <meta name="yandex-verification" content="<?php echo esc_attr($yandex_verification); ?>">
    <?php endif; ?>
    
    <?php 
    // Yoast SEO автоматически выводит все метатеги (title, description, keywords, Open Graph, Twitter Card, Canonical, Schema.org) через wp_head()
    wp_head(); 
    ?>
</head>
<body <?php body_class(); ?>>
    <!-- wrap -->
    <div class="wrap">
        <!-- header -->
        <header class="header">
            <div class="inner-wrap">
                <div class="logo-inner-wrap">
                    <a href="<?php echo home_url(); ?>" class="logo">
                        <img src="<?php echo zamok01_get_image_url('main/logo.svg'); ?>" alt="<?php bloginfo('name'); ?>">
                    </a>
                </div>
                <div class="mobile-panel-wrap">
                    <div class="soc-wrap">
                        <?php 
                        $vk = get_field('social_vk', 'option');
                        $wa = get_field('social_wa', 'option');
                        $tg = get_field('social_tg', 'option');
                        ?>
                        <?php if ($vk): ?>
                        <a href="<?php echo esc_url($vk); ?>" class="btn-action-ico button-soc" target="_blank">
                            <img src="<?php echo zamok01_get_image_url('icons/soc-vk.svg'); ?>" alt="VK">
                        </a>
                        <?php endif; ?>
                        <?php if ($wa): ?>
                        <a href="<?php echo esc_url($wa); ?>" class="btn-action-ico button-soc" target="_blank">
                            <img src="<?php echo zamok01_get_image_url('icons/soc-wa.svg'); ?>" alt="WhatsApp">
                        </a>
                        <?php endif; ?>
                        <?php if ($tg): ?>
                        <a href="<?php echo esc_url($tg); ?>" class="btn-action-ico button-soc" target="_blank">
                            <img src="<?php echo zamok01_get_image_url('icons/soc-tg.svg'); ?>" alt="Telegram">
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="callback-wrap">
                        <a href="" class="btn js-popup-open" data-popup="popup-callback">
                            <div class="button-title">Перезвоните мне</div>
                        </a>
                    </div>
                </div>
                <div class="menu-inner-wrap js-popup-wrap">
                    <a href="" class="btn-popup btn-action-ico ico-menu js-btn-popup-toggle"></a>
                    <div class="menu-content-block js-popup-block">
                        <div class="menu-wrap">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'main-menu',
                                'container' => false,
                                'menu_class' => 'menu',
                                'fallback_cb' => false,
                                'walker' => new Zamok01_Walker_Nav_Menu(),
                            ));
                            ?>
                        </div>
                        <div class="contacts-wrap">
                            <?php 
                            $phone = get_field('phone_main', 'option');
                            $email = get_field('email_main', 'option');
                            ?>
                            <?php if ($phone): ?>
                            <div class="cnt-wrap">
                                <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone); ?>" class="link-phone"><?php echo esc_html($phone); ?></a>
                            </div>
                            <?php endif; ?>
                            <?php if ($email): ?>
                            <div class="cnt-wrap">
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="link-email"><?php echo esc_html($email); ?></a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="soc-wrap">
                            <?php if ($vk): ?>
                            <a href="<?php echo esc_url($vk); ?>" class="btn-action-ico button-soc" target="_blank">
                                <img src="<?php echo zamok01_get_image_url('icons/soc-vk.svg'); ?>" alt="VK">
                            </a>
                            <?php endif; ?>
                            <?php if ($wa): ?>
                            <a href="<?php echo esc_url($wa); ?>" class="btn-action-ico button-soc" target="_blank">
                                <img src="<?php echo zamok01_get_image_url('icons/soc-wa.svg'); ?>" alt="WhatsApp">
                            </a>
                            <?php endif; ?>
                            <?php if ($tg): ?>
                            <a href="<?php echo esc_url($tg); ?>" class="btn-action-ico button-soc" target="_blank">
                                <img src="<?php echo zamok01_get_image_url('icons/soc-tg.svg'); ?>" alt="Telegram">
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="callback-wrap">
                            <a href="" class="btn js-popup-open" data-popup="popup-callback">
                                <div class="button-title">Перезвоните мне</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- /header -->

