<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage WPRDC
 */
get_header(); ?>
    <div class="content-container">
        <div class="row">
            <div class="large-12 columns">
                <section id="single-post">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <h1><?php the_title(); ?></h1>
                            <hr>
                            <div class="clearfix">
                                <p class="left">
                                    by <?php the_author(); ?>

                                </p>
                                <p class="right">
                                    <?php the_date(); ?>
                                </p>
                            </div>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail-wrapper">
                                    <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
                                </div>
                                <br>
                            <?php endif; ?>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                            <br>
                        </article>
                    <?php endwhile; ?>
                </section>
            </div>
        </div>
    </div>
<?php
get_footer();

