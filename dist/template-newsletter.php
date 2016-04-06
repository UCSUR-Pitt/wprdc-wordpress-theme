<?php
/**
 * Template Name: Newsletter Signup
 * The Template for displaying all single posts
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
                    <form class="newsletter" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>"
                          data-abide="ajax" autocomplete="off">
                        <?php wp_nonce_field('newsletter-register'); ?>
                        <div class="row collapse">
                            <div class="small-9 columns">
                                <label for="email">
                                    <input type="email" value="" name="email" placeholder="Your Email Address"
                                           required/>
                                </label>
                                <small class="error">A valid email address is required.</small>
                            </div>
                            <div class="small-3 columns">
                                <input type="submit" class="button postfix" value="Sign Up"/>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
</body>
</html>

