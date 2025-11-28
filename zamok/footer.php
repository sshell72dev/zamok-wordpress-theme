        <!-- footer -->
        <footer class="footer">
            <div class="inner-wrap">
                <!--footer-main-panel-->
                <div class="footer-main-panel">
                    <div class="info-inner-wrap">
                        <div class="logo-wrap">
                            <a href="<?php echo home_url(); ?>" class="logo">
                                <img src="<?php echo zamok01_get_image_url('main/logo-footer.svg'); ?>" alt="<?php bloginfo('name'); ?>">
                            </a>
                        </div>
                        <div class="contacts-wrap">
                            <div class="phones-wrap">
                                <div class="footer-title">Телефоны</div>
                                <?php 
                                $phones = get_field('phones', 'option');
                                if ($phones):
                                    foreach ($phones as $phone):
                                ?>
                                <div class="phone-wrap">
                                    <a href="tel:<?php echo preg_replace('/[^0-9+]/', '', $phone['phone']); ?>" class="btn-menu"><?php echo esc_html($phone['phone']); ?></a>
                                </div>
                                <?php 
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            <div class="soc-wrap">
                                <div class="footer-title">Соцсети</div>
                                <div class="soc-buttons-wrap">
                                    <?php 
                                    $vk = get_field('social_vk', 'option');
                                    $tg = get_field('social_tg', 'option');
                                    ?>
                                    <?php if ($vk): ?>
                                    <a href="<?php echo esc_url($vk); ?>" class="btn-action-ico button-soc" target="_blank">
                                        <img src="<?php echo zamok01_get_image_url('icons/soc-vk-ico.svg'); ?>" alt="VK">
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($tg): ?>
                                    <a href="<?php echo esc_url($tg); ?>" class="btn-action-ico button-soc" target="_blank">
                                        <img src="<?php echo zamok01_get_image_url('icons/soc-tg-ico.svg'); ?>" alt="Telegram">
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="info-wrap">
                            <p><?php echo get_field('footer_info', 'option') ?: 'Работаем круглосуточно по Москве и МО <br>Время приезда мастера от 20 минут'; ?></p>
                        </div>
                    </div>
                    <div class="menu-inner-wrap">
                        <div class="menu-wrap">
                            <div class="footer-title">Наши услуги</div>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer-services',
                                'container' => false,
                                'menu_class' => 'menu',
                                'fallback_cb' => false,
                                'walker' => new Zamok01_Walker_Nav_Menu(),
                            ));
                            ?>
                        </div>
                        <div class="menu-wrap">
                            <div class="footer-title">Информация</div>
                            <?php
                            $footer_info_menu = wp_nav_menu(array(
                                'theme_location' => 'footer-info',
                                'container' => false,
                                'menu_class' => 'menu',
                                'fallback_cb' => false,
                                'walker' => new Zamok01_Walker_Nav_Menu(),
                                'echo' => false,
                            ));
                            if ($footer_info_menu) {
                                echo $footer_info_menu;
                            } else {
                                echo '<ul class="menu"></ul>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="shield-inner-wrap">
                        <div class="footer-title"><?php echo get_field('footer_shield_title', 'option') ?: 'ZAMOK01 входит в&nbsp;состав АССОСОД'; ?></div>
                        <?php 
                        $shield_img = get_field('footer_shield_image', 'option');
                        if ($shield_img):
                        ?>
                        <div class="elm-photo">
                            <img src="<?php echo esc_url($shield_img['url']); ?>" alt="<?php echo esc_attr($shield_img['alt']); ?>">
                        </div>
                        <?php else: ?>
                        <div class="elm-photo">
                            <img src="<?php echo zamok01_get_image_url('main/shield.png'); ?>" alt="АССОСОД">
                        </div>
                        <?php endif; ?>
                        <div class="footer-title"><?php echo get_field('footer_shield_text', 'option') ?: 'Российская ассоциация специалистов сервисного обслуживания систем ограничения доступа'; ?></div>
                    </div>
                </div>
                <!--/footer-main-panel-->
                <!--footer-bottom-panel-->
                <div class="footer-bottom-panel">
                    <div class="info-wrap wrap-main">
                        <p>@ Copyright <?php echo date('Y'); ?> <a href="<?php echo home_url(); ?>" class="link-main"><?php bloginfo('name'); ?> - вскрытие замков в Москве без повреждений</a></p>
                    </div>
                    <div class="info-inner-wrap">
                        <?php 
                        $privacy = get_field('privacy_policy_link', 'option');
                        $sitemap = get_field('sitemap_link', 'option');
                        $creator = get_field('creator_link', 'option');
                        ?>
                        <?php if ($privacy): ?>
                        <div class="info-wrap">
                            <p><a href="<?php echo esc_url($privacy); ?>">Политика конфиденциальности</a></p>
                        </div>
                        <?php endif; ?>
                        <?php if ($sitemap): ?>
                        <div class="info-wrap">
                            <p><a href="<?php echo esc_url($sitemap); ?>">Карта сайта</a></p>
                        </div>
                        <?php endif; ?>
                        <?php if ($creator): ?>
                        <div class="info-wrap">
                            <p>Создано: <a href="<?php echo esc_url($creator['url']); ?>"><?php echo esc_html($creator['title']); ?></a></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!--/footer-bottom-panel-->
            </div>
        </footer>
        <!-- /footer -->

    </div>
    <!-- /wrap -->

    <!--popup-outer-box-->
    <div class="popup-outer-box" id="popup-callback">
        <div class="popup-box">
            <a href="" class="btn-popup-close btn-action-ico ico-close js-popup-close"></a>
            <div class="popup-content-wrap">
                <form action="/" class="form-box js-callback-form" method="post">
                    <div class="frm-title-wrap">
                        <div class="frm-title h1-title title-small-d">Обратный звонок</div>
                    </div>
                    <div class="frm-content-wrap">
                        <div class="frm-row">
                            <div class="frm-field">
                                <input type="text" class="form-input" name="name" placeholder="Ваше имя" required>
                            </div>
                            <div class="frm-field">
                                <input type="tel" class="form-input js-phone-mask" name="phone" placeholder="+7 (___) ___-__-__" required>
                            </div>
                        </div>
                        <div class="frm-row">
                            <div class="frm-field">
                                <textarea class="form-input" name="message" placeholder="Текст сообщения"></textarea>
                            </div>
                        </div>
                        <div class="frm-row-submit">
                            <div class="frm-field field-info">
                                <div class="frm-select">
                                    <input type="checkbox" id="popup-callback-agree" name="agree" required>
                                    <label for="popup-callback-agree">Даю согласие на обработку <a href="<?php echo get_field('privacy_policy_link', 'option') ?: '#'; ?>" class="link-main">персональных данных</a></label>
                                </div>
                            </div>
                            <div class="frm-field field-submit">
                                <button type="submit" class="btn js-callback-submit">
                                    <div class="button-title">Отправить</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!--/popup-outer-box-->

    <!--popup-outer-box success-->
    <div class="popup-outer-box" id="popup-callback-success">
        <div class="popup-box">
            <a href="" class="btn-popup-close btn-action-ico ico-close js-popup-close"></a>
            <div class="popup-content-wrap">
                <div class="frm-title-wrap">
                    <div class="frm-title h1-title title-small-d">Спасибо!</div>
                </div>
                <div class="frm-content-wrap">
                    <p>Ваша заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.</p>
                </div>
            </div>
        </div>
    </div><!--/popup-outer-box-->

    <?php wp_footer(); ?>
</body>
</html>

