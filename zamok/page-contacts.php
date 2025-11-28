<?php
/**
 * Template Name: Контакты
 */
get_header(); ?>

<!-- page -->
<div class="page-full">

    <?php zamok01_breadcrumbs(); ?>

    <!--title-box-->
    <div class="title-box">
        <div class="title-wrap">
            <h1 class="h1-title section-title"><?php echo get_field('contacts_title') ?: 'Контакты Zamok01'; ?></h1>
        </div>
    </div>
    <!--/title-box-->

    <!--contacts-box-->
    <div class="contacts-box">
        <div class="info-inner-wrap">
            <p><?php echo get_field('contacts_description') ?: 'Мы работаем по Москве и Московской области.'; ?></p>
            <?php
            $contacts = get_field('contacts');
            if ($contacts):
                foreach ($contacts as $contact):
            ?>
            <div class="info-wrap">
                <div class="info-title"><?php echo esc_html($contact['title']); ?></div>
                <div class="info-value">
                    <?php echo wp_kses_post($contact['value']); ?>
                    <?php if ($contact['link']): ?>
                    </br><a href="<?php echo esc_url($contact['link']); ?>" class="link-main">Посмотреть на карте</a>
                    <?php endif; ?>
                </div>
            </div>
            <p><?php echo $contact['description'] ?></p>
            <?php
                endforeach;
            endif;
            ?>
        </div>
        <div class="form-inner-wrap">
            <!--bg-box-->
            <div class="bg-box">
                <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" class="form-box">
                    <input type="hidden" name="action" value="submit_contact">
                    <?php wp_nonce_field('submit_contact', 'contact_nonce'); ?>
                    <div class="frm-title-wrap">
                        <div class="frm-title h1-title title-small-d">Напишите сообщение</div>
                    </div>
                    <div class="frm-content-wrap">
                        <div class="frm-row">
                            <div class="frm-field field-half">
                                <input type="text" class="form-input" name="contact_name" placeholder="Ваше имя" required>
                            </div>
                            <div class="frm-field field-half">
                                <input type="email" class="form-input" name="contact_email" placeholder="E-mail" required>
                            </div>
                        </div>
                        <div class="frm-row">
                            <div class="frm-field">
                                <textarea class="form-input" name="contact_message" placeholder="Текст сообщения" required></textarea>
                            </div>
                        </div>
                        <div class="frm-row-submit">
                            <div class="frm-field field-info">
                                <div class="frm-select">
                                    <input type="checkbox" id="contact-form" name="contact_consent" required>
                                    <label for="contact-form">Даю согласие на обработку <a href="<?php echo get_field('privacy_policy_link', 'option') ?: '#'; ?>" class="link-main">персональных данных</a></label>
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
        </div>
        <div class="map-inner-wrap">
            <?php 
            $map_code = get_field('map_code');
            if ($map_code):
                echo $map_code;
            else:
            ?>
            <script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=-eov8YMYfEHTrqs_Q1kKzkBJYs6HKSuT&width=100%25&height=100%25&lang=ru_RU&sourceType=constructor"></script>
            <?php endif; ?>
        </div>
    </div>
    <!--/contacts-box-->

    <?php get_template_part('template-parts/faq-block', null, array('link_button_class' => 'button-white')); ?>

</div>
<!-- /page -->

<?php get_footer(); ?>

