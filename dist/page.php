<?php
/**
 * A Template for Single Pages
 *
 * @package WordPress
 * @subpackage WPRDC
 */
get_header(); ?>

<!-- Page Content -->
<div class="content-container">
    <div class="row">
        <?php while (have_posts()) : the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <hr>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail-wrapper">
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
                    </div>
                    <br>
                <?php endif; ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                <br>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
</body>
</html>