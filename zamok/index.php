<?php get_header(); ?>

<!-- page -->
<div class="page-full">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
</div>
<!-- /page -->

<?php get_footer(); ?>

