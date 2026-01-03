<?php

/**
 * Plugin fallback template for single Casino (CPT: casino)
 * Theme override:
 * - casino-cards-demo/single-casino.php
 * - single-casino.php
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="casino-cards-demo casino-single">
    <?php while (have_posts()) :
        the_post(); ?>
        <div class="content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
</main>

<?php get_footer();
